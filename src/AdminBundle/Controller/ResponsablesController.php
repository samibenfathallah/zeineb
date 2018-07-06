<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use Symfony\Component\HttpFoundation\Response;
use AdminBundle\Entity\Responsables;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ResponsablesController extends Controller
{
    public function ListeResponsbalesAction() {
        $responsables = $this->getDoctrine()->getRepository(Responsables::class)->ListeResponsables();
        print_r($responsables);
        echo "jj";
        die();
        //return $this->render('AdminBundle:Default:responsables.html.twig', array('responsables' => $responsables);
    }
}
