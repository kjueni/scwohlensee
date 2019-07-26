<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Form\Type;

use Clubster\Component\Core\Model\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['size' => 'm'])
            ->add('lastName', TextType::class, ['size' => 'm'])
            ->add('phoneNumber', TextType::class, ['required' => false, 'size' => 's', 'icon' => 'la la-phone'])
            ->add('mobileNumber', TextType::class,
                ['required' => false, 'size' => 's', 'icon' => 'la la-mobile-phone']);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'profile';
    }
}

