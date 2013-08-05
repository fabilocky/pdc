<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PedidoRepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('codigo', 'text', array(                    
                    'label' => ' ',
                    'property_path' => false,
                    'attr' => array('style' => 'width:100px'),
                    'required'=> false,
//                    'empty_value' => 'Seleccionar repuesto',                
                ))           
            ->add('Repvolvo', 'text', array(                    
                    'label' => ' ',                    
                    'attr' => array('style' => 'width:600px'),
                    'property_path' => false,
                ))//            
            ->add('cantidad', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:40px'),
//                    'data' => 0
                ))            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null
        ));
    }

    public function getName()
    {
        return 'sistema_adminbundle_consumotype';
    }
}
