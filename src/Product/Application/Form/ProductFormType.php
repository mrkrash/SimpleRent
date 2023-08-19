<?php

namespace App\Product\Application\Form;

use App\Product\Domain\Entity\Product;
use App\Shared\Enum\BicycleType;
use App\Shared\Enum\Gender;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nome'])
            ->add('description', TextType::class, ['label' => 'Descrizione', 'required' => false,])
            ->add('priceList', ChoiceType::class, [
                'choices' => $options['priceList_choices'],
                'choice_label' => 'name',
                'label' => 'Listino',
            ])
            ->add('bicycleType', EnumType::class, ['class' => BicycleType::class])
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
            ->add('gender', EnumType::class, ['class' => Gender::class])
            ->add('ordering', NumberType::class, ['label' => 'Ordine'])
            ->add('enabled', CheckboxType::class, ['label' => 'Abilitato', 'required' => false])
            ->add('uploadImage', DropzoneType::class, [
                'data_class' => null,
                'required' => $options['require_main_image'],
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'priceList_choices' => [],
            'require_main_image' => true,
            'qty' => ['XS' => 0, 'S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0],
        ]);
    }
}
