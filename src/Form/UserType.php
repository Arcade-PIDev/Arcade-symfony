<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Roles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Username')
            ->add('email')
            ->add('password')
            ->add('avatar',FileType::class,[
                'mapped'=> false,
                ],array('data_class' => null))
            ->add('isVerified')
            ->add('roles')

            ->add('roles', EntityType::class, [
                'class' => Roles::class,
                'choice_label' => 'typeRole',
                //'placeholder' => 'Choisir une categorie',
                'mapped' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
