<?php
namespace App\Controller;

use App\Entity\Users;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

use Knp\Component\Pager\PaginatorInterface;

class UserController extends AbstractController {
    /**
     * @Route("/", name="user_list")
     * @Method({"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator) {

        $em = $this->getDoctrine()->getManager();
        $allUsers=$em->getRepository('App:Users')->findAll();
        $result = $paginator->paginate(
            $allUsers,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 25)
        );

        // parameters to template
        return $this->render('users/index.html.twig', ['users'=>$result]);
    }

    /**
     * @Route("user/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $user = new Users();

        $form = $this->createFormBuilder($user)
            ->add('index',NumberType::class, array('attr' => array('class' => 'form-control')))
            ->add('index_start_at', NumberType::class, array('attr' => array('class' => 'form-control')))
            ->add('some_number', NumberType::class, array('attr' => array('class' => 'form-control')))
            ->add('floater', NumberType::class, array('attr' => array('class' => 'form-control')))
            ->add('first_name', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('surname', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('fullname', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('email', EmailType::class, array('attr' => array('class' => 'form-control')))
            ->add('bully', CheckboxType::class, array('attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('user_list');
        }
        return $this->render('users/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("user/edit/{id}", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $user = new Users();
        $user = $this->getDoctrine()->getRepository(Users::class)->find($id);

        $form = $this->createFormBuilder($user)
            ->add('index',NumberType::class, array('label'=> 'Enter Email Address', 'attr' => array('class' => 'form-control')))
            ->add('index_start_at', NumberType::class, array('attr' => array('class' => 'form-control')))
            ->add('some_number', NumberType::class, array('attr' => array('class' => 'form-control')))
            ->add('floater', NumberType::class, array('attr' => array('class' => 'form-control')))
            ->add('first_name', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('surname', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('fullname', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('email', EmailType::class, array('attr' => array('class' => 'form-control')))
            ->add('bully', CheckboxType::class, array('attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
                'label' => 'Update',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('user_list');
        }
        return $this->render('users/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/user/{id}", name="user_show")
     */
    public function show($id) {
        $user = $this->getDoctrine()->getRepository(Users::class)->find($id);

        return $this -> render('users/show.html.twig', array('user' => $user));
    }

    /**
     * @Route("/user/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $user = $this->getDoctrine()->getRepository(Users::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        $response = new Response();
        $response ->send();
    }
}
