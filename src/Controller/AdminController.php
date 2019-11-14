<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\NewPostType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request, ObjectManager $manager)
    {
        $posts = $this
            ->getDoctrine()
            ->getRepository(post::class)
            ->findAll()
        ;

        $post = new Post();
        $form = $this->createform(NewPostType::class, $post);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $post->setPublierLe(new \dateTime());
            $manager->persist($post);
            $manager->flush();

            $this->addFlash('success', "Votre Post a bien été publié !");

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/index.html.twig', [
            'form' => $form->createView(),
            'posts' => $posts,
        ]);
    }

    /**
     * Controlleur qui retourne la page d'édition des 
     * posts et qui permet de les modifier.
     * 
     * @Route("/{id}/edit", name="admin_post_edit")
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(NewPostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "Le post on bien été modifié !");

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/edit.html.twig', [
            'post'  => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Controlleur qui retourne la fonction de suppression
     * d'un post.
     * 
     * @Route("/{id}/delete", name="admin_post_delete", methods={"GET"})
     */
    public function delete(Post $post) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        $this->addFlash('success', "Le post a bien été supprimé !");

        return $this->redirectToRoute('admin');
    }
}
