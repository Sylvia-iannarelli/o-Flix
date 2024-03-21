<?php

namespace App\Form;

use App\Entity\Casting;
use App\Entity\Movie;
use App\Entity\Person;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CastingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('role', TextType::class, [
                "label" => "Rôle joué par l'acteur",
                "attr" => [
                    "placeholder" => "Nom du rôle"
                ]
            ])
            ->add('creditOrder', ChoiceType::class, [
                "label" => "Ordre dans la liste*",
                "choices" => [
                    "Premier" => "1",
                    "Deuxième" => "2",
                    "Troisième" => "2",
                    "Quatrième" => "2",
                    "Cinquième" => "2",
                ],
                "expanded" => true,
                "multiple" => false,
                "help" => "* une seule réponse possible"
            ])
            ->add('person', EntityType::class, [
                "label" => "Acteur*",
                "class" => Person::class,
                "multiple" => false,
                "expanded" => false,
                "help" => "* une seule réponse possible"
            ])
            ->add('movie', EntityType::class, [
                "label" => "Film / Série*",
                "class" => Movie::class,
                "multiple" => false,
                "expanded" => false,
                "help" => "* une seule réponse possible"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Casting::class,
        ]);
    }
}
