<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PdcordenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'attr' => array('class' => 'date')
                ))
             ->add('fechafab', 'genemu_jquerydate', array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',                    
                    'attr' => array('class' => 'date')
                ))
             ->add('client', 'genemu_jqueryautocomplete_entity', array(
            'class' => 'Sistema\AdminBundle\Entity\Cliente',
            'data_class' => 'Sistema\AdminBundle\Entity\Cliente',
            'route_name' => 'ajax_agente',
                'property_path' => false,
            )                
        )
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
             ->add('operaciones', 'collection', array(
            'type'         => new PdcoperacionesType(),
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
        ))
            ->add('solicitudes', 'collection', array(
            'type'         => new PdcsolicrepType(),
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
        ))
            ->add('consumos', 'collection', array(
            'type'         => new PdcconsumoType(),
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
        ))
            ->add('terceros', 'collection', array(
            'type'         => new PdctercerosType(),
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
        ))
            ->add('cotizacion')
            ->add('chofer')
            ->add('chasis')
            ->add('modelo')
            ->add('dominio')
            ->add('km')
            ->add('hs')
            ->add('color')
                ->add('cam')
            ->add('neto')
            ->add('iva')
            ->add('total')
            ->add('cliente')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\AdminBundle\Entity\Pdcorden',
            'csrf_protection'   => false
        ));
    }

    public function getName()
    {
        return 'pdcorden';
    }
}
