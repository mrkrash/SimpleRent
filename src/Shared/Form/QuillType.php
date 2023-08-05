<?php

namespace App\Shared\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class QuillType extends AbstractType
{
    public function getParent()
    {
        return TextareaType::class;
    }
}