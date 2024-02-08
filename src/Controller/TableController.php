<?php

namespace App\Controller;

use App\Entity\Table;
use App\Service\TableFinder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/table")]
class TableController extends AbstractController
{

    public function __construct(private readonly TableFinder $tableFinder)
    {

    }

    #[Route('/', name: 'app_table_index')]
    public function index(): Response
    {
        $all_tables = $this->tableFinder->findAllTablesAndHydrateJoins();
        return $this->render('table/index.html.twig', [
            'tables' => $all_tables,
        ]);
    }

    #[Route('/{id}',name: 'app_table_show')]
    public function show(Table $table)
    {
        $this->tableFinder->hydrateSingleTable($table);
        return $this->render('table/show.html.twig',[
            'table'=>$table
        ]);
    }
}
