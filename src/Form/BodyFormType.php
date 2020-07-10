<?php

namespace App\Form;

use App\Entity\Body;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BodyFormType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug', TextType::class, [
                'constraints'=>new NotBlank(['message'=>'Complete this field.']),
                 'attr' => ['class' => 'form-row'],
            ])
            ->add('title', TextType::class, [
                'constraints'=>[new NotBlank(['message'=>'Complete this field.'])],
                 'attr' => ['class' => 'form-row'],
            ])
            ->add('description', TextareaType::class, [
                 'attr' => ['class' => 'form-row'],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Body::class,
        ]);
    }
    
}