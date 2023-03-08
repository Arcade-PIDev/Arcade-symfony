<?php

namespace App\Form;

use App\Entity\Tournois;
use App\Entity\Jeux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TournoisFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NBRparticipants')
            ->add('DureeTournois')
            ->add('DateDebutTournois')
            ->add('Idjeuxfk',  EntityType::class, [
                'class' => Jeux::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un jeu',
                'mapped' => true])
            ->add('Submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tournois::class,
        ]);
    }
}
