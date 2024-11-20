<?php

namespace App\Form;

use App\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'label' => 'Titre du quiz',
                'required' => true,
            ])
            ->add('nbrequestion', IntegerType::class, [
                'label' => 'Nombre de questions',
                'required' => true,
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date du quiz',
                'required' => true,
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée (en minutes)',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
