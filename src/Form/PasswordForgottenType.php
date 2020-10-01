<?php

// namespace App\Form;

// use App\Form\ApplicationType;
// use Symfony\Component\Form\FormBuilderInterface;
// use Symfony\Component\OptionsResolver\OptionsResolver;
// use Symfony\Component\Form\Extension\Core\Type\EmailType;
// use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use Symfony\Component\Form\Extension\Core\Type\PasswordType;

// class PasswordForgottenType extends ApplicationType
// {
//     public function buildForm(FormBuilderInterface $builder, array $options)
//     {
//         $builder
//             ->add('email', EmailType::class, $this->getConfiguration("Email", "Rentrez votre adresse mail"))
//             ->add('save', SubmitType::class, $this->getConfiguration("Valider", ""));
//     }

//     public function configureOptions(OptionsResolver $resolver)
//     {
//         $resolver->setDefaults([
//             // Configure your form options here
//         ]);
//     }
// }
