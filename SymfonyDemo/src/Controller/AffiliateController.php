<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AffiliateController extends AbstractController
{
    /**
     * @Route("/affiliate", name="affiliate")
     */
    public function index()
    {
        return $this->render('affiliate/index.html.twig', [
            'controller_name' => 'AffiliateController',
        ]);
    }

    /**
     * @Route("/createaffiliate", name="create_affiliate")
     */
    public function createAffiliate():Response
    {
        $name = $_GET['name'];
        $entityManager = $this->getDoctrine()->getManager();

        $affiliate = new Affiliate();
        $affiliate->setName($name);

        $entityManager->persist($affiliate);
        $entityManager->flush();

        return new Response('Created affiliate with id '.$affiliate->getId());
    }

    /**
     * @Route("/affiliate/{id}", name="read_affiliate")
     */
    public function readAffiliate($id)
    {
        $affiliate = $this->getDoctrine()->getRepository(Affiliate::class)->find($id);

        if(!$affiliate)
        {
            throw $this->createNotFoundException('No affiliate found with id='.$id);
        }

        return new Response('<h1>'.$affiliate->getName());
    }

        /**
     * @Route("/categories", name="readall_affiliate")
     */
    public function readAllCategories()
    {
        $categories = $this->getDoctrine()->getRepository(Affiliate::class)->findAll();

        if(!$categories)
        {
            throw $this->createNotFoundException('No categories found');
        }

        $nrOfCategories = count($categories);
        $responseMsg='';
        for ($i=0; $i < $nrOfCategories; $i++) { 
            $responseMsg = $responseMsg.$categories[$i]->getName();
        }

        return new Response('<h1>'.$responseMsg);
    }

    /**
     * @Route("/updateaffiliate/{id}", name="update_affiliate")
     */
    public function updateAffiliate($id)
    {
        $newName = $_GET['newName'];
        $entityManager = $this->getDoctrine()->getManager();
        $affiliate = $this->getDoctrine()->getRepository(Affiliate::class)->find($id);

        if(!$affiliate)
        {
            throw $this->createNotFoundException('No affiliate found with id='.$id);
        }

        $affiliate->setName($newName);

        $entityManager->flush();

        return new Response('<h1>'.$affiliate->getName());
    }

    /**
     * @Route("/deleteaffiliate/{id}", name="delete_affiliate")
     */
    public function deleteAffiliate($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $affiliate = $this->getDoctrine()->getRepository(Affiliate::class)->find($id);

        if(!$affiliate)
        {
            throw $this->createNotFoundException('No affiliate found with id='.$id);
        }

        $entityManager->remove($affiliate);
        $entityManager->flush();

        return new Response('<h1> Deleted affiliate with id='.$id);
    }
}
