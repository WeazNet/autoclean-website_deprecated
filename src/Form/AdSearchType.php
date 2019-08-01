<?php

namespace App\Form;

use App\Entity\AdSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options = [
            'brands' => ['Audi', 'Bmw', 'Citroen', 'Fiat', 'Ford', 'Mercedes', 'Opel', 'Peugeot', 'Renault', 'Volkswagen', 'Abarth', 'Aixam', 'Aleko', 'Alfa Romeo', 'Alpina', 'Aro', 'Artega', 'Aston Martin', 'Autobianchi', 'Auverland', 'Bellier', 'Bentley', 'Bertone', 'Bluecar Groupe Bollore', 'Buick', 'Cadillac', 'Chevrolet', 'Chrysler', 'Dacia', 'Daewoo', 'Daihatsu', 'Dangel', 'De La Chapelle', 'Dodge', 'Donkervoort', 'Dr', 'Ds', 'Ferrari', 'Fisker', 'Gme', 'Grecav', 'Honda', 'Hummer', 'Hyundai', 'Infiniti', 'Innocenti', 'Isuzu', 'Iveco', 'Jaguar', 'Jeep', 'Kia', 'Lada', 'Lamborghini', 'Land Rover', 'Lexus', 'Ligier', 'Little', 'Lotus', 'Mahindra', 'Maruti', 'Maserati', 'Mastretta', 'Maybach', 'Mazda', 'Mclaren', 'Mega', 'Mg', 'Mia', 'Microcar', 'Mini', 'Mini Hummer', 'Mitsubishi', 'Morgan', 'Nissan', 'Pgo', 'Piaggio', 'Polski fso', 'Pontiac', 'Porsche', 'Proton', 'Rolls-royce', 'Rover', 'Saab', 'Santana', 'Savel', 'Seat', 'Shuanghuan', 'Simpa JDM', 'Skoda', 'Smart', 'Ssangyong', 'Subaru', 'Suzuki', 'Talbot', 'Tavria', 'Tesla', 'Toyota', 'Tvr', 'Volvo', 'Autres'],
            'fuels' => ['Essence', 'Diesel', 'Hybride', 'Electrique', 'GPL', 'Autre'],
            'gearsbox' => ['Manuelle', 'Automatique'],
            'sorts' => ['Trier par prix' => 'price', 'Trier par kilométrage' => 'mileage', 'Trier par année' => 'year']
        ];
        $brandsChoices = array_combine($options['brands'], $options['brands']);
        $fuelsChoices = array_combine($options['fuels'], $options['fuels']);
        $gearsboxChoices = array_combine($options['gearsbox'], $options['gearsbox']);

        $builder
            ->add('global', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Que cherchez vous comme véhicule ?'
                ]
            ])
            ->add('brand', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'choices' => ["Menu" => ['Trier par marque' => ''], "Marques" => $brandsChoices]
            ])
            ->add('fuel', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'choices' => ["Menu" => ['Trier par type de carburant' => ''], "Carburants" => $fuelsChoices]
            ])
            ->add('gearbox', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'choices' => ["Menu" => ['Trier par boîte de vitesse' => ''], "Boîtes de vitesse" => $gearsboxChoices]
            ])
            ->add('sort', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'choices' => ['Trier par ...' => '', "Choix" => $options['sorts']]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
