<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OtroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:80px'),
//                    'data' => 0
                ))
            ->add('descripcion', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:160px'),
//                    'data' => 0
                ))
            ->add('precio', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:80px'),
//                    'data' => 0
                ))
            ->add('cantidad', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:40px'),
//                    'data' => 0
                ))            
            ->add('subtotal', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:270px'),
//                    'data' => 0
                ))
//            ->add('ordvolvo')
//            ->add('renaultorden')
//            ->add('pdcorden')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\AdminBundle\Entity\Otro'
        ));
    }

    public function getName()
    {
        return 'sistema_adminbundle_otrotype';
    }
}
