<?php

namespace App\Controller;

use App\Entity\Table;
use App\Service\TableFinder;
use App\Form\SearchTableType;
use App\Entity\ValueObject\SearchTableQuery;
use App\Service\Builder\Factory\SearchTableStrategyFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/table")]
class TableController extends AbstractController
{
    public function __construct(
        private readonly TableFinder $tableFinder,
        private readonly SearchTableStrategyFactory $searchTableStrategyFactory
    )
    {

    }

    #[Route('/', name: 'app_table_index')]
    public function index(Request $request): Response
    {
        $searchTableQuery = new SearchTableQuery();
        $form = $this->createForm(SearchTableType::class,$searchTableQuery);
        $form->handleRequest($request);
        $all_tables = $this->searchTableStrategyFactory->getStrategy($searchTableQuery)->find();
        return $this->render('table/index.html.twig', [
            'tables' => $all_tables,
            'searchTableForm'=>$form
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
