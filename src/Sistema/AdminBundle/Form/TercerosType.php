<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TercerosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('denominacion', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:300px'),
//                    'data' => 0
                ))
            ->add('cantidad', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:60px'),
//                    'data' => 0
                ))
            ->add('unitario', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:130px'),
//                    'data' => 0
                ))
            ->add('subtotal', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:130px'),
//                    'data' => 0
                ))
            //->add('ordvolvo')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\AdminBundle\Entity\Terceros'
        ));
    }

    public function getName()
    {
        return 'sistema_adminbundle_tercerostype';
    }
}
