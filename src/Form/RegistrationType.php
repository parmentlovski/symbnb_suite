<?php

namespace App\Form;

use App\Entity\User;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class RegistrationType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration("Prénom", "Votre prénom"))
            ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Votre nom"))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Votre email"))
            ->add('picture', UrlType::class, $this->getConfiguration("Url", "Url de l'imge"))
            ->add('hash', PasswordType::class, $this->getConfiguration("Mot de passe", "Votre mot de passe"))
            ->add('passwordConfirm',  PasswordType::class, $this->getConfiguration("Confirmation du mot de passe", "Veuillez confirmer votre mot de passe"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Présentez-vous en quelques mots"))
            ->add('description', TextType::class, $this->getConfiguration("Description détaillée", "C'est le moment de vous présentez
            "))
            ->add(
                'captcha',
                CaptchaType::class,
                array(
                    'invalid_message' => "Le captcha est invalide, veuillez réessayer",
                    'label' => 'Captcha',
                    'attr' => [
                        'placeholder' => "Veuillez renseigner les caractères affichés sur le captcha"
                    ]
                )
            )
            ->add('validate', CheckboxType::class, [
                'invalid_message' => "Veuillez cocher la case",
                'label' => 'En vous inscrivant vous acceptez les conditions générales',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
