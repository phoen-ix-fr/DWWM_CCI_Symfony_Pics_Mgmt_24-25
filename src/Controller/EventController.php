<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EventController extends AbstractController
{
    /**
     * Page d'affichage de la liste complète des évènements en base
     * 
     * @route event/
     * @name app_event
     * @methods GET
     * 
     * @param EventRepository $eventRepository (Service) Repository permettant l'accès aux données en base
     * 
     * @return Response Réponse HTTP renvoyée au navigateur comportant la liste des évènements
     */   
    #[Route('/event', name: 'app_event')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();

        return $this->render('event/index.html.twig', [
            'events'    => $events
        ]);
    }

    /**
     * Page de création d'un nouvel évènement
     * 
     * @route event/create
     * @name app_event_create
     * 
     * @param EntityManagerInterface $entityManager (dépendance) Gestionnaire d'entités
     * @param Request $request (dépendance) Objet contenant la requête envoyé par le navigateur ($_POST/$_GET)
     * 
     * @return Response Réponse HTTP renvoyée au navigateur comportant le formulaire de création
     */
    #[Route('/event/create', name: 'app_event_create')]
    public function create(EntityManagerInterface $entityManager, 
        Request $request): Response
    {
        // Création d'un nouvel objet
        $event = new Event();

        // Création du formulaire pour l'affichage
        // @param EventType : correspond à la classe du formulaire
        // @param $event : l'objet qui sera remplit par le formulaire
        $formEventCreate = $this->createForm(EventType::class, $event);

        // On dit au formulaire de récupérer les données de la requête ($_POST)
        $formEventCreate->handleRequest($request);

        // On vérifie que le formulaire a été soumis et que les données sont valides
        if($formEventCreate->isSubmitted() && $formEventCreate->isValid())
        {
            // Prépare les données à être sauvegardées en base
            $entityManager->persist($event);
    
            // Enregistre les données en base, créer l'ID unique
            $entityManager->flush();

            $this->addFlash(
                'success',
                "L'évènement a été créé avec succès"
            );
        }

        return $this->render('event/create.html.twig', [
            'formCreate'    => $formEventCreate,
            'event'         => $event
        ]);
    }
}
