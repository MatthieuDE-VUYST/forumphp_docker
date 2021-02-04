<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
				'constraints' => [
					new NotBlank([
						'message' => 'Merci d\'entrer un e-mail',
					]),
				],
				'required' => true,
				'attr' => ['class' =>'form-control'],
				])
            ->add('password', PasswordType::class,[
		    'constraints' => [
		        new NotBlank([
		            'message' => 'Merci d\'entrer un mot de passe',
		        ]),
		    ],
		    'required' => true,
		    'attr' => ['class' =>'form-control'],
		    'label' => 'Mot de passe'
		    ])
            ->add('date_naissance', BirthdayType::class,[
				'placeholder' => [
					'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
				],
				'constraints' => [
					new NotBlank([
						'message' => 'Merci d\'entrer la date de naissance de la personne',
					]),
				],
				'required' => true,
				])
            ->add('pseudo', TextType::class,[
				'constraints' => [
					new NotBlank([
						'message' => 'Merci d\'entrer le prénom de la personne',
					]),
				],
				'required' => true,
				'attr' => ['class' =>'form-control'],
				])
	    ->add('roles', ChoiceType::class, [
				'choices' => [
					'Administrateur' => 'ROLE_ADMIN'
				],
				'expanded' => true,
				'multiple' => true,
				'label' => 'Rôle',
				'attr' => ['class' =>'form-check'],
				])
            ->add('valider', SubmitType::class,[
				'attr' => ['class' =>'btn btn-info'],
				])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
