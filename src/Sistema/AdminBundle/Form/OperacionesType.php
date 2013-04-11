<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OperacionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('denominacion', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:320px'),
                ))
            ->add('hs', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:100px'),
                'required'=> false,
                ))            
            ->add('subtotal', null, array(
                    'label' => ' ', 
                'required'=> false,
                ))
//            ->add('denominacion')
//            ->add('hs')
//            ->add('subtotal')
            //->add('ordvolvo')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\AdminBundle\Entity\Operaciones'
        ));
    }

    public function getName()
    {
        return 'sistema_adminbundle_operacionestype';
    }
}
