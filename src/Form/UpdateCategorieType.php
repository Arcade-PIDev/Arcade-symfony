<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class UpdateCategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCategorie', null, [
                'empty_data' => ''
            ])
            ->add('description', null, [
                'empty_data' => ''
            ])
            ->add('image',FileType::class,[
                'mapped'=> false,
                'label'=>'please upload pictures',
                //'multiple'=>true   
                ],array('data_class' => null),) 
            ->add('isEnabled',CheckboxType::class)
            ->add('Modifier',SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
