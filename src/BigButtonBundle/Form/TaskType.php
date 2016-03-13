<?php

namespace BigButtonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('task', EntityType::class,array('class'=> 'BigButtonBundle:Task',
                                                            'placeholder' => 'Choose an option',
                                                            'query_builder'=> function (EntityRepository $er)
                                                            {return $er->createQueryBuilder('u')->orderBy('u.id', 'ASC');}));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BigButtonBundle\Entity\Task'
        ));
    }
}
