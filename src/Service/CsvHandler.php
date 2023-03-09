<?php
namespace App\Service;
use App\Entity\Database;
use App\Entity\Field;
use App\Entity\Table;
use App\Repository\DatabaseRepository;
use App\Repository\TableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CsvHandler{
    private array $csv_labels = [
        'db_name',//0
        'table_id',//1
        'table_name',//2
        'table_is_view',//3
        'table_sql_query',//4
        'field_id',//5
        'field_name',//6
        'field_type',//7
        'field_length',//8
        'field_is_primary',//9
    ];
    public function __construct(
        private EntityManagerInterface $em,
        private TableRepository $tableRepository,
        private DatabaseRepository $databaseRepository,
    ){}

    public function generateCsvFileHeader():string
    {
        return implode(';', $this->csv_labels);
    }

    /**
     * Pour des performances optimales, le csv doit être trié par db_name, table_name, table_sql_query
     * @param UploadedFile $file
     * @return string[]
     */
    public function handleFile(UploadedFile $file): array
    {
        $fp = fopen($file,'r');
        //paramètres de boucle
        $missing_label = "";
        $firstRow = true;
        $labels = [];
        $previous_db = null;
        $previous_table = null;
        $csv_is_valid = true;
        $row_count = 0;
        while($row = fgetcsv($fp, 20000, ';')){
            if($firstRow){
                $labels = $row;
                $firstRow = false;
                foreach($this->csv_labels as $required_label){
                    if(!in_array($required_label, $labels)){
                        $missing_label = $required_label;
                        $csv_is_valid = false;
                        break 2;
                    }
                }
                continue;
            }

            if ($previous_db === null || $previous_db->getName() != $row[array_search($this->csv_labels[0], $labels)]) {//dbname
                //on cherche la base de données, si elle n'exite pas on la crée
                $previous_db = $this->databaseRepository->findOneBy([
                    'name' => $row[array_search('db_name', $labels)],
                ]);
                if ($previous_db === null) {
                    $previous_db = new Database();
                    $previous_db->setName($row[array_search($this->csv_labels[0], $labels)]);
                    $this->em->persist($previous_db);
                    $this->em->flush();
                }
            }
            if ($previous_table === null || $previous_table->getName() != $row[array_search($this->csv_labels[2], $labels)]) {//tablename
                //on cherche la table, si elle n'exite pas on la crée
                $previous_table = $this->tableRepository->findOneBy([
                    'name' => $row[array_search('table_name', $labels)],
                ]);
                if ($previous_table === null) {
                    $previous_table = new Table();
                    $previous_table->setTableOriginalId($row[array_search($this->csv_labels[1], $labels)]);//table_id
                    $previous_table->setName($row[array_search($this->csv_labels[2], $labels)]);//tablename
                    $previous_table->setIsView($row[array_search($this->csv_labels[3], $labels)]);//table_is_view
                    $previous_table->setQuery($row[array_search($this->csv_labels[4], $labels)]);//table_sql_query
                    $previous_table->setForDb($previous_db);
                    $this->em->persist($previous_table);
                    $this->em->flush();
                }
            }
            $field = new Field();
            $field->setFieldOriginalId($row[array_search($this->csv_labels[5], $labels)])//field_id
                    ->setName($row[array_search($this->csv_labels[6], $labels)])//field_name
                    ->setType($row[array_search($this->csv_labels[7], $labels)])//field_type
                    ->setLength($row[array_search($this->csv_labels[8], $labels)])//field_length
                    ->setIsPrimary($row[array_search($this->csv_labels[9], $labels)])//field_is_primary
                    ->setForTable($previous_table);
            $this->em->persist($field);
            if($row_count % 1000){
                $this->em->flush();
                $this->em->clear();
                $previous_db = null;
                $previous_table = null;
                $row_count = 0;
            }
            $row_count++;
        }
        if ($csv_is_valid){
            $this->em->flush();
            $message = "Le fichier a été importé avec succès";
            $status = "success";
        }else{
            $message = "Le fichier n'a pas pu être importé en raison de l'absence du champ ".$missing_label;
            $status = "error";
        }
        $this->em->clear();
        return [$message, $status];

    }

}