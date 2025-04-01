<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')

            ->add('date', null, [
                'widget' => 'single_text',
            ])
            
            ->add('pictures', EntityType::class, [
                'class' => Picture::class,
                'label' => "Photo(s) associée(s) (facultatif)",

                'choice_label'  => function(Picture $picture): string {
                    return $picture->getDescription();
                },

                'multiple'  => true
            ])
            
            ->add('submit', SubmitType::class, [
                'label' => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
