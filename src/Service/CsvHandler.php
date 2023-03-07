<?php
namespace App\Service;
use App\Entity\Field;
use App\Entity\Table;
use App\Repository\DatabaseRepository;
use App\Repository\FieldRepository;
use App\Repository\TableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CsvHandler{
    private array $field_csv_labels = [
        'table_name',
        'field_name',
        'field_type',
        'field_length',
        'field_is_primary',
    ];
    private array $table_csv_labels = [
        'db_name',
        'table_name',
        'table_is_view',
    ];
    public function __construct(
        private EntityManagerInterface $em,
        private TableRepository $tableRepository,
        private DatabaseRepository $databaseRepository,
    ){

    }

    private function create_entity($row, $labels, $previous_table,$class){
        if($class === 'App\Entity\Field'){
            $entity = $this->create_field($row, $labels, $previous_table);
        }else{
            $entity = $this->create_table($row, $labels, $previous_table);
        }
        return $entity;
    }

    public function handleFile(UploadedFile $file, $class){
        $fp = fopen($file,'r');

        //paramètres de boucle
        $missing_label = "";
        $firstRow = true;
        $labels = [];
        $previous_entity = null;
        $csv_is_valid = true;
        [$repository, $field_to_match,$required_labels,$field_in_csv] = $this->generateMetadatas($class);
        while($row = fgetcsv($fp, 1000, ';')){
            if($firstRow){
                $labels = $row;
                $firstRow = false;
                foreach($required_labels as $required_label){
                    if(!in_array($required_label, $labels)){
                        $missing_label = $required_label;
                        $csv_is_valid = false;
                        break 2;
                    }
                }
                continue;
            }
            //Evite les execution de requetes SQL superflues
            if ($previous_entity === null || $previous_entity->getName() != $row[array_search($field_in_csv, $labels)]) {
                $previous_entity = $repository->findOneBy([
                    $field_to_match => $row[array_search($field_in_csv, $labels)],
                ]);
                //todo : il faut renvoyer un message d'erreur car la table n'existe pas
                // faire un break et ajouter une valeur dans une variable particulière dédiée
            }
            $entity = $this->create_entity($row, $labels, $previous_entity,$class);
            $this->em->persist($entity);
        }
        if ($csv_is_valid){
            $this->em->flush();
            $message = "Le fichier a été importé avec succès";
            $status = "success";
        }else{
            $message = "Le fichier n'a pas pu être importé en raison de l'absence du champ ".$missing_label;
            $status = "error";
        }
        return [$message, $status];

    }

    public function generateCsvFileHeader($class){
        if($class === 'App\Entity\Field'){
            return implode(';',$this->field_csv_labels);
        }else{
            return implode(';',$this->table_csv_labels);
        }

    }

    private function create_table($row, $labels, $previous_database){
       return (new Table())
           ->setName($row[array_search($this->table_csv_labels[1], $labels)])//table_name
           ->setForDb($previous_database)
           ->setIsView($row[array_search($this->table_csv_labels[2], $labels)]);//table_is_view

    }

    private function create_field($row, $labels, $previous_table){
        return (new Field())
            ->setName($row[array_search($this->field_csv_labels[1], $labels)])//field_name
            ->setForTable($previous_table)
            ->setType($row[array_search($this->field_csv_labels[2], $labels)])//field_type
            ->setLength($row[array_search($this->field_csv_labels[3], $labels)])//field_length
            ->setIsPrimary($row[array_search($this->field_csv_labels[4], $labels)]);//field_is_primary
    }

    private function generateMetadatas($class){
        if($class === 'App\Entity\Field'){
            return [
                $this->tableRepository,
                'name',
                $this->field_csv_labels,
                $this->field_csv_labels[0]//table_name
            ];
        }else{
            return [
                $this->databaseRepository,
                'name',
                $this->table_csv_labels,
                $this->table_csv_labels[0]//db_name
            ];
        }
    }

}