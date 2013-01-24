<?php

namespace M6\Bundle\SixBoardBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use M6\Bundle\SixBoardBundle\Entity\Story;
use M6\Bundle\SixBoardBundle\Entity\Tag;

/**
 * Stories fixtures
 */
class LoadStoriesData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Returns the fixture's order
     *
     * @return integer
     */
    public function getOrder()
    {
        return 15;
    }

    /**
     * Loads the fixture
     *
     * @param  ObjectManager $em The ObjectManager
     */
    public function load(ObjectManager $em)
    {
        // Story 1
        $story = new Story;
        $story->setStatus(Story::STATUS_NEW);
        $story->setTitle('Bannières au mauvais format');
        $story->setDescription('Il faudrait prévoir de mettre les bannières au format 500x300');
        $story->setDueDate(new \DateTime('now'));
        $story->setType(Story::TYPE_MINOR);
        $story->addMilestone($this->getReference('milestone_1'));
            $tag = new Tag;
            $tag->setName('Publicite');
        $story->addTag($tag);
        $story->setOwnerUser($this->getReference('user_1'));

        $em->persist($story);
        $this->setReference('story_1', $story);

        // Story 2
        $story = new Story;
        $story->setStatus(Story::STATUS_NEW);
        $story->setTitle('Vidéo mal lue');
        $story->setDescription('La vidéo ne se lance pas automatiquement');
        $story->setDueDate(new \DateTime('now'));
        $story->setType(Story::TYPE_MINOR);
        $story->addMilestone($this->getReference('milestone_2'));
            $tag = new Tag;
            $tag->setName('Bug');
        $story->addTag($tag);
        $story->setOwnerUser($this->getReference('user_1'));

        $em->persist($story);
        $this->setReference('story_2', $story);

        $em->flush();

        // Story 3
        $story = new Story;
        $story->setStatus(Story::STATUS_NEW);
        $story->setTitle('Tag Google Analystics');
        $story->setDescription('Rajouter le tag js de GA en async');
        $story->setDueDate(new \DateTime('now'));
        $story->setType(Story::TYPE_MAJOR);
        $story->addMilestone($this->getReference('milestone_2'));
            $tag = new Tag;
            $tag->setName('Publicite');
        $story->addTag($tag);
        $story->setOwnerUser($this->getReference('user_2'));

        $em->persist($story);
        $this->setReference('story_2', $story);

        $em->flush();
    }
}
