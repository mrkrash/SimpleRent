<?php

namespace App\Form;

use App\Entity\Accessory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class AccessoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nome'])
            ->add('description', TextType::class, ['label' => 'Descrizione', 'required' => false,])
            ->add('dailyPrice', MoneyType::class, ['label' => 'Prezzo Giornaliero', 'divisor' => 100])
            ->add('weekPrice', MoneyType::class, ['label' => 'Prezzo Settimanale', 'divisor' => 100])
            ->add('sizeXS', NumberType::class, ['label' => 'Qt. XS'])
            ->add('sizeS', NumberType::class, ['label' => 'Qt. S'])
            ->add('sizeM', NumberType::class, ['label' => 'Qt. M'])
            ->add('sizeL', NumberType::class, ['label' => 'Qt. L'])
            ->add('sizeXL', NumberType::class, ['label' => 'Qt. XL'])

            ->add('size36', NumberType::class, ['label' => 'Qt. 36'])
            ->add('size37', NumberType::class, ['label' => 'Qt. 37'])
            ->add('size38', NumberType::class, ['label' => 'Qt. 38'])
            ->add('size39', NumberType::class, ['label' => 'Qt. 39'])
            ->add('size40', NumberType::class, ['label' => 'Qt. 40'])
            ->add('size41', NumberType::class, ['label' => 'Qt. 41'])
            ->add('size42', NumberType::class, ['label' => 'Qt. 42'])
            ->add('size43', NumberType::class, ['label' => 'Qt. 43'])
            ->add('size44', NumberType::class, ['label' => 'Qt. 44'])
            ->add('size45', NumberType::class, ['label' => 'Qt. 45'])
            ->add('size46', NumberType::class, ['label' => 'Qt. 46'])
            ->add('size47', NumberType::class, ['label' => 'Qt. 47'])

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
