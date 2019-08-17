<?php

declare(strict_types=1);

namespace Clubster\Bundle\TeamBundle\Form\Type;

use Clubster\Component\Team\Model\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Team::class,
            ]
        );
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextareaType::class)
            ->add('description', TextareaType::class)
            ->add('league', TextType::class)
            ->add('url', TextType::class)
            ->add('gamesUrl', TextType::class)
            ->add('resultsUrl', TextType::class);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'teamType';
    }
}

