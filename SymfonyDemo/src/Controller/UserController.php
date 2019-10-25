<?php

namespace App\Controller;

use App\Entity\User; 
use App\Entity\UserDetails; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/newuser", name="newuser")
     */
    public function newUser()
    {
        return $this->render('user/newuser.html.twig', [
        ]);
    }

    /**
     * @Route("/createuser", name="createuser")
     */
    public function createUser()
    {
        $username = $_GET['username'];
        $password = $_GET['password'];
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);

        $entityManager->persist($user);
        $entityManager->flush();

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/users.html.twig', [
            'users' => $users,
            'message'=>'user created successfully',
            'class'=>'alert alert-success',
        ]);
    }

    /**
     * @Route("/users", name="users")
     */
    public function readUsers()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        // if(!$users)
        // {
        //    return new Response('No users found');
        // }
        return $this->render('user/users.html.twig', [
            'users' => $users,
            'message'=>'',
            'class'=>'',
        ]);
    }

    /**
     * @Route("/userdetails/{id}", name="userdetails")
     */
    public function viewUserDetails($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if(!$user)
        {
            return new Response("No user found with id=".$id);
        }

        try {
            $userDetailsId = $user->getUserDetailsId();
            $userDetails = $this->getDoctrine()->getRepository(UserDetails::class)->find($userDetailsId); 
        } catch (\Throwable $th) {
            return new Response("User with id ".$id." has no user details!");
        }
        

        return $this->render('user/userdetails.html.twig', [
            'userDetails' => $userDetails,
        ]);
    }

    /**
     * @Route("/createuserdetails/{id}", name="createuserdetails")
     */
    public function createUserDetails($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if(!$user)
        {
            return new Response("No user found with id=".$id);
        }
       
        $firstname = $_GET['firstname'];
        $lastname = $_GET['lastname'];
        $phonenr = $_GET['phonenr'];
        $adress = $_GET['adress'];

        $entityManager = $this->getDoctrine()->getManager();

        $userDetails = new UserDetails();
        $userDetails->setFirstname($firstname);
        $userDetails->setLastname($lastname);
        $userDetails->setPhonenr($phonenr);
        $userDetails->setAdress($adress);

        try {
            $userDetailsId = $user->getUserDetailsId();
            $existingUserDetails = $this->getDoctrine()->getRepository(UserDetails::class)->find($userDetailsId);
            if($existingUserDetails == null)
            {
                $entityManager->persist($userDetails);
                $entityManager->flush();
                $user->setUserDetailsId($userDetails->getId());
                $entityManager->flush();
                return $this->render('user/userdetails.html.twig', [
                    'userDetails' => $userDetails,
                ]);
            }
            else
            {
                return new Response("User already has user details");
            }
        } catch (\Throwable $th) {
            $entityManager->persist($userDetails);
            $entityManager->flush();
            $user->setUserDetailsId($userDetails->getId());
            $entityManager->flush();
            return $this->render('user/userdetails.html.twig', [
                'userDetails' => $userDetails,
            ]);
        }
        
    }

    /**
     * @Route("/updateuserdetails/{id}", name="updateuserdetails")
     */
    public function updateUserDetails($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if(!$user)
        {
            return new Response("No user found with id=".$id);
        }
        try {
            $userDetailsId = $user->getUserDetailsId();
            $userDetails = $this->getDoctrine()->getRepository(UserDetails::class)->find($userDetailsId);
        } catch (\Throwable $th) {
            return new Response("User with id=".$id." has no user details!");
        }
        
        $firstname = $_GET['firstname'];
        $lastname = $_GET['lastname'];
        $phonenr = $_GET['phonenr'];
        $adress = $_GET['adress'];

        $userDetails->setFirstname($firstname);
        $userDetails->setLastname($lastname);
        $userDetails->setPhonenr($phonenr);
        $userDetails->setAdress($adress);

        $entityManager->flush();

        return $this->render('user/userdetails.html.twig', [
            'userDetails' => $userDetails,
        ]);
    }

    /**
     * @Route("/edituserdetails/{id}", name="edituserdetails")
     */
    public function editUserDetails($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if(!$user)
        {
            return new Response("No user found with id=".$id);
        }
        try {
            $userDetailsId = $user->getUserDetailsId();
            $userDetails = $this->getDoctrine()->getRepository(UserDetails::class)->find($userDetailsId);
        } catch (\Throwable $th) {
            return new Response("User with id=".$id." has no user details!");
        }

        return $this->render('user/edituserdetails.html.twig', [
            'userid' => $id,
            'userDetails' => $userDetails,
        ]);
    }

    /**
     * @Route("/newuserdetails/{id}", name="newuserdetails")
     */
    public function newUserDetails($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if(!$user)
        {
            return new Response("No user found with id=".$id);
        }
       

        return $this->render('user/createuserdetails.html.twig', [
            'userid' => $id,
        ]);
    }

    /**
     * @Route("/deleteuserdetails/{id}", name="deleteuserdetails")
     */
    public function deleteUserDetails($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if(!$user)
        {
            return new Response("No user found with id=".$id);
        }
        try {
            $userDetailsId = $user->getUserDetailsId();
            $userDetails = $this->getDoctrine()->getRepository(UserDetails::class)->find($userDetailsId);
        } catch (\Throwable $th) {
            return new Response("User with id=".$id." has no user details!");
        }

        
        $entityManager->remove($userDetails);
        $user->setUserDetailsId(null);
        $entityManager->flush();

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('user/users.html.twig', [
            'users' => $users,
            'message'=>'Deleted user details for user with id='.$id,
            'class'=>'alert alert-success',
        ]);
    }

     /**
     * @Route("/deleteuser/{id}", name="deleteuser")
     */
    public function deleteUser($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if(!$user)
        {
            return new Response("No user found with id=".$id);
        }
        try {
            $userDetailsId = $user->getUserDetailsId();
            $userDetails = $this->getDoctrine()->getRepository(UserDetails::class)->find($userDetailsId);
            $entityManager->remove($userDetails);

        } catch (\Throwable $th) {
            
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('user/users.html.twig', [
            'users' => $users,
            'message'=>'Deleted user with id='.$id,
            'class'=>'alert alert-success',
        ]);
    }
}
