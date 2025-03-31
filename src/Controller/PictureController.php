<?php

namespace App\Controller;

use DateTime;
use App\Entity\Picture;
use App\Form\PictureType;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Contrôleur de gestion des photos
 */
final class PictureController extends AbstractController
{
    /**
     * Page d'affichage de la liste complète des photos en base
     * 
     * @route picture/
     * @name app_picture
     * @methods GET
     * 
     * @param PictureRepository $pictureRepository (Service) Repository permettant l'accès aux données en base
     * 
     * @return Response Réponse HTTP renvoyée au navigateur comportant la liste des photos
     */   
    #[Route('/picture', name: 'app_picture')]
    public function index(PictureRepository $pictureRepository): Response
    {
        //$pictureRepository = $entityManager->getRepository(Picture::class);
        $pictures = $pictureRepository->findAll();

        return $this->render('picture/index.html.twig', [
            'pictures'  => $pictures
        ]);
    }

    /**
     * Page de création d'une nouvelle photo
     * 
     * @route picture/create
     * @name app_picture_create
     * 
     * @param EntityManagerInterface $entityManager (dépendance) Gestionnaire d'entités
     * @param Request $request (dépendance) Objet contenant la requête envoyé par le navigateur ($_POST/$_GET)
     * 
     * @return Response Réponse HTTP renvoyée au navigateur comportant le formulaire de création
     */
    #[Route('/picture/create', name: 'app_picture_create')]
    public function create(EntityManagerInterface $entityManager, 
        Request $request): Response
    {
        // Création d'un nouvel objet
        $picture = new Picture();

        // Création du formulaire pour l'affichage
        // @param PictureType : correspond à la classe du formulaire
        // @param $picture : l'objet qui sera remplit par le formulaire
        $formPictureCreate = $this->createForm(PictureType::class, $picture);

        // On dit au formulaire de récupérer les données de la requête ($_POST)
        $formPictureCreate->handleRequest($request);

        // On vérifie que le formulaire a été soumis et que les données sont valides
        if($formPictureCreate->isSubmitted() && $formPictureCreate->isValid())
        {
            // Prépare les données à être sauvegardées en base
            $entityManager->persist($picture);
    
            // Enregistre les données en base, créer l'ID unique
            $entityManager->flush();
        }

        return $this->render('picture/create.html.twig', [
            'formCreate'    => $formPictureCreate,
            'picture'       => $picture
        ]);
    }

    /**
     * Page  d'affichage des détails d'une photo
     * 
     * @route picture/{id}
     * @name app_picture_show
     * 
     * @param Picture $picture Entité Picture correspondante à l'ID transmise dans l'URL
     *
     * @return Response Réponse HTTP renvoyée au navigateur avec les détails de la photo
     */
    #[Route('/picture/{id<\d+>}', name: 'app_picture_show', methods: ['GET'])]
    public function show(Picture $picture): Response
    {
        return $this->render('picture/show.html.twig', [
            'picture'       => $picture
        ]);
    }
}
