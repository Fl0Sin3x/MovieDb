<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            // Comme le type de la propriété email est un string, Symfony ne sait pas qu'on veut un email
            // Il choisit donc pour nous, par défaut, un TextType
            // On doit préciser qu'on veut un EmailType pour avoir l'iunput attendu
            ->add('email', EmailType::class)
            // On précise qu'on veut un ChoiceType, ça nous permet de spécifier la liste des rôles et, surtout,
            // grâce à l'option multiple (true), ce type de champs retourne un array contenant
            // toutes les chaines de caractères cochées dans le formulaire
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            // Par défaut, la propriété password étant un string, Symfony nous affiche le mot de passe hashé dans un TextType
            // Ici, on ne veut pas que le mot de passe soit affiché, même hashé.
            // Cependant, on veut quand même voir le champs et, s'il est modifié, on mettra à jour le mot de passe encodé
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent être identiques.',
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer votre mot de passe'],
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
