<?php

namespace App\Form;

use App\Entity\Seancecoaching;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\File\File;


class UpdateSeancecoachingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('dateDebutSeance',DateType::class,[
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'html5'=>false,
            'placeholder' => 'Select a value',
            'attr' => ['class' => 'js-datepicker'],
        ])
        ->add('dateFinSeance',DateType::class,[
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'html5'=>false,
            'placeholder' => 'Select a value',
            'attr' => ['class' => 'js-datepicker'],
        ])
         
            ->add('prixSeance')
            ->add('descriptionSeance', null, [
                'empty_data' => ''
            ])
          
            
            ->add('imageSeance',FileType::class,[
                'mapped'=> false,
                'label'=>'please upload pictures',
                //'multiple'=>true   
                ],array('data_class' => null),) 

            ->add('titreSeance', null, [
                'empty_data' => ''
            ])
          
            ->add('Modifier',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seancecoaching::class,
        ]);
    }
}
