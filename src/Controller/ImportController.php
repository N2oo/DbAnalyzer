<?php

namespace App\Controller;

use App\Entity\Field;
use App\Entity\Table;
use App\Form\ImportFieldFormType;
use App\Form\ImportTableFormType;
use App\Repository\TableRepository;
use App\Service\CsvHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\CsvEncoder;

class ImportController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {

    }

    #[Route('/import', name: 'app_import')]
    public function index(): Response
    {
        return $this->render('import/index.html.twig', [
            'controller_name' => 'ImportController',
        ]);
    }

    #[Route('/import/table/download', name: 'app_import_table_download')]
    public function downloadTableCsv(CsvHandler $csvHandler): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="tables.csv"');
        $response->setContent($csvHandler->generateCsvFileHeader(Table::class));
        return $response;
    }
    #[Route('/import/field/download', name: 'app_import_field_download')]
    public function downloadFieldCsv(CsvHandler $csvHandler): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="fields.csv"');
        $response->setContent($csvHandler->generateCsvFileHeader(Field::class));
        return $response;
    }

    #[Route('/import/table', name: 'app_import_table')]
    public function importTable(Request $request, CsvHandler $csvHandler): Response
    {
        $form = $this->createForm(ImportTableFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $form->get('csv_file')->getData();
            [$message,$status] = $csvHandler->handleFile($file, Table::class);
            $this->addFlash($status, $message);
        }

        return $this->render('import/table.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/import/field', name: 'app_import_field')]
    public function importField(Request $request, CsvHandler $csvHandler): Response
    {
        $form = $this->createForm(ImportFieldFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('csv_file')->getData();
            [$message,$status] = $csvHandler->handleFile($file, Field::class);
            $this->addFlash($status, $message);
        }
        return $this->render('import/field.html.twig', [
            'form' => $form,
        ]);
    }
}
