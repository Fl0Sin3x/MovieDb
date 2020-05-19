<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
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
            ->add('title')
            ->add('releaseDate', BirthdayType::class, [
                "widget" => "single_text"
            ])
            ->add('categories',EntityType::class, array(
                "class"=>Category::class,
                "choice_label"=>'label',
                'multiple' => true,
            ))
            ->add('writers', EntityType::class, array(
                "class"=>Person::class,
                "choice_label"=>'name',
                'multiple' => true,
                ))
            ->add('director', EntityType::class, array(
                "class"=>Person::class,
                "choice_label"=>'name',
                'multiple' => false,
            ))
            ->add('image', FileType::class, [
                'label' => 'image (JPG file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
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
            ])
            // ...
        ;



        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
            'data_cass'=>Category::class,
            'data_casse'=>Person::class,

        ]);
    }
}
