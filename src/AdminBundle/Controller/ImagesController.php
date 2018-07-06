<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Entity\Images;
use AdminBundle\Entity\Bloc;

/**
 * Description of ImagesController
 *
 * @author sawssen
 */
class ImagesController extends Controller {

    //put your code here
    public function imageslisteAction() {
        $images = $this->getDoctrine()->getRepository(Images::class)->ListeImages();
        return $this->render('AdminBundle:Default:image.html.twig', array('images' => $images));
    }

    public function addimageAction() {
        $blocs = $this->getDoctrine()->getRepository(Bloc::class)->findAll();
        return $this->render('AdminBundle:Default:formaddimage.html.twig', array('blocs' => $blocs));
    }

    public function valideimageAction() {

        $target_dir = "uploads/";
        $datetime = new \DateTime();

        $target_file = $target_dir . $datetime->getTimestamp() . $_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $em = $this->getDoctrine()->getManager();

        // var_dump($_POST);die;
        $image = new Images();
        $image->setDescription($_POST['description']);
        $bloc = $this->getDoctrine()->getRepository(Bloc::class)->findOneById($_POST['bloc']);
        $image->setBloc($bloc);
        $image->setImage($datetime->getTimestamp() . $_FILES['image']['name']);




        $em->persist($image);
        $em->flush();


        $images = $this->getDoctrine()->getRepository(Images::class)->ListeImages();
        /* print_r($services);
          die(); */
        return $this->render('AdminBundle:Default:image.html.twig', array('images' => $images, 'valideadd' => '1'));
    }

    public function deleteimageAction() {
        $target_dir = "uploads/";
        $em = $this->getDoctrine()->getManager();
        $image = $this->getDoctrine()->getRepository(Images::class)->findOneById($_GET['id']);

        unlink($target_dir . $image->getImage());
        $em->remove($image);
        $em->flush();

        $images = $this->getDoctrine()->getRepository(Images::class)->ListeImages();
        /* print_r($services);
          die(); */
        return $this->render('AdminBundle:Default:image.html.twig', array('images' => $images, 'validesupp' => '1'));
    }

    public function editimageAction() {
        $image = $this->getDoctrine()->getRepository(Images::class)->findOneById($_GET['id']);
        $blocselect = $this->getDoctrine()->getRepository(Bloc::class)->findOneById($image->getBloc());
        $blocs = $this->getDoctrine()->getRepository(Bloc::class)->findAll();
        return $this->render('AdminBundle:Default:formeditimage.html.twig', array('image' => $image, 'blocs' => $blocs, 'blocselect' => $blocselect));
    }

    public function valideeditimageAction() {
        $em = $this->getDoctrine()->getManager();
        $image = $this->getDoctrine()->getRepository(Images::class)->findOneById($_POST['idimage']);
        $image->setDescription($_POST['description']);
        if(!empty($_FILES["image"]['tmp_name'])){
        $datetime = new \DateTime();
        $target_dir = "uploads/";
        unlink($target_dir . $image->getImage());
        $target_file = $target_dir . $datetime->getTimestamp() . $_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image->setImage($datetime->getTimestamp() . $_FILES['image']['name']);
        }
        $bloc = $this->getDoctrine()->getRepository(Bloc::class)->findOneById($_POST['bloc']);
        $image->setBloc($bloc);
        



        $em->persist($image);
        $em->flush();
        $images = $this->getDoctrine()->getRepository(Images::class)->ListeImages();
        return $this->render('AdminBundle:Default:image.html.twig', array('images' => $images));
    }

}
