<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Contrôleur des pages liées aux exceptions et erreurs
 * Permet de le débug des vues également
 */
final class ExceptionController extends AbstractController
{
    /**
     * Page d'erreur par défaut
     * Cette vue sera appelée (en production) lorsqu'une erreur se produira 
     * (autre que les erreurs spécifiquement définies plus bas dans ce contrôleur)
     * 
     * @route error
     * @name app_error
     * 
     * @return Response Réponse HTTP renvoyée au navigateur
     */
    #[Route('/error', name: 'app_error')]
    public function error(): Response
    {
        return $this->render('bundles/TwigBundle/Exception/error.html.twig');
    }

    /**
     * Page d'erreur spécifique pour l'erreur HTTP 404
     * 
     * @route error404
     * @name app_error404
     * 
     * @return Response Réponse HTTP renvoyée au navigateur
     */
    #[Route('/error404', name: 'app_error404')]
    public function error404(): Response
    {
        return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
    }
}
