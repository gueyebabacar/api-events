<?php

namespace ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customerRef')
            ->add('name')
            ->add('date')
            ->add('detailedDescription')
            ->add('webSite')
            ->add('country')
            ->add('location')
            ->add('city')
            ->add('typeOfEvent')
            ->add('industry')
            ->add('thematicTag')
            ->add('nameOfOrganizer')
            ->add('contactForm')
            ->add('attachment')
            ->add('socialMediaSharing')
            ->add('status')
            ->add('visuel');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BusinessBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'businessbundle_event';
    }


}
