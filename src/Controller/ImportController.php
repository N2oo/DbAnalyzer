<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/import')]
class ImportController extends AbstractController
{
    #[Route("/","app_import_index")]
    public function index():Response
    {
        return $this->render("import/index.html.twig",[]);
    }
}
