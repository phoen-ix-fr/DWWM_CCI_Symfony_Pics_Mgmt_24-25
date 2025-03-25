<?php

namespace App\Service;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class QuoteGenerator
{
    public function __construct(
        private HttpClientInterface $client,
        private LoggerInterface $logger
    )
    {
        
    }

    public function getRandomQuote(): string
    {
        // Ne pas oublier le try-catch car on requête une ressource extérieur
        // Code à risque
        try {
            
            $response = $this->client->request(
                'GET',
                'https://zenquotes.io/api/random'
            );

            // Vérification du code d'erreur
            $statusCode = $response->getStatusCode();
            if($statusCode == 200) {

                // Transformer le contenu renvoyé sous la forme de chaine en format JSON (en objet)
                $content = json_decode($response->getContent());

                // On récupère l'index 0 du tableau (une seule valeur)
                // On renvoi l'attribut q de l'objet (objet créé via le json_decode)
                return $content[0]->q;
            }
        }
        catch(Exception $e)
        {
            $this->logger->error($e->getMessage());
        }

        return "Vaut mieux taper toujours les mêmes, il y en a moins qui râlent";
    }
}