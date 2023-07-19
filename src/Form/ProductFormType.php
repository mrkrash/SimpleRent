<?php

namespace App\Form;

use App\Common\Gender;
use App\Entity\Product;
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
            ->add('sizeXS', NumberType::class, ['label' => 'Qt. XS'])
            ->add('sizeS', NumberType::class, ['label' => 'Qt. S'])
            ->add('sizeM', NumberType::class, ['label' => 'Qt. M'])
            ->add('sizeL', NumberType::class, ['label' => 'Qt. L'])
            ->add('sizeXL', NumberType::class, ['label' => 'Qt. XL'])
            ->add('gender', EnumType::class, ['class' => Gender::class])
            ->add('ordering', NumberType::class, ['label' => 'Ordine'])
            ->add('enabled', CheckboxType::class, ['label' => 'Abilitato', 'required' => false])
            ->add('uploadImage', DropzoneType::class, ['data_class' => null, 'required' => $options['require_main_image'],])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'priceList_choices' => [],
            'require_main_image' => true,
        ]);
    }
}
