<?php

namespace ApiBundle\Form;

use BusinessBundle\Entity\ValueList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
            ->add('title', TextType::class)
            ->add('detailedDescription', TextType::class)
            ->add('website', TextType::class)
            ->add('country', TextType::class)
            ->add('venue', TextType::class)
            ->add('city', TextType::class)
            ->add('nameOfOrganizer', TextType::class)
            ->add('contactForm', TextType::class)
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
            ->add('date',DateTimeType::class,[
                'widget' => 'single_text',
                'input' => 'datetime',
                'required' => 'false',
                'format' => 'YYYY-MM-dd HH:mm',
                'attr' => array('data-date-format' => 'YYYY-MM-DD HH:mm')
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
