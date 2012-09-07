<?php

namespace Digitas\Demo\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Damien Pitard <dpitard at digitas dot fr>
 * @copyright Digitas France
 *
 * @Entity(repositoryClass="Digitas\Demo\Entity\UserRepository")
 * @Table(
 *   name="user"
 * )
 */
class User
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @Column(type="text", length=255, nullable=true)
     */
    protected $email;

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }
}