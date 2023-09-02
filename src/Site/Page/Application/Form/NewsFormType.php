<?php

namespace App\Site\Page\Application\Form;

use App\Shared\Enum\Lang;
use App\Shared\Form\QuillType;
use App\Site\Page\Domain\Entity\Page;
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
            ->add('slug', TextType::class, [
                'help' => 'Inserire solo lettere e numeri senza spazi (ammesso il carattere _)',
            ])
            ->add('date', DateType::class, ['widget' => 'single_text', 'input' => 'datetime_immutable'])
            ->add('content', QuillType::class)
            ->add('lang', EnumType::class, ['class' => Lang::class])
            ->add('uploadSlides', FileType::class, [
                'attr' => [
                    'accept' => 'image/*',
                ],
                'data_class' => null,
                'required' => $options['require_main_image'],
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
            'require_main_image' => false,
        ]);
    }
}
