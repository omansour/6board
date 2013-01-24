<?php

namespace M6\Bundle\SixBoardBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Story Repository
 */
class StoryRepository extends EntityRepository
{

    /**
     * Search query
     *
     * @param $filters array array of filters
     *
     * @return Query
     */
    public function search($filters)
    {
        $queryBuilder = $this->createQueryBuilder("s")
            ->leftJoin('s.milestones', 'm')
            ->leftJoin('m.project', 'p')
            ->leftJoin('s.ownerUser', 'ousr')
            ->leftJoin('s.devUser', 'dusr')
            ->leftJoin('s.tags', 't')
        ;


        if (isset($filters['project']) && !empty($filters['project']) ) {
            $ids = array();
            $entities = $filters['project']->toArray();

            if (!empty($entities)) {
                foreach ($entities as $entity) {
                    $ids[] = $entity->getId();
                }

                $queryBuilder->andWhere($queryBuilder->expr()->in('p.id', $ids));
            }
        }

        if (isset($filters['story_status']) && !empty($filters['story_status']) ) {
            $ids = array();
            $entities = $filters['story_status']->toArray();

            if (!empty($entities)) {
                foreach ($entities as $entity) {
                    $ids[] = $entity->getId();
                }

                $queryBuilder->andWhere($queryBuilder->expr()->in('s.status', $ids));
            }
        }

        if (isset($filters['story_type']) && !empty($filters['story_type']) ) {
            $ids = array();
            $entities = $filters['story_type']->toArray();

            if (!empty($entities)) {
                foreach ($entities as $entity) {
                    $ids[] = $entity->getId();
                }

                $queryBuilder->andWhere($queryBuilder->expr()->in('s.type', $ids));
            }
        }

        if (isset($filters['milestone']) && !empty($filters['milestone']) ) {
            $ids = array();
            $entities = $filters['milestone']->toArray();

            if (!empty($entities)) {
                foreach ($entities as $entity) {
                    $ids[] = $entity->getId();
                }

                $queryBuilder->andWhere($queryBuilder->expr()->in('m.id', $ids));
            }
        }

        if (isset($filters['milestone_status']) && !empty($filters['milestone_status']) ) {
            $queryBuilder->andWhere($queryBuilder->expr()->in('m.status', (array) $filters['milestone_status']));
        }

        if (isset($filters['ownerUser']) && !empty($filters['ownerUser']) ) {
            $ids = array();
            $entities = $filters['ownerUser']->toArray();

            if (!empty($entities)) {
                foreach ($entities as $entity) {
                    $ids[] = $entity->getId();
                }

                $queryBuilder->andWhere($queryBuilder->expr()->in('ousr.id', $ids));
            }
        }

        if (isset($filters['devUser']) && !empty($filters['devUser']) ) {
            $ids = array();
            $entities = $filters['devUser']->toArray();

            if (!empty($entities)) {
                foreach ($entities as $entity) {
                    $ids[] = $entity->getId();
                }

                $queryBuilder->andWhere($queryBuilder->expr()->in('dusr.id', $ids));
            }
        }

        if (isset($filters['tags']) && !empty($filters['tags']) ) {
            $ids = array();
            $entities = $filters['tags']->toArray();

            if (!empty($entities)) {
                foreach ($entities as $entity) {
                    $ids[] = $entity->getId();
                }

                $queryBuilder->andWhere($queryBuilder->expr()->in('t.id', $ids));
            }
        }

        if (isset($filters['description']) && $filters['description'] !== null) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like('s.description', $queryBuilder->expr()->literal('%'.$filters['description'].'%'))
            );
        }

        if (isset($filters['title']) && $filters['title'] !== null) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like('s.title', $queryBuilder->expr()->literal('%'.$filters['title'].'%'))
            );
        }

        if (isset($filters['id']) && $filters['id'] !== null) {
            $queryBuilder->andWhere('s.id = :id')
                ->setParameter('id', $filters['id']);
        }

        return $queryBuilder->getQuery();
    }
}
