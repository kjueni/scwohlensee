<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class PasswordResetType extends AbstractResourceType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'clubster.ui.password',
                ],
                'second_options' => [
                    'label' => 'clubster.ui.password_confirmation',
                ],
            ]);
    }


    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'resetPassword';
    }
}
