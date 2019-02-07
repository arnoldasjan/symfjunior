<?php
namespace App\Controller;

use App\Entity\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController {
    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function index() {



        $users = ['user1'];


        return $this -> render('users/index.html.twig', array('users' => $users));
    }

    /**
     * @Route("/user/save")
     */
    public function save() {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setIndex('1');
        $user->setName('Antanas');

        $entityManager->persist($user);

        $entityManager->flush();

        return new Response('Saves a person with the index'.$user->getIndex());
    }
}
