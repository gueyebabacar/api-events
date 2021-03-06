<?php

namespace ApiBundle\Form;

use FSevestre\BooleanFormType\Form\Type\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class)
            ->add('pwd', TextType::class)
            ->add('enable', BooleanType::class, array(
                'true_values' => array(1, '1', true, 'true', 'on', 'yes'),
                'false_values' => array(0, '0', false, 'false', 'off', 'no')
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ApiSecurityBundle\Entity\AppClient',
            'method' => 'PATCH',
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
