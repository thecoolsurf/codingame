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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class UserFormType extends AbstractType
{
    
    private $roles = [];

    public function __construct(EntityManagerInterface $em) 
    { 
        $roles = $em->getRepository('App:Roles')->findAll();
        foreach ($roles as $role):
            array_push($this->roles,[$role->getName()=>$role->getLabel()]);
        endforeach;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder
            ->add('username', TextType::class, [
                'constraints' => new NotBlank(['message' => 'Complete this field.']),
                'attr' => ['class' => 'form-row'],
            ])
            ->add('password', PasswordType::class, [
                'constraints' => new NotBlank(['message' => 'Complete this field.']),
                'attr' => ['class' => 'form-row'],
            ])
            ;
//        if (in_array('ROLE_USER', $user->getRoles())):
//        $builder
//            ->add('roles', HiddenType::class, [
//                'attr' => ['class' => 'form-row'],
//            ]);
//        endif;
        if (in_array('ROLE_ADMIN', $user->getRoles())):
        $builder
            ->add('roles', ChoiceType::class, [
                'attr' => ['class' => 'form-row'],
                'choices' => $this->roles,
                'expanded' => true,
                'multiple' => true,
            ]);
        endif;
        $builder
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
            'user' => null,
        ]);
    }

}
