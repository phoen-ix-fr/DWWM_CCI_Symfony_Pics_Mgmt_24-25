<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class BootstrapCard
{
    public string $title;       //< Titre de la tuile (card)
    public string $imgSrc;      //< L'URL qui sera dans le src de l'image
    public string $btnLink;     //< Lien au clic sur le bouton du footer de la card
    public string $btnLabel;    //< Le texte du bouton du footer de la card

    
}
