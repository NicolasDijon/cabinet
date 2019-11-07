<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CalculType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDerniereRegle', DateType::class, [
				'widget' => 'single_text',
                'html5'  => false,
                'attr' => [
                    'placeholder' => 'Voir le calendrier'
                ]
            ])
            
            ->add('dateConception', DateType::class, [
				'widget' => 'single_text',
                'html5'  => false,
                'attr' => [
                    'placeholder' => 'Voir le calendrier'
                ]
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
