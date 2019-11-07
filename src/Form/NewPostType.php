<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NewPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('message', TextareaType::class)
            ->add('practicien', ChoiceType::class, ([
                'choices'  => [
                    'THORAX Nathalie' => 'THORAX Nathalie',
                    'CLEMENT Noémie' => 'CLEMENT Noémie',
                    'ROMAGNE Vincent' => 'ROMAGNE Vincent',
                ]
            ]))
            ->add('photoFile', VichImageType::class, [
				'allow_delete' => false,
				'download_uri' => false,
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
