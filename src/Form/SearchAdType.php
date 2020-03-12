<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchAdType extends AbstractType
{
    const PRICE = [25, 50, 75, 100, 125, 150, 175, 200];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('minPrice', ChoiceType::class, [
            'label' => 'Prix minimum (euro)',
            'choices' =>  array_combine(self::PRICE, self::PRICE)
        ])
            ->add('maxPrice', ChoiceType::class, [
                'label' => 'Prix maximum (euro)',
                'choices' =>  array_combine(self::PRICE, self::PRICE)
            ])
            ->add('recherche', SubmitType::class);
    }
}
