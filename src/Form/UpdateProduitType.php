<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberTypes;

class UpdateProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomProduit', null, [
                'empty_data' => ''
            ])
            ->add('prix', null, [
                'empty_data' => ''
            ])
            ->add('quantiteStock', null, [
                'empty_data' => ''
            ])
            ->add('image',FileType::class,[
                'mapped'=> false,
                'label'=>'please upload pictures',
                //'multiple'=>true   
                ],array('data_class' => null),) 
            ->add('description', null, [
                'empty_data' => ''
            ],TextareaType::class)
            ->add('creationDate')
            ->add('modificationDate')
            ->add('isEnabled',CheckboxType::class)
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nomCategorie',
                'placeholder' => 'Choisir une categorie',
                'mapped' => true])
            ->add('Modifier',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
