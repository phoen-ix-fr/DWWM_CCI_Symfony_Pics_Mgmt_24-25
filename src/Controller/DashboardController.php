<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(Request $request): Response
    {
        // URL de la forme : localhost:8000/dashboard?lastpictures=3
        // dd($request); //< Debug and die d'une variable, 
        //                  affiche le détail et coupe l'exécution du code => var_dump(..);die;

        $intLastPictures = $request->query->get('lastpictures', 10); // valeur par défaut de 10
        //dd($intLastPictures);

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
