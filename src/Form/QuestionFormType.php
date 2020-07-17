<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Question;

class QuestionFormType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categories',EntityType::class, [
                'class'=>'App:Category',
                'query_builder'=>function(\Doctrine\ORM\EntityRepository $er){
                     return $er->createQueryBuilder('c')->orderBy('c.title','ASC');
                },
                'choice_label' => 'title',
                'attr' => ['class' => 'form-row'],
            ])
            ->add('title', TextType::class, [
                'constraints'=>new NotBlank(['message'=>'Complete this field.']),
                 'attr' => ['class' => 'form-row'],
            ])
            ->add('description', TextareaType::class, [
                'constraints'=>new NotBlank(['message'=>'Complete this field.']),
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
            'data_class' => Question::class,
        ]);
    }
    
}
