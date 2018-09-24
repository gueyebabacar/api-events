<?php

namespace ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ApiBundle\Form\DataTransformer\TextToDateTimeDataTransformer;
use ApiBundle\Form\MediaType;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customerRef', TextType::class)
            ->add('name', TextType::class)
            ->add('date', TextType::class)
            ->add('detailedDescription', TextType::class)
            ->add('website', TextType::class)
            ->add('country', TextType::class)
            ->add('location', TextType::class)
            ->add('city', TextType::class)
            ->add('typeOfEvent', TextType::class)
            ->add('industry', TextType::class)
            ->add('thematicTag', TextType::class)
            ->add('nameOfOrganizer', TextType::class)
            ->add('contactForm', TextType::class)
            ->add('attachment', TextType::class)
            ->add('socialMediaSharing', TextType::class)
            ->add('status', TextType::class)
            ->add('visuel', TextType::class)
            ->add('illustrations', TextType::class);
        $builder->get('date')
           ->addModelTransformer(new TextToDateTimeDataTransformer());
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BusinessBundle\Entity\Event',
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
