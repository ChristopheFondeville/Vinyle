<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Artiste;
use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AddAlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Nom du restaurant',
                'required' => true,
                'attr' => ['placeholder' => 'Titre de l\'album'],
            ])
            ->add('tracklist', TextareaType::class,[
                'label' => 'Liste des chansons',
                'attr' => ['placeholder' => 'Liste des chansons'],
            ])
            ->add('date')
            ->add('cover_front', FileType::class, [
                'mapped' => false,
                'label' => 'Image cover Front (jpg/jpeg/png - max : 4M)',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4M',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid jpg/jpeg/png image',
                    ])
                ],
            ])
            ->add('cover_back', FileType::class, [
                'mapped' => false,
                'label' => 'Image cover Back (jpg/jpeg/png - max : 4M)',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4M',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid jpg/jpeg/png image',
                    ])
                ],
            ])
            ->add('artist', EntityType::class, [
                'class' => Artiste::class,
                'choice_label' => 'firstname',
                'label' => 'Artiste',
                'attr' => ['placeholder' => 'Nom de l\artiste'],
                'required' => true,
            ])
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'genre_name',
                'label' => 'Genre',
                'attr' => ['placeholder' => 'Genre'],
                'required' => true,
            ])
            ->add('enregistrer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
