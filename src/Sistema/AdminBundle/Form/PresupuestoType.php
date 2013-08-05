<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PresupuestoType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
               
                
        $builder
             ->add('fecha', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'attr' => array('class' => 'date')
                ))
            ->add('cotizacion')
//            ->add('cliente')
            ->add('client', 'genemu_jqueryautocomplete_entity', array(
            'class' => 'Sistema\AdminBundle\Entity\Cliente',
            'data_class' => 'Sistema\AdminBundle\Entity\Cliente',
            'route_name' => 'ajax_agente',
//            'property' => 'nombre',
                'property_path' => false,
            )
                
        )
////                ->add('cliente')            
            ->add('porc_rep', 'text', array(                    
                    'label' => 'Porcentaje de Repuestos',
                    'property_path' => false,
                    'attr' => array('style' => 'width:110px'),
                    'required'=> false,
//                    'empty_value' => 'Seleccionar repuesto',                
                ))
            ->add('mo', 'text', array(                    
                    'label' => 'Costo mano de obra',
                    'property_path' => false,
                    'attr' => array('style' => 'width:110px'),
                    'required'=> false,
//                    'empty_value' => 'Seleccionar repuesto',                
                ))          
            ->add('consumos', 'collection', array(
            'type'         => new ConsumoType(),
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
        ))  
              ->add('otro', 'collection', array(
            'type'         => new OtroType(),
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
        ))
              ->add('operaciones', 'collection', array(
            'type'         => new PdcoperacionesType(),
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
        ))
           
            ->add('neto')
            ->add('iva')
//             ->add('iva', 'genemu_jqueryautocompleter_choice', array(
//            'route_name' => 'ajax'
//        ))
            ->add('total')
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
