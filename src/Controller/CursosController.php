<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CursosController extends AbstractController
{
    #[Route('/cursos', name: 'app_cursos')]
    public function index(): Response
    {
        return $this->render('cursos/index.html.twig', [
            'controller_name' => 'CursosController',
        ]);
    }
}
