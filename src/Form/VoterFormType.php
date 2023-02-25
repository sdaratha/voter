<?php

namespace App\Form;

use App\Entity\Voter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\VoterAnswerFormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VoterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => false,
                'attr' => ['placeholder' => 'Gib hier deinen Namen ein'],
            ])
            ->add('answers', CollectionType::class, [
                'entry_type' => VoterAnswerFormType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Antwort abgeben'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voter::class,
        ]);
    }
}
