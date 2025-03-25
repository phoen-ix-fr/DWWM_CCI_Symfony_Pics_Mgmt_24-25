<?php

namespace App\Controller;

use DateTime;
use App\Entity\Picture;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function create(EntityManagerInterface $entityManager): Response
    {
        // Création d'un nouvel objet
        $picture = new Picture();

        // Définition des différents attributs de l'objet
        $picture->setDescription("Photo des vacances")
            ->setDate(new DateTime())
            ->setFilename("fichier.img");

        // Prépare les données à être sauvegardées en base
        $entityManager->persist($picture);

        // Enregistre les données en base, créer l'ID unique
        $entityManager->flush();

        return $this->render('picture/create.html.twig', [
            'picture' => $picture
        ]);
    }
}
