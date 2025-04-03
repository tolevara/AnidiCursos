<?php

namespace App\Controller;

use App\Entity\Aulas;
use App\Entity\Cursos;
use App\Repository\CursosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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

    // C4 -> INSERTAR UN REGISTRO POR PARÁMETROS
    // VARIANTE C2. CONTROLAMOS DATOS TABLA PRINCIPAL 
    #[Route('/crea-curso/{expediente}/{denominacion}/{codAula}', 
    name: 'app_cursos_insertar_curso')]
    public function creaCurso(
        ManagerRegistry $doctrine,
        string $expediente,
        string $denominacion,
        float $codAula
    ): Response {
        $entityManager = $doctrine->getManager();

        $nuevoCurso = new Cursos();
        $nuevoCurso->setExpediente($expediente);
        $nuevoCurso->setDenominacion($denominacion);

        //TENGO QUE PONER EL DATO DE LA TABLA PRINCIPAL, USO EL REPOSITORIO DE AUTORES(tabla principal)
        $aula = $entityManager->getRepository(Aulas::class)->find($codAula);

        //VAMOS A CONTROLAR QUE EL NIF EXISTENTE//

        $mensaje = "";

        if ($aula == null) {
            $mensaje = "ERROR!! No existe el aula";
        } else {
            $nuevoCurso->setCodAula($aula);
            $entityManager->persist($nuevoCurso);
            $entityManager->flush();
            $mensaje = "EXITO!! Se ha introducido el curso.";
        }
        return new Response("<h2> $mensaje </h2>");
    }

    // R2 -> CONSULTAR COMPLETO TABLA RELACIONADA CON BOOTSTRAP
    // OJO!! MIRAR EL TWIG aticulos.html.twig!!
    #[Route('/ver-cursos', name: 'app_cursos_ver')]
    public function verCursos(CursosRepository $repositorio): Response
    {
        $cursos = $repositorio->findAll();

        return $this->render('cursos/cursos.html.twig', [
            'controller_name' => 'CursosController',
            'cursos' => $cursos, //<-ESTO ES UN arry DE VARIOS ELEMENTOS
        ]);
    }

    // D1 ELIMINAR POR ID (TABLA RELACIONADA)
    #[Route(
        '/cursos-borrar/{expediente}',
        name: 'app_cursos_borrar'
    )]
    public function borrarCurso(
        EntityManagerInterface $entityManager,
        string $expediente
    ): Response {
        // BUSCO EL CURSO
        $repositorioCursos = $entityManager->getRepository(Cursos::class);
        $curso = $repositorioCursos->find($expediente);

        if ($curso == null) {
            return new Response("<h1> Curso No encontrado <h1>");
        } else {
            $entityManager->remove($curso);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cursos_ver', [
            'controller_name' => 'Curso Borrado',
        ]);
    }
}
