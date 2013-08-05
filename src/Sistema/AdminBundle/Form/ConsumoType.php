<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConsumoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('codigo', 'text', array(                    
                    'label' => ' ',
                    'property_path' => false,
                    'attr' => array('style' => 'width:110px'),
                    'required'=> false,
//                    'empty_value' => 'Seleccionar repuesto',                
                ))
            ->add('stock', 'hidden', array(                    
                    'label' => ' ',
                    'property_path' => false,
                    'attr' => array('style' => 'width:110px'),
                    'required'=> false,
//                    'empty_value' => 'Seleccionar repuesto',                
                ))
//            ->add('Repvolvo', 'text', array(                    
//                    'label' => ' ',                    
//                    'attr' => array('style' => 'width:150px'),
//                    'property_path' => false,
//                ))
            ->add('idRep', 'hidden', array(                    
                    'label' => ' ',                    
                    'attr' => array('style' => 'width:150px'),
                    'property_path' => false,
                'required'=> false,
                ))
            ->add('Repvolvo', 'text', array(                    
                    'label' => ' ',                    
                    'attr' => array('style' => 'width:150px'),
                    'property_path' => false,
                ))
//            ->add('repuesto', 'text', array(                    
//                    'label' => ' ',
//                    'property_path' => false,
////                    'empty_value' => 'Seleccionar repuesto',                
//                ))
//            ->add('idRepvolvo', 'genemu_jqueryautocomplete_entity', array(
//            'class' => 'Sistema\AdminBundle\Entity\Repvolvo',
//            'property' => 'codigo',
//        ))
//         ->add('idRepvolvo', 'genemu_jqueryautocompleter_choice', array(
//            'route_name' => 'ajax'
//        ))
            ->add('Precio', null, array(
                    'label' => ' ',
                    'disabled' => false,
                    'attr' => array('style' => 'width:85px'),
                    'property_path' => false,
//                    'data' => 0
                ))
            ->add('Precio2', null, array(
                    'label' => ' ',
                    'disabled' => false,
                    'attr' => array('style' => 'width:85px'),
                    'property_path' => false,
//                    'data' => 0
                ))
            ->add('cantidad', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:40px'),
//                    'data' => 0
                ))
            ->add('garantia', null, array(
                    'label' => ' ',
                    'required'=> false,
                ))
            //->add('ordvolvo')           
            ->add('subtotal', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:80px'),
//                    'data' => 0
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\AdminBundle\Entity\Consumo'
        ));
    }

    public function getName()
    {
        return 'sistema_adminbundle_consumotype';
    }
}
