<?php

namespace ApiBundle\Form;

use BusinessBundle\Entity\ValueList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customerRef', TextType::class)
            ->add('title', TextType::class)
            ->add('availableSeat', IntegerType::class)
            ->add('description', TextType::class)
            ->add('website', TextType::class)
            ->add('country', TextType::class)
            ->add('venue', TextType::class)
            ->add('city', TextType::class)
            ->add('organizer', TextType::class)
            ->add('contactEmail', TextType::class)
            ->add('attachment', TextType::class)
            ->add('socialMediaSharing', TextType::class)
            ->add('status', TextType::class)
            ->add('visuel', MediaType::class)
            ->add('illustrations', TextType::class)
            ->add('industries',  EntityType::class, [
                'class' => ValueList::class,
                'multiple' => true
            ])->add('eventTopic',  EntityType::class, [
                'class' => ValueList::class,
                'multiple' => true
            ])->add('eventType',  EntityType::class, [
                'class' => ValueList::class,
                'multiple' => true
            ])
            ->add('startDate',DateType::class,[
                'widget' => 'single_text',
                'required' => 'false',
                'format' => 'YYYY-MM-dd',
                'attr' => array('data-date-format' => 'YYYY-MM-DD')
            ])
            ->add('endDate',DateType::class,[
                'widget' => 'single_text',
                'required' => 'false',
                'format' => 'YYYY-MM-dd',
                'attr' => array('data-date-format' => 'YYYY-MM-DD')
            ])
            ->add('startHour',TimeType::class,[
                'input'  => 'datetime',
                'widget' => 'single_text',
                'with_minutes' => true,
                'with_seconds' => false
            ])
            ->add('endHour',TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'single_text',
                'with_minutes' => true,
                'with_seconds' => false
            ]);
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
