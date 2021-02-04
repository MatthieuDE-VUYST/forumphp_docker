<?php

namespace App\Form;

use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', TextType::class,[
				'constraints' => [
					new NotBlank([
						'message' => 'Merci d\'entrer le message',
					]),
				],
				'required' => true,
				'attr' => ['class' =>'form-control'],
				])
            ->add('valider', SubmitType::class,[
				'attr' => ['class' =>'btn btn-info'],
				])
            //->add('date_poste')
            //->add('sujet')
            //->add('utilisateur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}
