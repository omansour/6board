<?php

namespace M6\Bundle\SixBoardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class StoryPriorityType
 */
class StoryPriorityType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('milestone', 'genemu_jqueryselect2_entity', array(
                'class'    => 'M6\Bundle\SixBoardBundle\Entity\Milestone',
                'multiple' => false,
                'expanded' => false,
                'required' => true,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'priority_story';
    }
}
