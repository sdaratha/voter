<?php

namespace App\Form;

use App\Entity\Vote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class VoteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Vor- und Nachname',
                'attr' => ['placeholder' => 'Gib hier deinen Namen ein'],
            ])
            ->add('email', null, [
                'label' => 'E-Mail',
                'attr' => ['placeholder' => 'Gib hier deine E-Mail ein'],
            ])
            ->add('question', null, [
                'label' => 'Frage',
                'attr' => ['placeholder' => 'Gib hier deine Frage ein'],
            ])
            ->add('answers', CollectionType::class, [
                'label' => 'Antworten',
                'entry_type' => AnswerFormType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Frage erstellen'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vote::class,
        ]);
    }
}
