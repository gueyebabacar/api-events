<?php

namespace ApiBundle\Form;

use BusinessBundle\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class RegisterRequestType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('userId', TextType::class)
            ->add('compagnyName', TextType::class)
            ->add('email', TextType::class)
            ->add('phoneNumber', TextType::class)
            ->add('city', TextType::class)
            ->add('country', TextType::class)
            ->add('reasonForAttending', TextType::class)
            ->add('status', TextType::class)
            ->add('event', EntityType::class, array(
                'class' => Event::class
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BusinessBundle\Entity\RegisterRequest',
            'csrf_protection' => false,
            'method' => 'PATCH'
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
