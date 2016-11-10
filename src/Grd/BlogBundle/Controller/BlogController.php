<?php

namespace Grd\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BlogController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('GrdBlogBundle:Blog:index.html.twig');
    }

    /**
     * @Route("/post/{post_id}", name="post_page")
     */
    public function postAction($post_id)
    {
        return $this->render('GrdBlogBundle:Blog:post.html.twig', ['post_id' => $post_id]);
    }
}
