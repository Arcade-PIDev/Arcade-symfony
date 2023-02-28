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
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AjouterEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomEvent',TextType::class, ['label'=>'Nom Evenement '])
            ->add('lieu',TextType::class, ['label'=>'Lieu'])
            ->add('DateDebutE',DateTimeType::class, [
                'date_widget' => 'single_text'
            ])
            ->add('DateFinE',DateTimeType::class, [
                'date_widget' => 'single_text'
            ])
            ->add('all_day', RadioType:: class)
            ->add('background_color', ColorType::class)
            ->add('border_color', ColorType::class)
            ->add('text_color', ColorType::class)
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
