<?php

namespace M6\Bundle\SixBoardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use M6\Bundle\SixBoardBundle\Entity\Milestone;
use M6\Bundle\SixBoardBundle\Entity\Story;

class SearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project', 'genemu_jqueryselect2_entity', array(
                'class'    => 'M6\Bundle\SixBoardBundle\Entity\Project',
                'property' => 'name',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ))
            ->add('story_status', 'genemu_jqueryselect2_choice', array(
                'choices'  => Story::$statuses,
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'mapped'   => false,
            ))
            ->add('story_type', 'genemu_jqueryselect2_choice', array(
                'choices'  => Story::$types,
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'mapped'   => false,
            ))
            ->add('milestone', 'genemu_jqueryselect2_entity', array(
                'class'    => 'M6\Bundle\SixBoardBundle\Entity\Milestone',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ))
            ->add('milestone_status', 'genemu_jqueryselect2_choice', array(
                'choices' => Milestone::$statuses,
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ))
            ->add('ownerUser', 'genemu_jqueryselect2_entity', array(
                'class'    => 'Application\Sonata\UserBundle\Entity\User',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ))
            ->add('devUser', 'genemu_jqueryselect2_entity', array(
                'class'    => 'Application\Sonata\UserBundle\Entity\User',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ))
            ->add('tags', 'genemu_jqueryselect2_entity', array(
                'class'    => 'M6\Bundle\SixBoardBundle\Entity\Tag',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ))

            ->add('id', null, array('required' => false))
            ->add('description', null, array('required' => false))
            ->add('title', null, array('required' => false))
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
        return 'search_form';
    }
}
