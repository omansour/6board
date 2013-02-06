<?php

namespace Application\Sonata\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;

/**
 * Class User
 */
class User extends BaseUser
{
   /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $jabberId
     */
    protected $jabberId;

    /**
     * The constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set jabberId
     *
     * @param  string $jabberId
     * @return User
     */
    public function setJabberId($jabberId)
    {
        $this->jabberId = $jabberId;

        return $this;
    }

    /**
     * Get jabberId
     *
     * @return string
     */
    public function getJabberId()
    {
        return $this->jabberId;
    }
}
