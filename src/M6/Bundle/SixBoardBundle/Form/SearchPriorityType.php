<?php

namespace M6\Bundle\SixBoardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchPriorityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('milestone', 'genemu_jqueryselect2_entity', array(
                'class'    => 'M6\Bundle\SixBoardBundle\Entity\Milestone',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
            ))
        ;
    }

    /**
     * setDefaultOptions
     *
     * @param OptionsResolverInterface $resolver The resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    /**
     * Returns the name of the form
     *
     * @return string
     */
    public function getName()
    {
        return 'search_priority_form';
    }
}
