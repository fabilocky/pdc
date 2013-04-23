<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RenaultsolicrepType extends AbstractType
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
            'data_class' => 'Sistema\AdminBundle\Entity\Renaultsolicrep'
        ));
    }

    public function getName()
    {
        return 'sistema_adminbundle_renaultsolicreptype';
    }
}
