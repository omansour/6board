<?php

namespace M6\Bundle\SixBoardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SavedSearchType
 */
class SavedSearchType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('public')
            ->add('name')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'M6\Bundle\SixBoardBundle\Entity\Search'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'saved_search';
    }
}
