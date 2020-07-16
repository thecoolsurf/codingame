<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Response;

class ResponseFormType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('question',EntityType::class, [
//                'class'=>'App:Question',
//                'query_builder'=>function(\Doctrine\ORM\EntityRepository $er){
//                    return $er->createQueryBuilder('q')
//                    ->from('App\Entity\Categories', 'c')
//                    ->leftJoin('q.categories', 'c')
//                    ->orderBy('q.id', 'ASC')
//                    ;
//                },
//                'choice_label'=>'title',
//                 'attr' => ['class' => 'form-row'],
//            ])
            ->add('answer', TextareaType::class, [
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
            'data_class' => Response::class,
        ]);
    }
    
}
