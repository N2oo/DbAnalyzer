<?php

namespace App\Controller;

use App\Form\ImportFormType;
use App\Service\CsvHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{
    #[Route('/import', name: 'app_import_index')]
    public function index(): Response
    {
        return $this->render('import/index.html.twig', [
            'controller_name' => 'ImportController',
        ]);
    }

    #[Route('/import/download', name: 'app_import_download')]
    public function downloadCsv(CsvHandler $csvHandler): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="tables.csv"');
        $response->setContent($csvHandler->generateCsvFileHeader());
        return $response;
    }

    #[Route('/import/submit', name: 'app_import')]
    public function importTable(Request $request, CsvHandler $csvHandler): Response
    {
        $form = $this->createForm(ImportFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $form->get('csv_file')->getData();
            [$message,$status] = $csvHandler->handleFile($file);
            $this->addFlash($status, $message);
        }

        return $this->render('import/import.html.twig', [
            'form' => $form,
        ]);
    }
}
