<?php

namespace Webas\WebasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webas\WebasBundle\Entity\Post;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $repo = $this->get('doctrine')->getRepository('WebasWebasBundle:Post');

        return $this->render('WebasWebasBundle:Default:index.html.twig', [
            'posts' => $repo->findAll()
        ]);
    }

    /**
     * @param $post
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showPostAction($post)
    {
        $postRepo = $this->get('doctrine')->getRepository('WebasWebasBundle:Post');
        $commentRepo = $this->get('doctrine')->getRepository('WebasWebasBundle:Comment');

        $postEntity = $postRepo->find($post);

        if (!$postEntity) {
            throw $this->createNotFoundException();
        }

        $comments = $commentRepo->findBy(['post' => $postEntity]);

        return $this->render('WebasWebasBundle:Default:showPost.html.twig', [
            'comments' => $comments
        ]);
    }




    public function createPostAction()
    {
        $repo = $this->get('doctrine')->getRepository('WebasWebasBundle:Post');

        return $this->render('WebasWebasBundle:Default:createPost.html.twig', [
            'post' => $repo
        ]);
    }

}
