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
     * @param ObjectManager $em The ObjectManager
     */
    public function load(ObjectManager $em)
    {
        // Milestone 1
        $milestone = new Milestone;
        $milestone->setName('TMA');
        $milestone->setDescription('Suivi et maintenance');
        $milestone->setProject($this->getReference('project_1'));
        $milestone->setStatus(Milestone::STATUS_OPEN);

        $em->persist($milestone);
        $this->setReference('milestone_1', $milestone);

        // Milestone 2
        $milestone = new Milestone;
        $milestone->setName('WebPerf');
        $milestone->setDescription('Mesure de la performance du site web');
        $milestone->setProject($this->getReference('project_2'));
        $milestone->setStatus(Milestone::STATUS_OPEN);

        $em->persist($milestone);
        $this->setReference('milestone_2', $milestone);

        // Milestone 3
        $milestone = new Milestone;
        $milestone->setName('TMA');
        $milestone->setDescription('Suivi et maintenance');
        $milestone->setProject($this->getReference('project_2'));
        $milestone->setStatus(Milestone::STATUS_OPEN);

        $em->persist($milestone);
        $this->setReference('milestone_3', $milestone);

        $em->flush();
    }
}
