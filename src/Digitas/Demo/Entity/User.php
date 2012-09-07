<?php

namespace Digitas\Demo\Entity;

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
     * @Column(type="text", length=255)
     */
    protected $email;

    /**
     * @Column(type="text", length=80)
     */
    protected $firstname;

    /**
     * @Column(type="text", length=80)
     */
    protected $lastname;

    public function getId()
    {
        return $this->id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }
}