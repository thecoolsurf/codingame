<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\User;
use App\Entity\Question;
use App\Entity\Response;

class ResponseFormType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',EntityType::class, [
                'class' => User::class,
                'query_builder'=>function(\Doctrine\ORM\EntityRepository $er){
                     return $er->createQueryBuilder('u')->orderBy('u.username','ASC');
                },
                'choice_label' => 'username',
                'attr' => ['class' => 'form-row'],
            ])
            ->add('question',EntityType::class, [
                'class' => Question::class,
                'query_builder'=>function(\Doctrine\ORM\EntityRepository $er){
                     return $er->createQueryBuilder('q')->orderBy('q.title','ASC');
                },
                'choice_label' => 'title',
                'attr' => ['class' => 'form-row'],
            ])
            ->add('answer', TextareaType::class, [
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
            'data_class' => Response::class,
        ]);
    }
    
}
