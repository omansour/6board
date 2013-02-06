<?php

namespace M6\Bundle\SixBoardBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use M6\Bundle\SixBoardBundle\Entity\Project;

/**
 * Project fixtures
 */
class LoadProjectData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{

    /**
     * Returns the fixture's order
     *
     * @return integer
     */
    public function getOrder()
    {
        return 5;
    }

    /**
     * Loads the fixture
     *
     * @param ObjectManager $em The ObjectManager
     */
    public function load(ObjectManager $em)
    {
        $project = new Project;
        $project->setName('Minutefacile');

        $em->persist($project);
        $this->setReference('project_1', $project);

        $project = new Project;
        $project->setName('Turbo');

        $em->persist($project);
        $this->setReference('project_2', $project);

        $em->flush();

    }
}
