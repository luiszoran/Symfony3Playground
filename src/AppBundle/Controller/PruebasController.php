<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Curso;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PruebasController extends Controller {

    public function indexAction(Request $request, $name, $page) {
        $productos = array(
            array("producto" => "Consola 1", "precio" => 1),
            array("producto" => "Consola 2", "precio" => 2),
            array("producto" => "Consola 3", "precio" => 3),
            array("producto" => "Consola 4", "precio" => 4),
            array("producto" => "Consola 5", "precio" => 5)
        );

        // replace this example code with whatever you need
        return $this->render('AppBundle:pruebas:index.html.twig', [
            'texto' => $name . ' ' . $page,
            'productos' => $productos
        ]);
    }

    public function createAction() {
        $curso = new Curso();
        $curso->setTitulo("Curso de Symfony 3");
        $curso->setDescripcion("Maravilloso curso de Symfony");
        $curso->setPrecio(80);

        $em = $this->getDoctrine()->getManager();
        $em->persist($curso);
        $flush = $em->flush();

        if ($flush != null) {
            echo "Error al crear el curso";
        } else {
            echo "Curso creado correctamente.";
        }

        die();
    }

    public function readAction() {
        $em = $this->getDoctrine()->getManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");
        $cursos = $cursos_repo->findAll();

        foreach ($cursos as $curso) {
            echo $curso->getTitulo() . "</br>";
            echo $curso->getDescripcion() . "</br>";
            echo $curso->getPrecio() . "</br></hr>";
        }

        die();
    }

    public function updateAction($id, $titulo, $descripcion, $precio) {
        $em = $this->getDoctrine()->getManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");

        $curso = $cursos_repo->find($id);
        $curso->setTitulo($titulo);
        $curso->setDescripcion($descripcion);
        $curso->setPrecio($precio);

        $em->persist($curso);
        $flush = $em->flush();

        if ($flush != null) {
            echo "Error al actualizar el curso";
        } else {
            echo "Curso actualizado correctamente.";
        }

        die();
    }

    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");

        $curso = $cursos_repo->find($id);

        $em->remove($curso);
        $flush = $em->flush();

        if ($flush != null) {
            echo "Error al borrar el curso";
        } else {
            echo "Curso borrado correctamente.";
        }

        die();
    }

    public function findByPriceAction($precio) {
        $em = $this->getDoctrine()->getManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");
        //$cursos = $cursos_repo->findBy(array("precio"=>$precio));
        $curso = $cursos_repo->findOneByPrecio($precio);
        echo $curso->getTitulo() . "</br>";
        echo $curso->getDescripcion() . "</br>";
        echo $curso->getPrecio() . "</br></hr>";

        /*       foreach($cursos as $curso){
                   echo $curso->getTitulo()."</br>";
                   echo $curso->getDescripcion()."</br>";
                   echo $curso->getPrecio()."</br></hr>";
               }
       */
        die();
    }

    public function nativeSqlAction() {
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();

        $query = "SELECT * FROM cursos";
        $stmt = $db->prepare($query);
        $stmt->execute(array());
        $cursos = $stmt->fetchAll();

        foreach ($cursos as $curso) {
            echo $curso["titulo"] . "</br>";
            echo $curso["descripcion"] . "</br>";
            echo $curso["precio"] . "</br></hr>";
        }

        die();
    }

    public function nativeDqlAction() {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("SELECT c FROM AppBundle:Curso c
                  WHERE c.precio > :precio")->setParameter("precio", "79");

        $cursos = $query->getResult();

        foreach ($cursos as $curso) {
            echo $curso->getTitulo() . "</br>";
            echo $curso->getDescripcion() . "</br>";
            echo $curso->getPrecio() . "</br></hr>";
        }

        die();
    }

    public function queryBuilderAction() {
        $em = $this->getDoctrine()->getManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");

        $query = $cursos_repo->createQueryBuilder("c")
            ->where("c.precio > :precio")
            ->setParameter("precio", "79")
            ->getQuery();

        $cursos = $query->getResult();

        foreach ($cursos as $curso) {
            echo $curso->getTitulo() . "</br>";
            echo $curso->getDescripcion() . "</br>";
            echo $curso->getPrecio() . "</br></hr>";
        }

        die();
    }

    public function queryThroughRepoAction() {
        $em = $this->getDoctrine()->getManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");
        $cursos = $cursos_repo->getCursos();

        foreach ($cursos as $curso) {
            echo $curso->getTitulo() . "</br>";
            echo $curso->getDescripcion() . "</br>";
            echo $curso->getPrecio() . "</br></hr>";
        }

        die();
    }
}
