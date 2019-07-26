<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Form\Type;

use Clubster\Component\Core\Model\AdminUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserResetType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdminUser::class,
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enabled', CheckboxType::class, ['required' => false])
            ->add('resetPassword', CheckboxType::class, [
                'value' => '1',
                'required' => false,
                'mapped' => false,
            ]);

        $builder->get('enabled')->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $isActive = $event->getData();
                $form = $event->getForm();

                if ($isActive === false) {
                    $form->getParent()->remove('resetPassword');
                }
            }
        );
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix(): string
    {
        return 'userReset';
    }
}
