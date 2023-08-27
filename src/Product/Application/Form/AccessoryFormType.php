<?php

namespace App\Product\Application\Form;

use App\Product\Domain\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('sizeXS', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. XS', 'data' => $options['qty']['XS']
            ])
            ->add('sizeS', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. S', 'data' => $options['qty']['S']
            ])
            ->add('sizeM', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. M', 'data' => $options['qty']['M']
            ])
            ->add('sizeL', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. L', 'data' => $options['qty']['L']
            ])
            ->add('sizeXL', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. XL', 'data' => $options['qty']['XL']
            ])
            ->add('size36', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. 36', 'data' => $options['qty']['S36']
            ])
            ->add('size37', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. 37', 'data' => $options['qty']['S37']
            ])
            ->add('size38', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. 38', 'data' => $options['qty']['S38']
            ])
            ->add('size39', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. 39', 'data' => $options['qty']['S39']
            ])
            ->add('size40', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. 40', 'data' => $options['qty']['S40']
            ])
            ->add('size41', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. 41', 'data' => $options['qty']['S41']
            ])
            ->add('size42', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. 42', 'data' => $options['qty']['S42']
            ])
            ->add('size43', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. 43', 'data' => $options['qty']['S43']
            ])
            ->add('size44', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. 44', 'data' => $options['qty']['S44']
            ])
            ->add('size45', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. 45', 'data' => $options['qty']['S45']
            ])
            ->add('size46', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. 46', 'data' => $options['qty']['S46']
            ])
            ->add('size47', NumberType::class, [
                'mapped' => false, 'label' => 'Qt. 47', 'data' => $options['qty']['S47']
            ])
            ->add('uploadImage', DropzoneType::class, [
                'data_class' => null,
                'required' => $options['require_main_image'],
            ])
            ->add('enabled', CheckboxType::class, ['label' => 'Abilitato', 'required' => false])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'priceList_choices' => [],
            'require_main_image' => true,
            'qty' => [
                'XS' => 0,
                'S' => 0,
                'M' => 0,
                'L' => 0,
                'XL' => 0,
                'S36' => 0,
                'S37' => 0,
                'S38' => 0,
                'S39' => 0,
                'S40' => 0,
                'S41' => 0,
                'S42' => 0,
                'S43' => 0,
                'S44' => 0,
                'S45' => 0,
                'S46' => 0,
                'S47' => 0,
            ],
        ]);
    }
}
