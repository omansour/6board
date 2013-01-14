<?php

namespace M6\Bundle\SixBoardBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Application\Sonata\UserBundle\Entity\User;

/**
 * User's fixtures
 */
class LoadUserData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * Sets the Container associated with this Controller.
     *
     * @param ContainerInterface $container A ContainerInterface instance
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Returns the fixture's order
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * Loads the fixture
     *
     * @param  ObjectManager $em The ObjectManager
     */
    public function load(ObjectManager $em)
    {
        // USER 1
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setUsername('tristan.bessoussa');
        $user->setFirstname('Tristan');
        $user->setLastname('Bessoussa');
        $user->setEmail('tristan.bessoussa@yopmail.com');
        $user->setPlainPassword('tristan.bessoussa');
        $user->setEnabled(true);
        $user->setSuperAdmin(true);
        $user->addRole('ROLE_USER');

        $em->flush();

        $userManager->updateUser($user);

        $em->persist($user);
        $this->setReference('user_1', $user);

        // USER 2
        $user2 = $userManager->createUser();
        $user2->setUsername('olivier.mansour');
        $user2->setFirstname('Olivier');
        $user2->setLastname('Mansour');
        $user2->setEmail('olivier.mansour@yopmail.com');
        $user2->setPlainPassword('olivier.mansour');
        $user2->setEnabled(true);
        $user2->setSuperAdmin(false);
        $user2->addRole('ROLE_USER');

        $userManager->updateUser($user2);

        $em->persist($user2);
        $this->setReference('user_2', $user2);
    }
}
