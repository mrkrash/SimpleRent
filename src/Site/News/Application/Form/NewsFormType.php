<?php

namespace App\Site\News\Application\Form;

use App\Shared\Enum\Lang;
use App\Shared\Form\QuillType;
use App\Site\News\Domain\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titolo'])
            ->add('date', DateType::class, ['label' => 'Data'])
            ->add('content', QuillType::class)
            ->add('lang', EnumType::class, ['class' => Lang::class])
            ->add('uploadSlides', FileType::class, [
                'attr' => [
                    'accept' => 'image/*',
                    'multiple' => 'multiple',
                ],
                'data_class' => null,
                'multiple' => true,
                'required' => $options['require_main_image'],
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
            'require_main_image' => false,
        ]);
    }
}
