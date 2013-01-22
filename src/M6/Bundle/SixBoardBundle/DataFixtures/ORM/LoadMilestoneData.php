<?php

namespace M6\Bundle\SixBoardBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use M6\Bundle\SixBoardBundle\Entity\Milestone;

/**
 * Milestones fixtures
 */
class LoadMilestoneData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Returns the fixture's order
     *
     * @return integer
     */
    public function getOrder()
    {
        return 10;
    }

    /**
     * Loads the fixture
     *
     * @param  ObjectManager $em The ObjectManager
     */
    public function load(ObjectManager $em)
    {
        $milestone = new Milestone;
        $milestone->setName('TMA');
        $milestone->setDescription('Suivi et maintenance');
        $milestone->setProject($this->getReference('project_1'));

        $em->persist($project);
        $this->setReference('milestone_1', $project);

        $milestone = new Milestone;
        $milestone->setName('WebPerf');
        $milestone->setDescription('Mesure de la performance du site web');
        $milestone->setProject($this->getReference('project_2'));

        $em->persist($project);
        $this->setReference('milestone_2', $project);

        $em->flush();

        $milestone = new Milestone;
        $milestone->setName('TMA');
        $milestone->setDescription('Suivi et maintenance');
        $milestone->setProject($this->getReference('project_2'));

        $em->persist($project);
        $this->setReference('milestone_3', $project);
    }
}
