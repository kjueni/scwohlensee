<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Form\Type\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

class FulltextFilterType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $defaultOptions = [
            'size' => 'm',
            'placeholder' => 'cloudtec.ui.search_placeholder',
            'icon' => 'la la-search',
        ];

        $options = array_merge($defaultOptions, $options);

        unset($options['properties']);

        $options['placeholder'] = $this->translator->trans($options['placeholder']);

        $builder->add(
            'search',
            SearchType::class,
            $options
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'properties' => ['name'],
            ])
            ->setAllowedTypes('properties', ['array']);
    }
}
