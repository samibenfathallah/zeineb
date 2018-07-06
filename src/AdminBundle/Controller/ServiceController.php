<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

use AdminBundle\Entity\Services;



/**
 * Description of ServiceController
 *
 * @author sawssen
 */
class ServiceController extends Controller {
    public function serviceAction()
    {
       $services = $this->getDoctrine()->getRepository(Services::class)->findAll();
       /*print_r($services);
       die();*/
        return $this->render('AdminBundle:Default:service.html.twig',array('services'=>$services));
        
    }
    
    public function servicecreateAction() {

        $em = $this->getDoctrine()->getManager();

        // var_dump($_POST);die;
        $service = new Services();
        $service->setDescription($_POST['service']);
        

        

        $em->persist($service);
        $em->flush();


        return new Response(200);
    }
    
    public function servicedeleteAction() {

        $em = $this->getDoctrine()->getManager();
        $service = $this->getDoctrine()->getRepository(Services::class)->findOneById($_POST['serviceid']);
        $em->remove($service);
        $em->flush();

        return new Response(200);
    }
    
    public function serviceeditAction() {

        $em = $this->getDoctrine()->getManager();
        $service = $this->getDoctrine()->getRepository(Services::class)->findOneById($_POST['serviceid']);
        $service->setDescription($_POST['service']);
        

        

        $em->persist($service);
        $em->flush();

        return new Response(200);
    }
}
