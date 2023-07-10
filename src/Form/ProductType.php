<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nome'])
            ->add('description', TextType::class, ['label' => 'Descrizione', 'required' => false,])
            ->add('image', DropzoneType::class, ['required' => $options['require_main_image'],])
            ->add('priceList', ChoiceType::class, [
                'choices' => $options['priceList_choices'],
                'choice_label' => 'name',
            ])
            ->add('qty', NumberType::class, ['label' => 'Quantità'])
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
