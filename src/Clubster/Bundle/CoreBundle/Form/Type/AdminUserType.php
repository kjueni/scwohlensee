<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Form\Type;

use Clubster\Component\Core\Model\AdminUser;
use Clubster\Component\Core\Model\Language;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
     * @var array
     */
    protected $availableRoles;

    /**
     * @param AuthorizationChecker $authorizationChecker
     * @param TranslatorInterface $translator
     * @param array $availableRoles
     */
    public function __construct(
        AuthorizationChecker $authorizationChecker,
        TranslatorInterface $translator,
        array $availableRoles = []
    ) {
        $this->authorizationChecker = $authorizationChecker;
        $this->translator = $translator;
        $this->availableRoles = $availableRoles;
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
            ->add('username', TextType::class, ['size' => 'm', 'icon' => 'la la-user'])
            ->add('email', TextType::class, ['size' => 'm', 'icon' => 'la la-envelope'])
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'name',
                'size' => 's',
            ]);


        if ($this->authorizationChecker->isGranted(AdminUser::ROLE_SUPERADMIN)) {
            $this->availableRoles['cloudtec_core']['cloudtec.ui.superadmin'] = AdminUser::ROLE_SUPERADMIN;
        }

        if ($this->authorizationChecker->isGranted(AdminUser::ROLE_ADMIN)) {
            $roles = $this->getRoles();

            $builder
                ->add('roles', ChoiceType::class, [
                    'choices' => $roles,
                    'choice_translation_domain' => 'messages',
                    'size' => 'm',
                    'multiple' => true,
                    'required' => false,
                ]);

            $builder
                ->add('smsAuthentication', CheckboxType::class, [
                    'switch' => true,
                    'required' => false,
                    'hint' => 'cloudtec.ui.sms_hint',
                ]);
        }

        $builder
            ->add('profile', ProfileType::class, ['size' => 'm']);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'adminUser';
    }

    /**
     * @return array
     */
    protected function getRoles(): array
    {
        $roles = [];

        foreach ($this->availableRoles as $moduleKey => $availableRoles) {
            $key = $this->translator->trans('cloudtec.ui.' . $moduleKey, [], 'messages');
            $roles[$key] = $availableRoles;
        }

        return $roles;
    }
}

