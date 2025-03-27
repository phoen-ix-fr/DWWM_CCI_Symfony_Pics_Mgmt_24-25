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

final class PictureController extends AbstractController
{
    #[Route('/picture', name: 'app_picture')]
    public function index(PictureRepository $pictureRepository): Response
    {
        //$pictureRepository = $entityManager->getRepository(Picture::class);
        $pictures = $pictureRepository->findAll();

        return $this->render('picture/index.html.twig', [
            'pictures'  => $pictures
        ]);
    }

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
            'formCreate' => $formPictureCreate,
            'request'   => $request,
            'picture' => $picture
        ]);
    }
}
