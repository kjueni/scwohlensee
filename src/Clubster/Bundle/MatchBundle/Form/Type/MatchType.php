<?php

declare(strict_types=1);

namespace Clubster\Bundle\MatchBundle\Form\Type;

use Clubster\Component\Match\Model\Competition;
use Clubster\Component\Match\Model\Match;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Match::class,
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
            ->add('opponent', TextType::class, ['required' => true,])
            ->add('startsOn', DateTimeType::class)
            ->add('isAway', CheckboxType::class)
            ->add('homeScore', NumberType::class)
            ->add('awayScore', NumberType::class)
            ->add('competition', EntityType::class, [
                'required' => true,
                'class' => Competition::class,
                'choice_label' => 'name',
            ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'matchType';
    }
}

