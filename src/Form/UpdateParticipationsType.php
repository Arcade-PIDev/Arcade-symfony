<?php

namespace App\Form;
use App\Entity\Seancecoaching;
use App\Entity\Participations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class UpdateParticipationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('nomJoueur', null, [
                'empty_data' => ''
            ])
             
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

            ->add('Modifier',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participations::class,
        ]);
    }
}
