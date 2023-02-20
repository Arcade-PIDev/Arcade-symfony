<?php

namespace App\Form;

use App\Entity\Participations;
use App\Entity\Seancecoaching;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ParticipationsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomJoueur')
            ->add('nombreParticipants')
            ->add('niveau', ChoiceType::class, [
                'choices'  => [
                    '' => null,
                    'FACILE' => 'FACILE',
                    'MOYEN' => 'MOYEN',
                    'DIFFICILE' => 'DIFFICILE',
                ],
            ])
            ->add('dateParticipations')
            ->add('idseancefk', EntityType::class, [
                'class' => Seancecoaching::class,
                'choice_label' => 'TitreSeance',
                'placeholder' => 'Choisir un titre ',
                'mapped' => true])
            
            ->add('Submit',SubmitType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participations::class,
        ]);
    }
}
