<?php

namespace M6\Bundle\SixBoardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MilestoneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('dueDate')
            ->add('status')
            ->add('milestones', null, array('required' => false))
            ->add('project')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'M6\Bundle\SixBoardBundle\Entity\Milestone'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'm6_bundle_sixboardbundle_milestonetype';
    }
}
