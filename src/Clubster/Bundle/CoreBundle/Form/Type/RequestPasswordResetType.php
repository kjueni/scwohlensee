<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;

class RequestPasswordResetType extends AbstractResourceType
{

    /**
     * @param string $dataClass FQCN
     * @param string[] $validationGroups
     */
    public function __construct(string $dataClass, array $validationGroups = [])
    {
        parent::__construct($dataClass, $validationGroups);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
            ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'requestPasswordResetType';
    }
}
