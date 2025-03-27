<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class BootstrapButton
{
    public string $text;            //< Texte qui sera affiché dans le bouton
    public string $strType = "";    //< Correspondra à la classe CSS de notre bouton
    public string $path;            //< Chemin du lien

    /**
     * Cette fonction est appelée lors du "montage" de notre composant sur notre vue TWIG
     * Elle nous permet de définir des comportements particuliers, dont la création d'attributs 
     * pour la balise HTML supplémentaires et d'y faire des opérations
     * 
     * Ici, on ajoute l'indication "outline-" sur la classe CSS de notre bouton si l'attribut
     * HTML isOutlined est indiqué dans le gabarit TWIG
     * 
     * @param string $type Type de bouton Bootstrap (par défaut, Primary)
     * @param boolean $isOutlined Si à vrai, le bouton sera uniquement entouré, à faux il sera de couleur pleine (par défaut, false)
     */
    public function mount(string $type = 'primary', bool $isOutlined = false): void
    {
        if($isOutlined) {
            $this->strType .= "outline-";
        }

        $this->strType .= $type;
    }
}
