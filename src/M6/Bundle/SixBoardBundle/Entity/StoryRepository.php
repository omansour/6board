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
            ->leftJoin('s.storyMilestones', 'sm')
            ->leftJoin('sm.milestone', 'm')
            ->leftJoin('m.project', 'p')
            ->leftJoin('s.ownerUser', 'ousr')
            ->leftJoin('s.devUser', 'dusr')
            ->leftJoin('s.tags', 't')
        ;

        if (isset($filters['project']) && !empty($filters['project']) ) {
            $ids = self::extractIds($filters['project']);
            if (!empty($ids)) {
                $queryBuilder->andWhere($queryBuilder->expr()->in('p.id', $ids));
            }
        }

        if (isset($filters['story_status']) && !empty($filters['story_status']) ) {
            $queryBuilder->andWhere($queryBuilder->expr()->in('s.status', $filters['story_status']));
        }

        if (isset($filters['story_type']) && !empty($filters['story_type']) ) {
            $queryBuilder->andWhere($queryBuilder->expr()->in('s.type', $filters['story_type']));
        }

        if (isset($filters['milestone']) && !empty($filters['milestone']) ) {
            $ids = self::extractIds($filters['milestone']);
            if (!empty($ids)) {
                $queryBuilder->andWhere($queryBuilder->expr()->in('m.id', $ids));
            }
        }

        if (isset($filters['milestone_status']) && !empty($filters['milestone_status']) ) {
            $queryBuilder->andWhere($queryBuilder->expr()->in('m.status', (array) $filters['milestone_status']));
        }

        if (isset($filters['ownerUser']) && !empty($filters['ownerUser']) ) {
            $ids = self::extractIds($filters['ownerUser']);
            if (!empty($ids)) {
                $queryBuilder->andWhere($queryBuilder->expr()->in('ousr.id', $ids));
            }
        }

        if (isset($filters['devUser']) && !empty($filters['devUser']) ) {
            $ids = self::extractIds($filters['devUser']);
            if (!empty($ids)) {
                $queryBuilder->andWhere($queryBuilder->expr()->in('dusr.id', $ids));
            }
        }

        if (isset($filters['tags']) && !empty($filters['tags']) ) {
            $ids = self::extractIds($filters['tags']);
            if (!empty($ids)) {
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

    /**
     * Retrieves the stories attached to the given milestone
     *
     * @param Milestone $milestone The milestone
     *
     * @return array
     */
    public function fecthStoryNotClosedViaMilestone($milestone)
    {
        $queryBuilder = $this->createQueryBuilder("s")
            ->leftJoin('s.storyMilestones', 'sm')
            ->leftJoin('sm.milestone', 'm')
            ->where('m.id = :milestone_id')
            ->andWhere('s.status != '.Story::STATUS_CLOSED)
            ->orderBy('sm.rank', 'ASC')
            ->setParameter('milestone_id', $milestone->getId());

        return $queryBuilder->getQuery()->getResult();
    }

    protected static function extractIds($filter)
    {
        $ids = array();
        $entities = $filter->toArray();

        if (!empty($entities)) {
            foreach ($entities as $entity) {
                $ids[] = $entity->getId();
            }
        }
        return $ids;
    }
}
