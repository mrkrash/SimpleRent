<?php

namespace App\Form;

use App\Entity\PriceList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nome'])
            ->add('price', MoneyType::class, ['label' => 'Prezzo Giornaliero', 'divisor' => 100])
            ->add('price3days', MoneyType::class, ['label' => 'Prezzo 3 giorni', 'divisor' => 100])
            ->add('price7days', MoneyType::class, ['label' => 'Prezzo 7 giorni', 'divisor' => 100])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PriceList::class,
        ]);
    }
}
