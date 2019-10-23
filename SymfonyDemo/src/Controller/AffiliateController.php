<?php

namespace App\Controller;

use App\Entity\Affiliate; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

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
        $url = $_GET['url'];
        $email = $_GET['email'];
        $token = $_GET['token'];
        $isActivated = $_GET['isActivated'];

        $entityManager = $this->getDoctrine()->getManager();

        $affiliate = new Affiliate();
        $affiliate->setUrl($url);
        $affiliate->setEmail($email);
        $affiliate->setToken($token);
        $affiliate->setIsActivate($isActivated);
        $affiliate->setCreatedAt(null);

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

        return new Response('<h1>'.$affiliate->toString());
    }

        /**
     * @Route("/affiliates", name="readall_affiliate")
     */
    public function readAllAffiliates()
    {
        $affiliates = $this->getDoctrine()->getRepository(Affiliate::class)->findAll();

        if(!$affiliates)
        {
            throw $this->createNotFoundException('No affiliates found');
        }

        $nrOfAffiliates = count($affiliates);
        $responseMsg='';
        for ($i=0; $i < $nrOfAffiliates; $i++) { 
            $responseMsg = $responseMsg.'<h1>'.$affiliates[$i]->toString().'</h1>';
        }

        return new Response($responseMsg);
    }

    /**
     * @Route("/updateaffiliate/{id}", name="update_affiliate")
     */
    public function updateAffiliate($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $affiliate = $this->getDoctrine()->getRepository(Affiliate::class)->find($id);
        
        if(!$affiliate)
        {
            throw $this->createNotFoundException('No affiliate found with id='.$id);
        }

        try {
            $url = $_GET['url'];
            if($url != null)
            {
                $affiliate->setUrl($url);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            $email = $_GET['email'];
            if($email != null)
            {
                $affiliate->setEmail($email);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            $token = $_GET['token'];
            if($token != null)
            {
                $affiliate->setToken($token);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            $isActivated = $_GET['isActivated'];
            if($isActivated != null)
            {
                $affiliate->setIsActivate($isActivated);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        $entityManager->flush();

        return new Response('<h1>'.$affiliate->toString());
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
