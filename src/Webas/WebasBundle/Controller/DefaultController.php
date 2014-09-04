<?php

namespace Webas\WebasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Webas\WebasBundle\Entity\Comment;
use Webas\WebasBundle\Entity\Post;
use Webas\WebasBundle\Form\CommentType;
use Webas\WebasBundle\Form\PostType;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $repo = $this->get('doctrine')->getRepository('WebasWebasBundle:Post');

        return $this->render('WebasWebasBundle:Default:index.html.twig', [
            'posts' => array_reverse($repo->findAll())
        ]);
    }

    /**
     * @param $post
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showPostAction(Request $request, $post)
    {
        $commentManager = $this->getDoctrine()->getManager();

        $postRepo = $this->get('doctrine')->getRepository('WebasWebasBundle:Post');
        $commentRepo = $this->get('doctrine')->getRepository('WebasWebasBundle:Comment');

        $postEntity = $postRepo->find($post);

        if (!$postEntity) {
            throw $this->createNotFoundException();
        }

        $comment = new Comment();
        $comment->setPost($postEntity);
        $comment->setDateTime(new \DateTime('now'));

        $form = $this->createForm(new CommentType(), $comment);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $commentManager->persist($comment);
            $commentManager->flush();
        }

        $comments = $commentRepo->findBy(['post' => $postEntity]);

        return $this->render('WebasWebasBundle:Default:showPost.html.twig', [
            'post' => $post,
            'comments' => array_reverse($comments),
            'form' => $form->createView()
        ]);
    }

    public function createPostAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = new Post();

        $form = $this->createForm(new PostType(), $post);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($post);
            $em->flush();
        }

        return $this->render('WebasWebasBundle:Default:createPost.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
