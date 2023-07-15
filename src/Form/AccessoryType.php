<?php

namespace App\Form;

use App\Entity\Accessory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class AccessoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nome'])
            ->add('description', TextType::class, ['label' => 'Descrizione', 'required' => false,])
            ->add('dailyPrice', MoneyType::class, ['label' => 'Prezzo Giornaliero', 'divisor' => 100])
            ->add('weekPrice', MoneyType::class, ['label' => 'Prezzo Settimanale', 'divisor' => 100])
            ->add('uploadImage', DropzoneType::class, ['data_class' => null, 'required' => $options['require_main_image'],])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Accessory::class,
            'require_main_image' => true,
        ]);
    }
}
