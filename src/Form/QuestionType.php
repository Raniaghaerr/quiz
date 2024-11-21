<?php
// src/Form/QuestionType.php

// src/Form/QuestionType.php

// src/Form/QuestionType.php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enonce', TextareaType::class, [
                'label' => 'Texte de la question',
                'required' => true,
            ])
            ->add('reponses', CollectionType::class, [
                'entry_type' => ReponseType::class,  // Utilisation du formulaire de réponse
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Réponses',
                'required' => true,
                'entry_options' => [
                    'label' => false,
                ],
                'attr' => [
                    'class' => 'reponses-collection'
                ],
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\Count(['min' => 4, 'max' => 4, 'exactMessage' => 'Vous devez entrer exactement 4 réponses.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
