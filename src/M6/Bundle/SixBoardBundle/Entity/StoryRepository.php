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

    }
}
