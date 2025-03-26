<?php

namespace App\Form;

use App\Entity\Enemy;
use App\Entity\EnemyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnemyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type', EnumType::class, ['class' => EnemyType::class])
            ->add('energy')
            ->add('damage')
            ->add('fireRate')
            ->add('speed')
            ->add('visual')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enemy::class,
        ]);
    }
}
