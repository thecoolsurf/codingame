<?php

namespace App\Form\Admin;

use App\Entity\Body;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BodyFormType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('page',EntityType::class, [
                'class' => 'App:Page',
                'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                     return $er->createQueryBuilder('p')->orderBy('p.h1','ASC');
                },
                'choice_label' => 'h1',
                'attr' => ['class' => 'form-row'],
            ])
            ->add('h2', TextType::class, [
                'constraints' => [new NotBlank(['message' => 'Complete this field.'])],
                 'attr' => ['class' => 'form-row'],
            ])
            ->add('icon', TextType::class, [
                 'attr' => ['class' => 'form-row'],
            ])
            ->add('paragraph', TextareaType::class, [
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
