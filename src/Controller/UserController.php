<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/user/delete/{id<\d+>}', name: 'app_user_delete')]
    public function delete(User $user, EntityManagerInterface $entityManager): Response
    {
        try {

            // Prépare l'objet à la suppression
            $entityManager->remove($user);

            // On lance la suppression en base
            $entityManager->flush();

            // Si tout s'est bien passé, je redirige vers la liste
            $this->addFlash(
                'success',
                "La suppression a été effectuée"
            );

        } catch(\Exception $exc) {

            
            // Je prépare un flash qui s'affichera à l'écran avec le message d'erreur de l'exception
            $this->addFlash(
                'error',
                $exc->getMessage()
            );
            
        } finally {
            
            return $this->redirectToRoute('app_user');
        }

    }
}
