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
     * @Route("/newcategory", name="new_category")
     */
    public function newCategory()
    {
        return $this->render('category/createcategory.html.twig', [
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

        //return new Response('<h1>'.$category->getName());

        return $this->render('category/category.html.twig', [
            'category' => $category,
        ]);
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

        //return new Response('<h1>'.$responseMsg);

        return $this->render('category/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/editcategory/{id}", name="edit_category")
     */
    public function editCategory($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if(!$category)
        {
            throw $this->createNotFoundException('No category found with id='.$id);
        }
        return $this->render('category/editcategory.html.twig', [
            'category' => $category,
        ]);
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

        $entityManager->flush();

        return new Response('<h1> Updated category with id='.$category->getId());
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
