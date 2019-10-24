<?php

namespace App\Controller;

use App\Entity\Job; 
use App\Entity\Category; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("/newjob", name="new_job")
     */
    public function newJob()
    {
        return $this->render('job/createjob.html.twig', [
        ]);
    }
     
    /**
     * @Route("/createjob", name="create_job")
     */
    public function createJob():Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $job = new Job();

        $categoryid = $_GET['categoryid'];
        $category = $this->getDoctrine()->getRepository(Category::class)->find($categoryid);
        $job->setCategoryId($category);

        try {
            $type = $_GET['type'];
            $job->setType($type);
        } catch (\Throwable $th) {
            //throw $th;
        }

        $company = $_GET['company'];
        $job->setCompany($company);

        try {
            $logo = $_GET['logo'];
            $job->setLogo($logo);
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            $url = $_GET['url'];
            $job->setUrl($url);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        $position = $_GET['position'];
        $job->setPosition($position);

        $location = $_GET['location'];
        $job->setLocation($location);

        $description = $_GET['description'];
        $job->setDescription($description);

        $howtoapply = $_GET['howtoapply'];
        $job->setHowToApply($howtoapply);

        $token = $_GET['token'];
        $job->setToken($token);

        $ispublic = $_GET['ispublic'];
        $job->setIsPublic($ispublic);

        $isactivated = $_GET['isactivated'];
        $job->setIsActivated($isactivated);

        $email = $_GET['email'];
        $job->setEmail($email);

        $expiresat = $_GET['expiresat'];
        $job->setExpiresAt(\DateTime::createFromFormat('Y-m-d', $expiresat));

        //TO DO: set current date
        $job->setCreatedAt(\DateTime::createFromFormat('Y-m-d', date('Y-m-d')));

        $job->setUpdatedAt(null);

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

        return $this->render('job/job.html.twig', [
            'job' => $job,
        ]);
    }

        /**
     * @Route("/jobs", name="readall_job")
     */
    public function readAllJobs()
    {
        $jobs = $this->getDoctrine()->getRepository(Job::class)->findAll();

        if(!$jobs)
        {
            throw $this->createNotFoundException('No jobs found');
        }

        return $this->render('job/jobs.html.twig', [
            'jobs' => $jobs,
        ]);
    }

     /**
     * @Route("/editjob/{id}", name="edit_job")
     */
    public function editJob($id)
    {
        $job = $this->getDoctrine()->getRepository(Job::class)->find($id);

        if(!$job)
        {
            throw $this->createNotFoundException('No job found with id='.$id);
        }
        return $this->render('job/editjob.html.twig', [
            'job' => $job,
        ]);
    }

    /**
     * @Route("/updatejob/{id}", name="update_job")
     */
    public function updateJob($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $job = $this->getDoctrine()->getRepository(Job::class)->find($id);

        if(!$job)
        {
            throw $this->createNotFoundException('No job found with id='.$id);
        }

        try {
            $categoryid = $_GET['categoryid'];
            $category = $this->getDoctrine()->getRepository(Category::class)->find($categoryid);
            $job->setCategoryId($category);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        try {
            $type = $_GET['type'];
            $job->setType($type);
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            $company = $_GET['company'];
            $job->setCompany($company);
        } catch (\Throwable $th) {
            //throw $th;
        }
        

        try {
            $logo = $_GET['logo'];
            $job->setLogo($logo);
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            $url = $_GET['url'];
            $job->setUrl($url);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        try {
            $position = $_GET['position'];
            $job->setPosition($position);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        try {
            $location = $_GET['location'];
            $job->setLocation($location);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        try {
            $description = $_GET['description'];
            $job->setDescription($description);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        try {
            $howtoapply = $_GET['howtoapply'];
            $job->setHowToApply($howtoapply);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        try {
            $token = $_GET['token'];
            $job->setToken($token);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        try {
            $ispublic = $_GET['ispublic'];
            $job->setIsPublic($ispublic);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        try {
            $isactivated = $_GET['isactivated'];
            $job->setIsActivated($isactivated);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        try {
            $email = $_GET['email'];
            $job->setEmail($email);
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            $expiresat = $_GET['expiresat'];
            $job->setExpiresAt(\DateTime::createFromFormat('Y-m-d', $expiresat));
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        //TO DO: set current date
        $job->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', date('Y-m-d')));

        $entityManager->flush();

        return new Response('<h1> Updated job with id='.$job->getId());
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
//test commit diana
