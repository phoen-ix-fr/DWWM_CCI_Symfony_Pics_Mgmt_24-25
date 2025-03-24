<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class BootstrapCard
{
    public string $title;
    public string $imgSrc;
    public string $btnLink;
    public string $btnLabel;

    
}
