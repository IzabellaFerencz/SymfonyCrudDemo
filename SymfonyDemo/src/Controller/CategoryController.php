<?php

namespace App\Controller;

use App\Entity\Category; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @Route("/createcategory", name="create_category")
     */
    public function createCategory():Response
    {
        $name = $_GET['name'];
        $entityManager = $this->getDoctrine()->getManager();

        $category = new Category();
        $category->setName($name);

        $entityManager->persist($category);
        $entityManager->flush();

        return new Response('Created category with id '.$category->getId());
    }

    /**
     * @Route("/category/{id}", name="read_category")
     */
    public function readCategory($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if(!$category)
        {
            throw $this->createNotFoundException('No category found with id='.$id);
        }

        return new Response('<h1>'.$category->getName());
    }

        /**
     * @Route("/categories", name="readall_category")
     */
    public function readAllCategories()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

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
     * @Route("/updatecategory/{id}", name="update_category")
     */
    public function updateCategory($id)
    {
        $newName = $_GET['newName'];
        $entityManager = $this->getDoctrine()->getManager();
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if(!$category)
        {
            throw $this->createNotFoundException('No category found with id='.$id);
        }

        $category->setName($newName);

        $entityManager->persist($category);
        $entityManager->flush();

        return new Response('<h1>'.$category->getName());
    }

    /**
     * @Route("/deletecategory/{id}", name="delete_category")
     */
    public function deleteCategory($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if(!$category)
        {
            throw $this->createNotFoundException('No category found with id='.$id);
        }

        $entityManager->remove($category);
        $entityManager->flush();

        return new Response('<h1> Deleted category with id='.$id);
    }
}
