<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PedidoType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
               
                
        $builder
             ->add('fecha', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'attr' => array('class' => 'date')
                ))                     
            ->add('consumos', 'collection', array(
            'type'         => new PedidoRepType(),
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
        ))          
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(            
            'csrf_protection'   => false
        ));
    }

    public function getName()
    {
        return 'ordvolvo';
    }
}
