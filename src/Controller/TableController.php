<?php

namespace App\Controller;

use App\Entity\Table;
use App\Service\TableFinder;
use App\Form\SearchTableType;
use App\Entity\ValueObject\SearchTableQuery;
use App\Form\TableAndColumnCommentType;
use App\Repository\DetailRepository;
use App\Service\Builder\Factory\SearchTableStrategyFactory;
use App\Service\Finder\dbUserFinder;
use App\Service\Finder\DetailFinder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/table")]
class TableController extends AbstractController
{
    public function __construct(
        private readonly TableFinder $tableFinder,
        private readonly DetailFinder $detailFinder,
        private readonly dbUserFinder $dbUserFinder,
        private readonly SearchTableStrategyFactory $searchTableStrategyFactory,
        private readonly EntityManagerInterface $entityManager
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
        $details = $this->detailFinder->findByTabId($table,true);
        $users = $this->dbUserFinder->findUserCanAccessTable($table);
        $this->tableFinder->hydrateSingleTable($table);
        return $this->render('table/show.html.twig',[
            'table'=>$table,
            'details'=>$details,
            'users'=>$users
        ]);
    }

    #[Route('/{id}/edit',name:'app_table_edit')]
    public function edit(Table $table,Request $request)
    {
        $form = $this->createForm(TableAndColumnCommentType::class,$table);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->flush();
            return $this->redirectToRoute('app_table_show',['id'=>$table->getId()]);
        }
        return $this->render('table/edit.html.twig',[
            'form'=>$form
        ]);
    }
}
