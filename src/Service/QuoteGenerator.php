<?php

namespace App\Service;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Service permettant la génération (récupération depuis une API) d'une citation
 * La citation est aléatoire
 */
final class QuoteGenerator
{
    public function __construct(
        private HttpClientInterface $client,
        private LoggerInterface $logger
    )
    {
        
    }

    /**
     * Retourne une citation sous la forme d'une chaîne de caractères
     * La citation est récupérée depuis le webservice (API) : https://zenquotes.io
     * 
     * @return string La citation récupérée, ou à défaut une citation fixe en cas de soucis de communication avec l'API
     */
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