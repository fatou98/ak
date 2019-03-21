<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[ 'attr'=> ['class'=>'col-lg-12 form-control',' style'=>' margin-bottom:10px;']])
            ->add('prenom', TextType::class,[ 'attr'=> ['class'=>'col-lg-6 form-control',' style'=>' margin-bottom:10px;']])
            ->add('nom',TextType::class,[ 'attr'=> ['class'=>'col-lg-6 form-control',' style'=>' margin-bottom:10px;']])
            ->add('Numpiece',TextType::class,[ 'attr'=> ['class'=>'col-lg-6 form-control',' style'=>' margin-bottom:10px;']])
            ->add('adresse',TextType::class,[ 'attr'=> ['class'=>'col-lg-6 form-control',' style'=>' margin-bottom:10px;']])
            ->add('Tel',NumberType::class,[ 'attr'=> ['class'=>'col-lg-6 form-control',' style'=>' margin-bottom:10px;']])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Mot de passe','attr'=> ['class'=>'col-lg-6 form-control',' style'=>' margin-bottom:10px;']),
                'second_options' => array('label' => 'Confirmation du mot de passe','attr'=> ['class'=>'col-lg-6 form-control',' style'=>' margin-bottom:10px;']),
            ))
            ->add('submit', SubmitType::class, ['label'=>'Envoyer' , 'attr'=>['class'=>'btn btn-primary submit-btn btn-block', ' style' => 'margin-bottom:10px;']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
