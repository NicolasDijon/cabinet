<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\CalculType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CabinetController extends AbstractController
{
    /**
     * 
     * Controlleur qui retourne la home page
     * 
     * @Route("/", name="home")
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
     * Controlleur qui retourne la page consultation 
     * 
     * @route("/consultations", name="consultation")
     */
    public function consultations(){
        return $this->render('cabinet/consultations.html.twig');
    }

    /**
     * Controlleur qui retourne la page préparation 
     * 
     * @route("/preparation", name="preparation")
     */
    public function preparation(){
        return $this->render('cabinet/preparation.html.twig');
    }

    /**
     * Controlleur qui retourne la page massage 
     * 
     * @route("/massage", name="massage")
     */
    public function massage(){
        return $this->render('cabinet/massage.html.twig');
    }

    /**
     * Controlleur qui retourne la page conseil calendrier
     * 
     * @route("/calendrier", name="calendrier")
     */
    public function calendrier(){
        return $this->render('cabinet/conseilCalendrier.html.twig');
    }

    /**
     * Controlleur qui retourne la page conseil lexique
     * 
     * @route("/lexique", name="lexique")
     */
    public function lexique(){
        return $this->render('cabinet/conseilLexique.html.twig');
    }

    /**
     * Controlleur qui retourne la page conseil calcul
     * 
     * @route("/calcul", name="calcul")
     */
    public function calcul(){
        
        $form = $this->createform(CalculType::class);

        return $this->render('cabinet/conseilCalcul.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Controlleur qui retourne la page horaires et tarifs
     * 
     * @route("/horaire&tarifs", name="horaires_tarifs")
     */
    public function horairesTarifs(){
        
        return $this->render('cabinet/horairesTarifs.html.twig');
    }

    /**
     * Controlleur qui retourne la méthode pour calculer
     * la date d'accouchement suivant la date choisit.
     * 
     * @Route("/dateAccouchement", name="date_accouchement")
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
     * Controlleur qui retourne la méthode pour calculer
     * la date de conception suivant la date choisit.
     * 
     * @Route("/dateConception", name="date_conception")
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
