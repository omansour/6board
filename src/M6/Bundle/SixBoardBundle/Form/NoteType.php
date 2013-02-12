<?php

namespace M6\Bundle\SixBoardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'M6\Bundle\SixBoardBundle\Entity\Note'
        ));
    }

    public function getName()
    {
        return 'm6_bundle_sixboardbundle_notetype';
    }
}
