<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class BootstrapFormModal
{
    public string $btnText;
    public string $btnType;
    public string $modalId;
    public string $modalTitle;
}
