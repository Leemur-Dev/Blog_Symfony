<?php

namespace Travel\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Travel\BlogBundle\Entity\Post;

class BlogController extends Controller
{

    private $posts = [
        [
            'id' => 1,
            'title' => 'Post1',
            'text' => 'Lorem ipsum dolor sit amet, consectetur
            adipisicing elit.'
        ], [
            'id' => 2,
            'title' => 'Post2',
            'text' => 'Lorem ipsum dolor sit amet, consectetur
            adipisicing elit.'
        ]
    ];

    /**
    * @Route("/", name="blog_index")
    */
    public function indexAction()
    {
        $docMan = $this->getDoctrine()->getManager();
        $posts = $this->getDoctrine()
                      ->getRepository('TravelBlogBundle:Post')
                      ->findAll();

        return $this->render('TravelBlogBundle:Blog:index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
    * @Route("/post/{id}", name="blog_post", requirements={"id": "\d+"})
    */
    public function postAction($id)
    {
        $docMan = $this->getDoctrine()->getManager();
        $post = $this->getDoctrine()
                      ->getRepository('TravelBlogBundle:Post')
                      ->findOneBy(['id' => $id]);

        return $this->render('TravelBlogBundle:Blog:post.html.twig', [
            'post' => $post
        ]);
    }

    /**
    * @Route("/add", name="blog_add")
    */
    public function addAction()
    {
        return $this->render('TravelBlogBundle:Blog:edit.html.twig', [
            'post' => new Post('', '')
        ]);
    }

    /**
    * @Route("/edit/{id}", name="blog_edit", requirements={"id": "\d+"})
    */
    public function editAction($id)
    {
        $docMan = $this->getDoctrine()->getManager();
        $post = $this->getDoctrine()
                      ->getRepository('TravelBlogBundle:Post')
                      ->findOneBy(['id' => $id]);

        return $this->render('TravelBlogBundle:Blog:edit.html.twig', [
            'post' => $post
        ]);
    }

    /**
    * @Route("/delete/{id}", name="blog_delete", requirements={"id": "\d+"})
    */
    public function deleteAction($id)
    {
        $post = $this->getDoctrine()
                      ->getRepository('TravelBlogBundle:Post')
                      ->findOneBy(['id' => $id]);
        if ($post) {
            $docMan = $this->getDoctrine()->getManager();
            $docMan->remove($post);
            $docMan->flush();
        }

        return $this->redirect('/');
    }

    /**
    * @Route("/save/")
    * @Route("/save/{id}", name="blog_save", requirements={"id": "\d+"})
    */
    public function saveAction(Request $request, $id = 0) {

        $post = null;

        if ($id !== 0) {
            $post = $this->getDoctrine()
                          ->getRepository('TravelBlogBundle:Post')
                          ->findOneBy(['id' => $id]);
        } else {
            $post = new Post();
        }

        $post->setTitle($request->request->get('title'));
        $post->setText($request->request->get('text'));

        $docMan = $this->getDoctrine()->getManager();

        if ($id === 0)
            $docMan->persist($post);

        $docMan->flush();

        return $this->redirect('/post/'.$post->getId());
    }
}
