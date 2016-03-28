<?php

namespace BigButtonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;

class TapType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class,array('class'=> 'BigButtonBundle:User',
                                                            'placeholder' => 'Choose an user',
                                                            'query_builder'=> function (EntityRepository $er)
                                                            {return $er->createQueryBuilder('u')->orderBy('u.id', 'ASC');}))
            ->add('task', EntityType::class,array('class'=> 'BigButtonBundle:Task',
                                                            'placeholder' => 'Choose a task',
                                                            'query_builder'=> function (EntityRepository $er)
                                                            {return $er->createQueryBuilder('u')->orderBy('u.id', 'ASC');}))
            ->add('infos',TextareaType::class,array('required' => false))
            ->add('tap',  SubmitType::class,  array('label'    => "TAP !"));
    }    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BigButtonBundle\Entity\Tap'
        ));
    }
}
