<?php

namespace Hasheado\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseGroup;

/**
* @ORM\Entity
* @ORM\Table(name="fos_user_group")
*/
class Group extends BaseGroup
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
}
