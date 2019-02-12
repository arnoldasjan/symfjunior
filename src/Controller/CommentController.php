<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use App\Entity\Comment;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class CommentController extends AbstractController
{
    /**
     * @Route("/comments/{id}", name="comment")
     */
    public function index(Request $request, PaginatorInterface $paginator, Users $appUser)
    {

        $form = $this->createFormBuilder(new Comment())
            ->add('comment', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
                'label' => 'Submit',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $newcomment = $form->getData();
            $appUser->addComment($newcomment);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($appUser);
            $entityManager->flush();
        }

        $allComments = $appUser->getComments();


        $result = $paginator->paginate(
            $allComments,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 25)
        );

        // parameters to template
        return $this->render('users/comment.html.twig', ['comments'=>$result, 'form' => $form->createView()]);
    }

    /**
     * @Route("/comments/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $comment = $this->getDoctrine()->getRepository(Comment::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($comment);
        $entityManager->flush();

        $response = new Response();
        $response ->send();
    }
}