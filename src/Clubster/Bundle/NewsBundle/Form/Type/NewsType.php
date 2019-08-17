<?php

declare(strict_types=1);

namespace Clubster\Bundle\NewsBundle\Form\Type;

use Clubster\Component\News\Model\News;
use Clubster\Component\News\Model\NewsType as NewsTypeModel;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => News::class,
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
            ->add('author', TextType::class, ['required' => true,])
            ->add('title', TextType::class, ['required' => true,])
            ->add('lead', TextareaType::class)
            ->add('text', TextareaType::class)
            ->add('type', EntityType::class, [
                'required' => true,
                'class' => NewsTypeModel::class,
                'choice_label' => 'name',
            ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'newsType';
    }
}

