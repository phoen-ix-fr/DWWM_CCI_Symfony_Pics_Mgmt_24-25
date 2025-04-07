<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
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
    public function index(EventRepository $eventRepository, ): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $events = $eventRepository->findAllowed($user);

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

            return $this->redirectToRoute('app_event');
        }

        return $this->render('event/create.html.twig', [
            'formCreate'    => $formEventCreate,
            'event'         => $event
        ]);
    }

    /**
     * Page  d'affichage des détails d'un évènement
     * 
     * @route event/{id}
     * @name app_event_show
     * 
     * @param Event $event Entité Event correspondante à l'ID transmise dans l'URL
     *
     * @return Response Réponse HTTP renvoyée au navigateur avec les détails de l'évènement
     */
    #[Route('/event/{id<\d+>}', name: 'app_event_show', methods: ['GET'])]
    #[IsGranted('EVENT_SHOW', subject: 'event')]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event'       => $event
        ]);
    }

    /**
     * Page  de modification des détails d'un évènement
     * 
     * @route event/edit/{id}
     * @name app_event_edit
     * 
     * @param Event $event Entité Event correspondante à l'ID transmise dans l'URL
     * @param EntityManagerInterface $entityManager (dépendance) Gestionnaire d'entités
     * @param Request $request (dépendance) Objet contenant la requête envoyé par le navigateur ($_POST/$_GET)
     *
     * @return Response Réponse HTTP renvoyée au navigateur avec le formulaire de modification de l'évènement
     */
    #[Route('/event/edit/{id<\d+>}', name: 'app_event_edit', methods: ['GET', 'POST'])]
    #[IsGranted('EVENT_UPDATE', subject: 'event')]
    public function edit(Event $event, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création du formulaire pour l'affichage
        // @param EventType : correspond à la classe du formulaire
        // @param $event : l'objet qui remplit par défaut le formulaire et qui sera mis à jour
        $formEventEdit = $this->createForm(EventType::class, $event);

        // On dit au formulaire de récupérer les données de la requête ($_POST)
        $formEventEdit->handleRequest($request);

        // On vérifie que le formulaire a été soumis et que les données sont valides
        if($formEventEdit->isSubmitted() && $formEventEdit->isValid())
        {    
            // Le persist n'est pas à faire en cas de modification, les données provenant déjà la base
            // Cependant, l'entity manager ne surveille que la partie owner, il faudra donc traiter le lien avec les photos

            /** @var PersistentCollection $arrPictures */
            $arrPictures = $event->getPictures();

            // Je teste si des modifications ont été effectuées au niveau de ma collection
            if($arrPictures->isDirty()) {
                $arrPicturesNotAnymore      = $arrPictures->getDeleteDiff();
                foreach($arrPicturesNotAnymore as $p) 
                {
                    // Pour toutes les photos retirées, j'associe NULL à l'évènement de ma photo
                    $p->setEvent(null);
                }

                $arrPicturesNewAssociated   = $arrPictures->getInsertDiff();
                foreach($arrPicturesNewAssociated as $p)
                {
                    // Associer l'évènement courant ($event) à la photo
                    $p->setEvent($event);
                }                
            }

            // Met à jour les données en base
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Les modifications ont été enregistrées"
            );
        }

        return $this->render('event/edit.html.twig', [
            'event'         => $event,
            'formEdit'      => $formEventEdit
        ]);
    }
    /**
     * Route de suppression d'un évènement
     * 
     * @route event/delete/{id}
     * @name app_event_delete
     * 
     * @param Event $event Entité Picture correspondante à l'ID transmise dans l'URL
     * @param EntityManagerInterface $entityManager (dépendance) Gestionnaire d'entités
     *
     * @return Response Réponse HTTP renvoyée au navigateur
     */
    #[Route('/event/delete/{id<\d+>}', name: 'app_event_delete')]
    #[IsGranted('EVENT_DELETE', subject: 'event')]
    public function delete(Event $event, EntityManagerInterface $entityManager): Response
    {
        try {

            // Prépare l'objet à la suppression
            $entityManager->remove($event);

            // On lance la suppression en base
            $entityManager->flush();

            // Si tout s'est bien passé, je redirige vers la liste
            $this->addFlash(
                'success',
                "La suppression a été effectuée"
            );

            return $this->redirectToRoute('app_event');
        }
        catch(\Exception $exc) {

            // Je prépare un flash qui s'affichera à l'écran avec le message d'erreur de l'exception
            $this->addFlash(
                'error',
                $exc->getMessage()
            );

            // Je redirige vers la page de la photo
            return $this->redirectToRoute('app_event_show', ['id' => $event->getId()], 304);
        }
    }
}
