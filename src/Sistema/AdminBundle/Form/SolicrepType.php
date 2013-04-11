<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SolicrepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion', null, array(
                    'label' => ' ',
                    'attr' => array('style' => 'width:500px'),
//                    'data' => 0
                ))
//            ->add('ordvolvo')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\AdminBundle\Entity\Solicrep',
            'csrf_protection'   => false
        ));
    }

    public function getName()
    {
        return 'solicrep';
    }
}
