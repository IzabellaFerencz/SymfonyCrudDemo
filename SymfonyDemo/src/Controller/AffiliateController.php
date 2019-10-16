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
}
