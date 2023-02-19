<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Sponsor;
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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AjouterEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomEvent',TextType::class, ['label'=>'Nom Evenement '])
            ->add('lieu',TextType::class, ['label'=>'Lieu'])
            ->add('DateDebutE',DateType::class, ['label'=>'Date Debut'])
            ->add('DateFinE',DateType::class, ['label'=>'Date Fin'])
            ->add('AfficheE',FileType::class, ['label'=>'Affiche '])
            ->add('PrixTicket',NumberType::class, ['label'=>'Prix Ticket '])
            ->add('nbrPlaces',IntegerType::class, ['label'=>'Nombre de Places'])
            ->add('DescriptionEvent',TextareaType::class, ['label'=>'Description '])
          
            ->add('save', SubmitType::class, ['label'=>'ajouter Evenement '])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
