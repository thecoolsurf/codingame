<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\RolesRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\User;

class UserFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'constraints' => new NotBlank(['message' => 'Complete this field.']),
                'attr' => ['class' => 'form-row'],
            ])
            ->add('password', PasswordType::class, [
                'constraints' => new NotBlank(['message' => 'Complete this field.']),
                'attr' => ['class' => 'form-row'],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Administrator' => 'ROLE_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles' 
            ])
//            ->add('roles',EntityType::class, [
//                'class' => 'App:Roles',
//                'query_builder'=>function(\Doctrine\ORM\EntityRepository $er){
//                     return $er->createQueryBuilder('r')->orderBy('r.name','ASC');
//                },
//                'choice_label'=>'name',
//                'data' => true,
//                'mapped' => true,
//            ])
            ->add('lastname', TextType::class, [
                'constraints' => new NotBlank(['message' => 'Complete this field.']),
                'attr' => ['class' => 'form-row'],
            ])
            ->add('firstname', TextType::class, [
                'constraints' => new NotBlank(['message' => 'Complete this field.']),
                'attr' => ['class' => 'form-row'],
            ])
            ->add('email', TextType::class, [
                'constraints' => new NotBlank(['message' => 'Complete this field.']),
                'attr' => ['class' => 'form-row'],
            ])
            ->add('phone', TextType::class, [
                'constraints' => new NotBlank(['message' => 'Complete this field.']),
                'attr' => ['class' => 'form-row'],
            ])
            ->add('address', TextareaType::class, [
                'constraints' => new NotBlank(['message' => 'Complete this field.']),
                'attr' => ['class' => 'form-row'],
            ])
            ->add('zipcode', TextType::class, [
                'constraints' => new NotBlank(['message' => 'Complete this field.']),
                'attr' => ['class' => 'form-row'],
            ])
            ->add('city', TextType::class, [
                'constraints' => new NotBlank(['message' => 'Complete this field.']),
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
            'data_class' => User::class,

        ]);
    }

}
