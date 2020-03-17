<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\CalculType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CabinetController extends AbstractController
{
    /**
     * Permet d'afficher la homepage avec les 3 derniers posts publié
     * 
     * @Route("/", name="home")
     * 
     * @return Response
     */
    public function home()
    {
        $posts = $this
            ->getDoctrine()
            ->getRepository(Post::class)
            ->findForHome()
        ;

        return $this->render('cabinet/home.html.twig', [
            "posts" => $posts,
        ]);
    }

    /**
     * Permet d'afficher la page consultation
     * 
     * @route("/consultations", name="consultation")
     * 
     * @return Response
     */
    public function consultations(){
        return $this->render('cabinet/consultations.html.twig');
    }

    /**
     * Permet d'afficher la page préparation 
     * 
     * @route("/preparation", name="preparation")
     * 
     * @return Response
     */
    public function preparation(){
        return $this->render('cabinet/preparation.html.twig');
    }

    /**
     * Permet d'afficher la page massage 
     * 
     * @route("/massage", name="massage")
     * 
     * @return Response
     */
    public function massage(){
        return $this->render('cabinet/massage.html.twig');
    }

    /**
     * Permet d'afficher la page conseil calendrier
     * 
     * @route("/calendrier", name="calendrier")
     * 
     * @return Response
     */
    public function calendrier(){
        return $this->render('cabinet/conseilCalendrier.html.twig');
    }

    /**
     * Permet d'afficher la page conseil lexique
     * 
     * @route("/lexique", name="lexique")
     * 
     * @return Response
     */
    public function lexique(){
        return $this->render('cabinet/conseilLexique.html.twig');
    }

    /**
     * Permet d'afficher la page conseil calcul et son formulaire
     * 
     * @route("/calcul", name="calcul")
     * 
     * @return Response
     */
    public function calcul(){
        
        $form = $this->createform(CalculType::class);

        return $this->render('cabinet/conseilCalcul.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher la page horaires et tarifs
     * 
     * @route("/horaire&tarifs", name="horaires_tarifs")
     * 
     * @return Response
     */
    public function horairesTarifs(){
        return $this->render('cabinet/horairesTarifs.html.twig');
    }

    /**
     * Méthode pour calculer
     * la date d'accouchement suivant la date choisit.
     * 
     * @Route("/dateAccouchement", name="date_accouchement")
     * 
     * @param Request $request
     * @return Response
     */
    public function dateAccouchement(Request $request)
    {
        // Lancer une erreur 404
        // Si il ne s'agit pas d'une requête AJAX
        // Ou si il ne s'agit pas d'une requête POST
        if (!$request->isXmlHttpRequest() || !$request->isMethod('POST')) {
            throw $this->createNotFoundException('Une erreur est survenue.');
        }

        // Récupération de la valeur du champ "date"
        $dateConception = $request->request->get('dateConception');

        // Si la date est vide, lancer une erreur 404
        if ($dateConception == '') {
            throw $this->createNotFoundException('Une erreur est survenue.');
        }

        // Convertir la date en timestamp
        $dateConceptionTimestamp = strtotime($dateConception);

        // Ajout de 273 jours à la date de départ
        $dateAccouchement = date('d-m-Y', strtotime('+273 days', $dateConceptionTimestamp ));
        
        return new JsonResponse($dateAccouchement);
    }

    /**
     * Méthode pour calculer
     * la date de conception suivant la date choisit.
     * 
     * @Route("/dateConception", name="date_conception")
     * 
     * @param Request $request
     * @return Response
     */
    public function dateConception(Request $request)
    {
        // Lancer une erreur 404
        // Si il ne s'agit pas d'une requête AJAX
        // Ou si il ne s'agit pas d'une requête POST
        if (!$request->isXmlHttpRequest() || !$request->isMethod('POST')) {
            throw $this->createNotFoundException('Une erreur est survenue.');
        }

        // Récupération de la valeur du champ "date"
        $dateDerniereRegle = $request->request->get('dateDerniereRegle');

        // Si la date est vide, lancer une erreur 404
        if ($dateDerniereRegle == '') {
            throw $this->createNotFoundException('Une erreur est survenue.');
        }

        // Convertir la date en timestamp
        $dateDerniereRegleTimestamp = strtotime($dateDerniereRegle);

        // Ajout de 14 jours à la date de départ
        $dateConception = date('d-m-Y', strtotime('+14 days', $dateDerniereRegleTimestamp ));
        
        return new JsonResponse($dateConception);
    }
}
