<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Form\Type\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HiddenFilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'value',
            HiddenType::class, [
            ]
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired([
                'property',
                'value',
            ])
            ->setAllowedTypes('property', ['string'])
            ->setAllowedTypes('value', ['string', 'boolean', 'integer', 'float']);
    }
}
