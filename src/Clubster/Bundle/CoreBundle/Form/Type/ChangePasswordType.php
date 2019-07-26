<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePasswordType extends AbstractResourceType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'label' => 'sylius.form.user_change_password.current',
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'sylius.form.user_change_password.new'],
                'second_options' => ['label' => 'sylius.form.user_change_password.confirmation'],
                'invalid_message' => 'sylius.user.plainPassword.mismatch',
            ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'changePasswordType';
    }
}
