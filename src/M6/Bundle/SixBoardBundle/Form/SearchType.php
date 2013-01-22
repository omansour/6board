<?php

namespace M6\Bundle\SixBoardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('status')
            ->add('dueDate')
            ->add('complexity')
            ->add('closedFor')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('type')
            ->add('milestones')
            ->add('toStories')
            ->add('tags')
            ->add('ownerUser')
            ->add('devUser')
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



// filtrage possible

// par projet (plusieurs possibles)
// par milestone (plusieurs possibles)
// par statut (plusieurs possibles)
// par type (plusieurs possibles) ?
// par rapporteur (plusieurs possibles) ?
// par utilisateur assigné (ceux avec personne aussi) (plusieurs possibles)
// sur numéro de demande
// plein texte sur le titre puis la description puis un tag
