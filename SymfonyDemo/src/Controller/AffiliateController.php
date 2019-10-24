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
     * @Route("/newaffiliate", name="new_affiliate")
     */
    public function newAffiliate()
    {
        return $this->render('affiliate/createaffiliate.html.twig', [
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
        $affiliate->setCreatedAt(\DateTime::createFromFormat('Y-m-d', date("Y-m-d")));

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

       // return new Response('<h1>'.$affiliate->toString());
       return $this->render('affiliate/affiliate.html.twig', [
        'affiliate' => $affiliate,
        ]);
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

        return $this->render('affiliate/affiliates.html.twig', [
            'affiliates'=>$affiliates
            ]);
    }

    /**
     * @Route("/editaffiliate/{id}", name="edit_affiliate")
     */
    public function editAffiliate($id)
    {
        $affiliate = $this->getDoctrine()->getRepository(Affiliate::class)->find($id);

        if(!$affiliate)
        {
            throw $this->createNotFoundException('No affiliate found with id='.$id);
        }
        return $this->render('affiliate/editaffiliate.html.twig', [
            'affiliate' => $affiliate,
        ]);
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

        return new Response('<h1> Updated affiliate with id='.$affiliate->getId());
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
