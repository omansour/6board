<?php

namespace M6\Bundle\SixBoardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use M6\Bundle\SixBoardBundle\Entity\Story;

/**
 * StoryType Form
 */
class StoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('status', 'genemu_jqueryselect2_choice', array(
                'choices'  => Story::$statuses,
                'multiple' => false,
                'expanded' => false,
                'required' => true,
            ))
            ->add('dueDate', 'genemu_jquerydate', array(
            'widget' => 'single_text'
            ))
            ->add('complexity')
            ->add('type', 'genemu_jqueryselect2_choice', array(
                'choices'  => Story::$types,
                'multiple' => false,
                'expanded' => false,
                'required' => true,
            ))
            ->add('milestones', 'genemu_jqueryselect2_entity', array(
                'class'    => 'M6\Bundle\SixBoardBundle\Entity\Milestone',
                'multiple' => true,
                'expanded' => false,
                'required' => true,
                'by_reference' => false
            ))
            ->add('tags', 'genemu_jqueryselect2_entity', array(
                'class'    => 'M6\Bundle\SixBoardBundle\Entity\Tag',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ))
            ->add('devUser', 'genemu_jqueryselect2_entity', array(
                'class'    => 'Application\Sonata\UserBundle\Entity\User',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'M6\Bundle\SixBoardBundle\Entity\Story'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'story_type';
    }
}
