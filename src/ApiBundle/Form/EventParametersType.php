<?php

namespace ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventParametersType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('organizer', TextType::class)
            ->add('status', TextType::class)
            ->add('industries', TextType::class)
            ->add('eventType', TextType::class)
            ->add('eventTopic', TextType::class)
            ->add('venue', TextType::class)
            ->add('sortBy', TextType::class)
            ->add('sortDir', TextType::class)
            ->add('connectedUser', TextType::class)
            ->add('country', TextType::class)
            ->add('city', TextType::class)
            ->add('createdAtFrom', DateTimeType::class, array(
                'widget' => 'single_text',
                'required' => 'false',
                'format' => 'YYYY-MM-dd',
                'attr' => array('data-date-format' => 'YYYY-MM-DD')
            ))
            ->add('createdAtTo', DateTimeType::class, array(
                'widget' => 'single_text',
                'required' => 'false',
                'format' => 'YYYY-MM-dd',
                'attr' => array('data-date-format' => 'YYYY-MM-DD')
            ))
            ->add('eventDateFrom', DateType::class, array(
                'widget' => 'single_text',
                'required' => 'false',
                'format' => 'YYYY-MM-dd',
                'attr' => array('data-date-format' => 'YYYY-MM-DD')
            ))
            ->add('eventDateTo', DateType::class, array(
                'widget' => 'single_text',
                'required' => 'false',
                'format' => 'YYYY-MM-dd',
                'attr' => array('data-date-format' => 'YYYY-MM-DD')
            ))
            ->add('limit', IntegerType::class, ['mapped' => false])
            ->add('offset', IntegerType::class, ['mapped' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BusinessBundle\ValueObject\EventParameters',
            'csrf_protection' => false
        ));
    }
}
