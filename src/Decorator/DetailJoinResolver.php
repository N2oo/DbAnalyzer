<?php

namespace App\Decorator;

use App\Entity\Table;
use App\Entity\DbUser;
use App\Entity\Detail;
use ApiPlatform\Metadata\Operation;
use App\Repository\TableRepository;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\DTO\Detail\DetailMultipleDTO;
use App\Repository\DbUserRepository;
use App\Service\Processor\DetailMultipleProcessor;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(DetailMultipleProcessor::class)]
class DetailJoinResolver implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $inner,
        private TableRepository $tableRepository,
        private DbUserRepository $dbUserRepository
    ) {
    }

    /**
     * @param Detail[] $elements
     */
    public function resolveTableJoin(array $elements){
        /** @var Detail $element */
        $extractFileNameCallback = (function ($element) {
            return $element->getFilename();
        });
    
        $fileNames_list = array_unique(array_map($extractFileNameCallback, $elements));
        $finded_tables = $this->tableRepository->findByFilenames($fileNames_list);
        if(!empty($finded_tables)){
            $this->hydrateTables($elements,$finded_tables);
        }
    }
    /**
     * @param Detail[] $elements
     */
    public function resolveUserJoin(array $elements){
        /** @var Detail $element */
        $extractFolderCallback = (function ($element) {
            return $element->getClearFolder();
        });

        $folders_list = array_unique(array_map($extractFolderCallback,$elements));
        $finded_users = $this->dbUserRepository->findByHomeFolders($folders_list);
        if(!empty($finded_users)){
            $this->hydrateDetails($finded_users,$elements);
        }
    }

    public function resolveJoins(DetailMultipleDTO $data)
    {
        $elements = $data->getDetails();
        $this->resolveUserJoin($elements);
        $this->resolveTableJoin($elements);
    }

    /**
     * @param DbUser[] $users
     * @param Detail[] $details
     */
    public function hydrateDetails(array $users,array $details)
    {
        foreach($details as $detail){
            foreach($users as $user){
                $needle = $user->getHomeFolder();
                //Si le homefolder de l'utilisateur + "/" est contenu dans detail (folder)
                if(str_contains($detail->getFolder(),$needle)){
                    $detail->addUser($user);
                }
            }
        }
    }

    /**
     * @param Detail[] $details
     * @param Table[] $findedTables
     */
    public function hydrateTables(array $details,array $findedTables){
        foreach($findedTables as $table){
            foreach($details as $detail){
                if($detail->getFilename() == $table->getDbFileName()){
                    $table->addDetail($detail);
                }
            }
        }
    }

    /**
     * @param DetailMultipleDTO $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->resolveJoins($data);
        return $this->inner->process($data, $operation, $uriVariables, $context);
    }
}