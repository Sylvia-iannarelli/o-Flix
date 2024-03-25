<?php

namespace App\Form;

use App\Entity\Movie;
use App\Entity\Season;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('movie', EntityType::class, [
                "label" => "Série*",
                "class" => Movie::class,
                "query_builder" => function (EntityRepository $er) {
                    return $er->createQueryBuilder('movie')
                        ->orderBy('movie.title', 'ASC');
                },
                "multiple" => false,
                "expanded" => false,
                "help" => "* une seule réponse possible"
            ])
            ->add('numberSeason', IntegerType::class, [
                "label" => "Saison numéro :",
                "attr" => [
                    "placeholder" => "Nombre"
                ]
            ])
            ->add('numberEpisode', IntegerType::class, [
                "label" => "Nombre d'épisode dans cette saison",
                "attr" => [
                    "placeholder" => "Nombre"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
}
