<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchAdType extends AbstractType 
{

    const CITIES = [
        'Besançon',
        'Bordeaux',
        'Dijon',
        'Lyon',
        'Marseille',
        'Monaco',
        'Nantes',
        'Paris',
        'Rennes',
        'Reims'
    ];

    const ROOMS = [
        1,
        2,
        3,
        4,
        5
    ];

    const PRICE = [
        25,
        50,
        75,
        100,
        125,
        150,
        175,
        200
    ];

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('villes', ChoiceType::class, [
                'choices' =>
                    array_combine(self::CITIES, self::CITIES)
            ])
            ->add('chambres', ChoiceType::class, [
                'choices' => 
                    array_combine(self::ROOMS, self::ROOMS)
            ])
            ->add('minimumPrice', ChoiceType::class, [
                'label' => 'Prix Minimum',
                'choices' =>
                    array_combine(self::PRICE, self::PRICE)
            ])
            ->add('maximumPrice', ChoiceType::class, [
                'label' => 'Prix Maximum',
                'choices' => [
                    array_combine(self::PRICE, self::PRICE)
                ]
            ])
            ->add('recherche', SubmitType::class);
    }

}