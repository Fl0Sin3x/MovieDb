<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class, [
                "label" => "Titre"
            ])

            ->add('releaseDate', DateType::class, [
                "label" => "Date de sortie",
                "widget" => "single_text"
            ])
            ->add('categories',EntityType::class, array(
                "label" => "Catégories",
                "class"=>Category::class,
                "choice_label"=>'label',
                'multiple' => true,
                "expanded" => true
            ))
            ->add('writers', EntityType::class, array(
                "label" => "Réalisateur",
                "class"=>Person::class,
                "choice_label"=>'name',
                'multiple' => true,
                ))
            ->add('director', EntityType::class, array(
                "label" => "Scénaristes",
                "class"=>Person::class,
                "choice_label"=>'name',
                'multiple' => false,

            ))
            ->add('movieActors', CollectionType::class, [
                'entry_type' => MovieActorType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                "by_reference" => false
            ])

            ->add('image', FileType::class, [
                'label' => 'Affiche',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '536k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/x-jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ]);
        ;}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
            'data_cass'=>Category::class,
            'data_casse'=>Person::class,

        ]);
    }
}
