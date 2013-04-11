<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RemitovolvoType extends AbstractType
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
            'type'         => new ConsumoType(),
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
            ))
            ->add('cliente')
            ->add('chasis')
            ->add('cotizacion')
            ->add('modelo')
            ->add('dominio')
            ->add('neto')
            ->add('aclaracion')
            ->add('observaciones')
            ->add('envia')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\AdminBundle\Entity\Remitovolvo',
            'csrf_protection'   => false
        ));
    }

    public function getName()
    {
        return 'remitovolvo';
    }
}
