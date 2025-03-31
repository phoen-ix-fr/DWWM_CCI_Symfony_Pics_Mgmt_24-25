<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class BootstrapCard
{
    public string $title;       //< Titre de la tuile (card)
    public string $imgSrc;      //< L'URL qui sera dans le src de l'image

    
}
