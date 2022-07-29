<?php

namespace App\Form;

use App\Entity\Artiste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddArtisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,[
                'label' => 'Prénom de l\'artiste',
                'required' => true,
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Nom de l\'artiste',
                'required' => false,
                'empty_data' => '',
            ])
            ->add('biography', TextareaType::class,[
                'required' => true,
                'label' => 'Biographie de l\'artiste',
                'attr' => [
                    'rows' => '5',
                ],
            ])
            ->add('birthday', BirthdayType::class,[
                'label' => 'Date d\'anniversaire de l\'artiste',
                'format' => 'dd MM yyyy',
                'placeholder' => [
                    'day' => 'Jour', 'month' => 'Mois', 'year' => "Année"
                ]
            ])
            ->add('picture', FileType::class,[
                'required' => false,
                'label' => 'Photo de l\'artiste',
                'mapped' => false,
            ])
            ->add('enregistrer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artiste::class,
        ]);
    }
}
