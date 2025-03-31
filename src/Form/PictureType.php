<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('filename', TextType::class, [
                'label' => "Nom du fichier"
            ])

            ->add('date', null, [
                'widget' => 'single_text',
                'label' => 'Date de prise'
            ])

            ->add('description', null, [
                'label' => "Description de la photo"
            ])

            ->add('event', EntityType::class, [
                'class' => Event::class,
                'label' => "Évènement associé (facultatif)",

                'choice_label'  => function(Event $event): string {
                    return $event->getTitle();
                }
            ])

            ->add('submit', SubmitType::class, [
                'label' => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
        ]);
    }
}
