<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class PdcordenFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'filter_number_range')
            ->add('fecha', 'filter_date_range')
            ->add('cotizacion', 'filter_text')
            ->add('chofer', 'filter_text')
            ->add('chasis', 'filter_text')
            ->add('modelo', 'filter_text')
            ->add('dominio', 'filter_text')
            ->add('cam', 'filter_text')
            ->add('fechafab', 'filter_date_range')
            ->add('km', 'filter_number_range')
            ->add('hs', 'filter_number_range')
            ->add('color', 'filter_text')
            ->add('neto', 'filter_text')
            ->add('iva', 'filter_text')
            ->add('total', 'filter_text')
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
        return 'sistema_adminbundle_pdcordenfiltertype';
    }
}
