<?php

namespace M6\Bundle\SixBoardBundle\Entity;

use Doctrine\ORM\EntityRepository;

use M6\Bundle\SixBoardBundle\Entity\Follow;

/**
 * Follow Repository
 */
class FollowRepository extends EntityRepository
{

    /**
     * Returns an array of followers for a given type
     *
     * @param object $object The object
     * @param string $type   The type
     *
     * @return DoctrineCollection
     */
    public function getFollowersFor($object, $type)
    {
        $queryBuilder = $this->createQueryBuilder("f")
            ->andWhere('f.objectClass = :objectClass')
            ->andWhere('f.objectId = :objectId')

            ->setParameters(array(
                'objectClass' => $type,
                'objectId'    => $object->getId(),
            ));

        return $queryBuilder->getQuery()->getResult();
    }


}
