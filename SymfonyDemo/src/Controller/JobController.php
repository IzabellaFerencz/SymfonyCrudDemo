<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    /**
     * @Route("/job", name="job")
     */
    public function index()
    {
        return $this->render('job/index.html.twig', [
            'controller_name' => 'JobController',
        ]);
    }
     
    /**
     * @Route("/createjob", name="create_job")
     */
    public function createJob():Response
    {
        $name = $_GET['name'];
        $entityManager = $this->getDoctrine()->getManager();

        $job = new Job();
        $job->setName($name);

        $entityManager->persist($job);
        $entityManager->flush();

        return new Response('Created job with id '.$job->getId());
    }

    /**
     * @Route("/job/{id}", name="read_job")
     */
    public function readJob($id)
    {
        $job = $this->getDoctrine()->getRepository(Job::class)->find($id);

        if(!$job)
        {
            throw $this->createNotFoundException('No job found with id='.$id);
        }

        return new Response('<h1>'.$job->getName());
    }

        /**
     * @Route("/categories", name="readall_job")
     */
    public function readAllCategories()
    {
        $categories = $this->getDoctrine()->getRepository(Job::class)->findAll();

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
     * @Route("/updatejob/{id}", name="update_job")
     */
    public function updateJob($id)
    {
        $newName = $_GET['newName'];
        $entityManager = $this->getDoctrine()->getManager();
        $job = $this->getDoctrine()->getRepository(Job::class)->find($id);

        if(!$job)
        {
            throw $this->createNotFoundException('No job found with id='.$id);
        }

        $job->setName($newName);

        $entityManager->flush();

        return new Response('<h1>'.$job->getName());
    }

    /**
     * @Route("/deletejob/{id}", name="delete_job")
     */
    public function deleteJob($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $job = $this->getDoctrine()->getRepository(Job::class)->find($id);

        if(!$job)
        {
            throw $this->createNotFoundException('No job found with id='.$id);
        }

        $entityManager->remove($job);
        $entityManager->flush();

        return new Response('<h1> Deleted job with id='.$id);
    }
}
