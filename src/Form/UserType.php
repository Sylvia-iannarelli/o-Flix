<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class UserType extends AbstractType
{
    private $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use($options) {

            $form = $event->getForm();

            $form->add('email', EmailType::class,[
                "label" => "Email",
                "attr" => [
                    "placeholder" => "Email de l'utilisateur"
                ]
            ]);

            if($options["custom_option"] === "new") {
                $form->add('password', RepeatedType::class,[
                    "type" => PasswordType::class,
                    "invalid_message" => 'Les mots de passe doivent être identiques',
                    "required" => true,
                    "first_options" => ["label" => "Mot de passe"],
                    "second_options" => ["label" => "Répéter le mot de passe"],
                    "attr" => [
                        "placeholder" => "Mot de passe"
                    ]
                ]);
            }

            if($user = $this->security->getUser()) {
                if($user->getRoles()==["ROLE_ADMIN","ROLE_USER"]) {
                    $form->add('roles', ChoiceType::class,[
                        "label" => "Privilèges",
                        "choices" => [
                            "Administrateur" => "ROLE_ADMIN",
                            "Manager" => "ROLE_MANAGER"
                        ],
                        "multiple" => true,
                        "expanded" => true
                    ]);
                }       
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'custom_option' => "default"
        ]);
    }
}
