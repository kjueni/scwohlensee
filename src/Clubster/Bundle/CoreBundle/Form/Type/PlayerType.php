<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Form\Type;

use Clubster\Component\Core\Model\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Clubster\Bundle\PlayerBundle\Form\Type\PlayerType as BasePlayerType;

class PlayerType extends BasePlayerType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
            ]);
    }
}

