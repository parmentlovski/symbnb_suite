<?php

namespace App\Form;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SearchAdType extends AbstractType
{

    public function __construct(AdRepository $adRepo)
    {
        $this->adRepo = $adRepo;
    }

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

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        // dd($this->adRepo->findAll());

        $builder
            ->add('ville', ChoiceType::class, [
                'choices' =>
                array_combine(self::CITIES, self::CITIES)
            ])
            // ->add('ville', EntityType::class, [
            //     'label' => 'ville',
            //     'class' => Ad::class,
            //     'choice_label' => function ($ad) {
            //         return $ad->getCity();
            //     }
            // ])
            ->add('minChambres', IntegerType::class, [
                'label' => 'Nombre de chambres minimum',
                'attr' => [
                    'min' => 1,
                    'max' => 10,
                    'step' => 1
                ]
            ])
            ->add('maxChambres', IntegerType::class, [
                'label' => 'Nombre de chambres maximum',
                'attr' => [
                    'min' => 1,
                    'max' => 10,
                    'step' => 1
                ]
            ])
            ->add('minimumPrice', IntegerType::class, [
                'label' => 'Prix Minimum',
                'attr' => [
                    'min' => 0,
                    'max' => 10000,
                    'step' => 50
                ]
            ])
            ->add('maximumPrice', IntegerType::class, [
                'label' => 'Prix Maximum',
                'attr' => [
                    'min' => 0,
                    'max' => 10000,
                    'step' => 50
                ]
            ])
            ->add('recherche', SubmitType::class);
    }
}
