<?php

namespace Sistema\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RepvolvoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo')
            ->add('descripcion')
            ->add('cd')
            ->add('precio')
            ->add('cantidad')
            ->add('tipo', 'choice', array(
    'choices'   => array('volvo' => 'Volvo', 'renault' => 'Renault', 'pdc' => 'PDC'),
    'required'  => false,
));
                
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\AdminBundle\Entity\Repvolvo'
        ));
    }

    public function getName()
    {
        return 'sistema_adminbundle_repvolvotype';
    }
}
