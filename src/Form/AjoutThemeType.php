<?php

namespace App\Form;

use App\Entity\Theme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Atelier;

class AjoutThemeType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('libelle', TextType::class, [
                    'attr'=>[
                        'class' => 'form-control',
                    ]
                ])
                ->add('ateliers', EntityType::class, [
                    'class' => Atelier::class,
                    'choice_label' => 'libelle',
                    'multiple' => true,
                    'attr' => [
                        'class' => 'form-select form-select-sm',
                        'aria-label' => '.form-select-sm example',
                        'style' => 'margin-bottom: 8px;',
                    ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Theme::class,
        ]);
    }
}
