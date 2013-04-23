<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConsumorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cantidad')
            ->add('subtotal')
            ->add('garantia')
            ->add('ordvolvo')
            ->add('remitovolvo')
            ->add('idRenaultrepuestos')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\AdminBundle\Entity\Consumor'
        ));
    }

    public function getName()
    {
        return 'sistema_adminbundle_consumortype';
    }
}
