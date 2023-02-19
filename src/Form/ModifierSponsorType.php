<?php

namespace App\Form;

use App\Entity\Sponsor;
use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ModifierSponsorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('NomSponsor', TextType::class, ['label'=>'Nom Sponsor '])
        ->add('NumTelSponsor',NumberType::class, ['label'=>'Num Tel '])
        ->add('EmailSponsor', EmailType::class, ['label'=>'Email'])
        ->add('DomaineSponsor', TextType::class, ['label'=>'Domaine'])
        ->add('AdresseSponsor',TextareaType::class, ['label'=>'Adresse '])
        ->add('logoSponsor', FileType::class,array('data_class' => null), ['label'=>'Logo '])
        ->add('MontantSponsoring', NumberType::class, ['label'=>'Montant Sponsoring'])
        ->add('IDEventsFK',  EntityType::class, [
            'class' => Evenement::class,
            'choice_label' => 'NomEvent',
            'placeholder' => 'Choisir un evenement',
            'mapped' => true],  ['label'=>'Evenement sponsorisé'])

        ->add('save', SubmitType::class, ['label'=>'modifier Sponsor '])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sponsor::class,
        ]);
    }
}
