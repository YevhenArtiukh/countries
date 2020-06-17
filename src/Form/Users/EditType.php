<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 20:25
 */

namespace App\Form\Users;


use App\Entity\Users\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Login'
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Imię'
            ])
            ->add('surname', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Nazwisko'
            ])
            ->add('age', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Wiek'
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'E-mail'
            ])
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'User' => User::ROLE_USER,
                    'Admin' => User::ROLE_ADMIN,
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Rola'
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-info'
                ],
                'row_attr' => [
                    'class' => 'text-center'
                ],
                'label' => 'Zmień'
            ])
        ;
    }
}