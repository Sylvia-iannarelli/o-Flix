<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                "label" => "Pseudo",
                "attr" => [
                    "placeholder" => "Votre pseudo"
                ]
            ])
            ->add('email', EmailType::class, [
                "label" => "Email",
                "attr" => [
                    "placeholder" => "Votre adresse mail"
                ]
            ])
            ->add('content', TextareaType::class, [
                "label" => "Commentaire",
                "attr" => [
                    "placeholder" => "Votre commentaire"
                ]
            ])
            ->add('rating', ChoiceType::class, [
                "label" => "Votre note *",
                "choices" => [
                    "Excellent" => 5,
                    "Très bon" => 4,
                    "Plutôt bon" => 3,
                    "Bof" => 2,
                    "Un vrai navet" => 1
                ],
                "expanded" => true,
                "multiple" => false,
                "help" => "* une seule réponse possible"
            ])
            ->add('reactions', ChoiceType::class, [
                "label" => "Votre humeur durant le visionnage **",
                "choices" => [
                    "Rire" => "Rire",
                    "Pleurer" => "Pleurer",
                    "Réfléchir" => "Reflechir",
                    "Dormir" => "Dormir",
                    "Rêver" => "Rever"
                ],
                "expanded" => true,
                "multiple" => true,
                "help" => "** plusieurs réponses possibles"
            ])
            ->add('watchedAt', DateType::class, [
                "label" => "Date de visionnage:",
                "widget" => "single_text",
                "input" => "datetime_immutable"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
