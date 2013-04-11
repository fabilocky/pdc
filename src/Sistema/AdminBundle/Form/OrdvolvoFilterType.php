<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class OrdvolvoFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'filter_number_range')
            ->add('fecha', 'filter_date_range')
            ->add('cotizacion', 'filter_number_range')
            ->add('cliente', 'filter_text')
            ->add('cuit', 'filter_text')
            ->add('chofer', 'filter_text')
            ->add('telefono', 'filter_text')
            ->add('chasis', 'filter_text')
            ->add('modelo', 'filter_text')
            ->add('dominio', 'filter_text')
            ->add('km', 'filter_number_range')
            ->add('hs', 'filter_number_range')
            ->add('color', 'filter_text')
            ->add('neto', 'filter_number_range')
            ->add('iva', 'filter_number_range')
            ->add('total', 'filter_number_range')
        ;

        $listener = function(FormEvent $event)
        {
            // Is data empty?
            foreach ($event->getData() as $data) {
                if(is_array($data)) {
                    foreach ($data as $subData) {
                        if(!empty($subData)) return;
                    }
                }
                else {
                    if(!empty($data)) return;
                }
            }

            $event->getForm()->addError(new FormError('Filter empty'));
        };
        $builder->addEventListener(FormEvents::POST_BIND, $listener);
    }

    public function getName()
    {
        return 'sistema_adminbundle_ordvolvofiltertype';
    }
}
