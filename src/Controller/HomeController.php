<?php

namespace App\Controller;

use App\Service\QuoteGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Contrôleur de la page d'accueil et des pages statiques
 */
final class HomeController extends AbstractController
{
    /**
     * Page d'accueil de l'application
     * Cette page sera accessible par défaut lorsque l'on arrive sur le site
     * 
     * @route /
     * @name app_home
     * 
     * @param QuoteGenerator @quoteGenerator Service permettant la génération d'une citation aléatoire
     * 
     * @return Response Réponse HTTP renvoyée au navigateur
     */
    #[Route('/', name: 'app_home')]
    public function index(QuoteGenerator $quoteGenerator): Response
    {
        $quote = $quoteGenerator->getRandomQuote();
        return $this->render('home/index.html.twig', [
            'quote' => $quote
        ]);
    }
}
