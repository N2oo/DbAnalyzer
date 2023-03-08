<?php

namespace App\Controller;

use App\Entity\Database;
use App\Form\DatabaseType;
use App\Repository\DatabaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/database')]
class DatabaseController extends AbstractController
{
    #[Route('/', name: 'app_database_index', methods: ['GET'])]
    public function index(DatabaseRepository $databaseRepository): Response
    {
        return $this->render('database/index.html.twig', [
            'databases' => $databaseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_database_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DatabaseRepository $databaseRepository): Response
    {
        $database = new Database();
        $form = $this->createForm(DatabaseType::class, $database);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $databaseRepository->save($database, true);

            return $this->redirectToRoute('app_database_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('database/new.html.twig', [
            'database' => $database,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_database_show', methods: ['GET'])]
    public function show(Database $database,DatabaseRepository $databaseRepository): Response
    {
        //optimisation à faire ici
        return $this->render('database/show.html.twig', [
            'database' => $database,
            'tables'=> $database->getTables(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_database_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Database $database, DatabaseRepository $databaseRepository): Response
    {
        $form = $this->createForm(DatabaseType::class, $database);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $databaseRepository->save($database, true);

            return $this->redirectToRoute('app_database_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('database/edit.html.twig', [
            'database' => $database,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_database_delete', methods: ['POST'])]
    public function delete(Request $request, Database $database, DatabaseRepository $databaseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$database->getId(), $request->request->get('_token'))) {
            $databaseRepository->remove($database, true);
        }

        return $this->redirectToRoute('app_database_index', [], Response::HTTP_SEE_OTHER);
    }

}
