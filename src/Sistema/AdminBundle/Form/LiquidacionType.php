<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LiquidacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha1', 'genemu_jquerydate', array(
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',                    
                    'attr' => array('class' => 'date')
                ))
            ->add('fecha2', 'genemu_jquerydate', array(
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',                    
                    'attr' => array('class' => 'date')
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array());
    }

    public function getName()
    {
        return 'liquidacion';
    }
}
