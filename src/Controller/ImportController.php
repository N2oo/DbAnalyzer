<?php

namespace App\Controller;

use App\Service\JsonHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/import')]
class ImportController extends AbstractController
{
    public function __construct(private JsonHandler $handler)
    {

    }

    #[Route("/","app_import_index")]
    public function index():Response
    {
        $jsonFilePath = $this->getParameter('kernel.project_dir')."/public/json_extract_bvsodbc_systables.json";
        $jsonFilePath = $this->getParameter('kernel.project_dir')."/public/sample.json";
        $result = $this->handler->handleFile($jsonFilePath);
        dump($result);
        return $this->render("import/index.html.twig",[]);
    }
}
