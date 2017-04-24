<?php

namespace CGI\CommentBundle\Controller;

use CGI\CommentBundle\Entity\Comment;
use CGI\CommentBundle\Entity\CommentNotification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Comment controller.
 *
 * @Route("comment")
 */
class CommentController extends Controller
{

    /**
     * Lists all comment entities.
     *
     * @Route("/", name="my_comments", options = {"expose" = true})
     */
    public function listCommentAction(){

        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('CGICommentBundle:Comment')->findAll();

        $notifications = $em->getRepository('CGICommentBundle:CommentNotification')->findAll();
        $numberUnseenNotif = 0;
        foreach($notifications as $notification){
             if(!$notification->isVue()){
                 $numberUnseenNotif ++;
             }
        }

        return $this->render('CGICommentBundle:Default:index.html.twig', array(
            'comments' => $comments,
            'notifications' => $notifications,
            'numberUnseenNotif' => $numberUnseenNotif
        ));
    }


    /**
     * Creates a new comment entity.
     *
     * @Route("/ajax/get/all/comments/notifications", name="ajax_get_all_comments_notifications")
     * @Method({"GET", "POST"})
     */
    public function asynchronousGetAllAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('CGICommentBundle:Comment')->findAll();
        $notifications = $em->getRepository('CGICommentBundle:CommentNotification')->findAll();

        $numberUnseenNotif = 0;
        foreach($notifications as $notification){
            if(!$notification->isVue()){
                $numberUnseenNotif ++;
            }
        }

        $serializedComments = $this->container->get('jms_serializer')->serialize($comments, 'json');
        $serializedNotifications = $this->container->get('jms_serializer')->serialize($notifications, 'json');

        return new JsonResponse(array('comments' => $serializedComments,
                                      'numberUnseenNotif' => $numberUnseenNotif,
                                      'notifications' => $serializedNotifications));

    }

    /**
     * Creates a new comment entity.
     *
     * @Route("/ajax/comment/add", name="ajax_comment_add")
     * @Method({"GET", "POST"})
     */
    public function addCommentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $contenu = $request->get('contenu');

        //create a new comment
        $comment = new Comment();
        $comment->setContenu($contenu);
        $comment->setCreatedBy($this->getUser());
        $comment->setDate(new \DateTime());
        $em->persist($comment);

        //create notification for comment
        $commentNotification = new CommentNotification();
        $commentNotification->setComment($comment);
        $em->persist($commentNotification);

        $em->flush();

        return new JsonResponse(array('success' => true));

    }


    /**
     * Lists all comment entities.
     *
     * @Route("/", name="comment_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('CGICommentBundle:Comment')->findAll();

        return $this->render('comment/index.html.twig', array(
            'comments' => $comments,
        ));
    }

    /**
     * Creates a new comment entity.
     *
     * @Route("/new", name="comment_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $comment = new Comment();
        $form = $this->createForm('CGI\CommentBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('comment_show', array('id' => $comment->getId()));
        }

        return $this->render('comment/new.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a comment entity.
     *
     * @Route("/{id}", name="comment_show")
     * @Method("GET")
     */
    public function showAction(Comment $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);

        return $this->render('comment/show.html.twig', array(
            'comment' => $comment,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing comment entity.
     *
     * @Route("/{id}/edit", name="comment_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Comment $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);
        $editForm = $this->createForm('CGI\CommentBundle\Form\CommentType', $comment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_edit', array('id' => $comment->getId()));
        }

        return $this->render('comment/edit.html.twig', array(
            'comment' => $comment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a comment entity.
     *
     * @Route("/{id}", name="comment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Comment $comment)
    {
        $form = $this->createDeleteForm($comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comment_index');
    }

    /**
     * Creates a form to delete a comment entity.
     *
     * @param Comment $comment The comment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comment $comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $comment->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
