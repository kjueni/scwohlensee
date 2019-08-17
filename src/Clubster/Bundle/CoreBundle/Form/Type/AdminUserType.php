<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Form\Type;

use Clubster\Component\Core\Model\AdminUser;
use Clubster\Component\Core\Model\Language;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Translation\TranslatorInterface;

class AdminUserType extends AbstractType
{

    /**
     * @var AuthorizationChecker
     */
    protected $authorizationChecker;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param AuthorizationChecker $authorizationChecker
     * @param TranslatorInterface $translator
     */
    public function __construct(
        AuthorizationChecker $authorizationChecker,
        TranslatorInterface $translator
    ) {
        $this->authorizationChecker = $authorizationChecker;
        $this->translator = $translator;
    }

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
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'name',
            ]);

        if ($this->authorizationChecker->isGranted(AdminUser::ROLE_ADMIN)) {
            $builder
                ->add('roles', ChoiceType::class, [
                    'choices' => [
                        AdminUser::ROLE_SUPERADMIN => $this->translator->trans('clubster.ui.superadmin', [], 'messages'),
                        AdminUser::ROLE_ADMIN => $this->translator->trans('clubster.ui.admin', [], 'messages'),
                        AdminUser::ROLE_USER => $this->translator->trans('clubster.ui.user', [], 'messages'),
                    ],
                    'choice_translation_domain' => 'messages',
                    'multiple' => true,
                    'required' => false,
                ]);

            $builder
                ->add('smsAuthentication', CheckboxType::class, [
                    'required' => false,
                ]);
        }

        $builder
            ->add('profile', ProfileType::class);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'adminUser';
    }
}

