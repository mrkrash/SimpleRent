<?php

namespace App\Site\Affiliate\Application\Form;

use App\Site\Affiliate\Domain\Entity\Affiliate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class AffiliateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('web')
            ->add(
                'uploadImage',
                DropzoneType::class,
                [
                    'data_class' => null,
                    'required' => $options['require_main_image'],
                ]
            )
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Affiliate::class,
            'require_main_image' => true,
        ]);
    }
}
