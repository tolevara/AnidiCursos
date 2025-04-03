<?php

namespace App\Controller;

use App\Entity\Aulas;
use App\Entity\Cursos;
use App\Repository\AulasRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AulasController extends AbstractController
{
    #[Route('/aulas', name: 'app_aulas')]
    public function index(): Response
    {
        return $this->render('aulas/index.html.twig', [
            'controller_name' => 'AulasController',
        ]);
    }

    //C3 -> INSERTAR VARIOS REGISTROS (array) POR CÓDIGOS
    #[Route('/crear-aulas', name: 'app_aulas_insertar_aulas')]
    public function crearAulas(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        //DEFINIMOS EL ARRAY DE AULAS//
        $aulas = [
            "aula1" => [
                "codigo" => "1.5",
                "capacidad" => 15,
                "adaptado" => 1
            ],
            "aula2" => [
                "codigo" => "1.6",
                "capacidad" => 10,
                "adaptado" => 0
            ],
            "aula3" => [
                "codigo" => "1.7",
                "capacidad" => 15,
                "adaptado" => 1
            ],
        ];

        //USO FOREACH PARA RECORRER EL ARRAY, Y METO EN LA TABLA AULA POR AULA
        foreach ($aulas as $aula) {
            $nuevaAula = new Aulas();
            $nuevaAula->setCodigo($aula['codigo']);
            $nuevaAula->setCapacidad($aula['capacidad']);
            $nuevaAula->setAdaptado($aula['adaptado']);

            
            $entityManager->persist($nuevaAula);
            $entityManager->flush();
        }
        return new Response("<h2> Aulas metidas </h2>");
    }


    // R3a -> CONSULTAR POR CLAVE PRINCIPAL
    // PONGO ESTA RUTA EN EL routes.yaml /mostrar-aula/{id}
    #[Route('/ver-aulas/{codigo}', name: 'app_aulas_ver_aula')]
    public function verAula(AulasRepository $repositorio, float $codigo): Response
    {
        $aula = $repositorio->find($codigo);

        return $this->render('aulas/aulas.html.twig', [
            'controller_name' => 'AulasController',
            'aulas' => [$aula], //<-ESTO ES UN array DE UN SOLO ELEMENTO
        ]);
    }
}
