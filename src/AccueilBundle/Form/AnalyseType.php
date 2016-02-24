<?php

namespace AccueilBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class AnalyseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('item',    TextType::class)
            ->add('comment', TextareaType::class,array('required' => false))
            ->add('category',EntityType::class,array('class'        => 'AccueilBundle:Category',
                                                     'choice_label' => 'name',
                                                     'query_builder'=> function (EntityRepository $er) {return $er->createQueryBuilder('u')->orderBy('u.id', 'ASC');}
                                                     ))
            ->add('object',  EntityType::class,array('class'        => 'AccueilBundle:Object',
                                                     'choice_label' => 'name',
                                                     'query_builder'=> function (EntityRepository $er) {return $er->createQueryBuilder('u')->orderBy('u.id', 'ASC');}
                                                     ))
            ->add('link',    TextType::class,array('required' => false));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AccueilBundle\Entity\Analyse'
        ));
    }
}
