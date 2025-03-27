<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Contrôleur de la page du tableau de bord
 */
final class DashboardController extends AbstractController
{
    /**
     * Page de tableau de bord
     * Cette page contiendra les X dernières photos et les Y derniers évènements
     * liés à l'utilisateur qui sera in-fine connecté
     * 
     * @route dashboard
     * @name app_dashboard
     * 
     * @param Request $request (dépendance) Objet contenant la requête envoyé par le navigateur ($_POST/$_GET)
     * 
     * @return Response Réponse HTTP renvoyée au navigateur
     */
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
