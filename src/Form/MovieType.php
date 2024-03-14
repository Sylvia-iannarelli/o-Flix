<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre du film",
                "attr" => [
                    "placeholder" => "Titre du film"
                ]
            ])
            ->add('duration', IntegerType::class, [
                "label" => "Durée du film en minutes",
                "attr" => [
                    "placeholder" => "Durée en minutes"
                ]
            ])
            ->add('releaseDate', DateType::class, [
                "label" => "Date de sortie",
                "widget" => "single_text",
                "input" => "datetime_immutable"
            ])
            ->add('synopsis', TextareaType::class, [
                "label" => "Synopsis",
                "attr" => [
                    "placeholder" => "Synopsis"
                ]
            ])
            ->add('summary', TextareaType::class, [
                "label" => "Résumé",
                "attr" => [
                    "placeholder" => "Résumé du film"
                ]
            ])
            ->add('poster', UrlType::class, [
                "label" => "Url de l'image",
                "attr" => [
                    "placeholder" => "url"
                ]
            ])
            ->add('type', ChoiceType::class, [
                "label" => "Type*",
                "choices" => [
                    "Film" => "Film",
                    "Série" => "Série"
                ],
                "expanded" => true,
                "multiple" => false,
                "help" => "* une seule réponse possible"
            ])
            ->add('genres', EntityType::class, [
                "label" => "Genre(s)**",
                "class" => Genre::class,
                "multiple" => true,
                "expanded" => true,
                "choice_label" => "name",
                "help" => "** plusieurs réponses possibles"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
