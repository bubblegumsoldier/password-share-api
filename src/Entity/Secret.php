<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="secret")
 */
class Secret {
    /**
     * @ORM\Column(type="string", length=36)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    public $from_mail;

    /**
     * @ORM\Column(type="text")
     */
    public $hash;

    /**
     * @ORM\Column(type="text")
     */
    public $secret;

    /**
     * @ORM\Column(type="bigint")
     */
    public $created_at;

    /**
     * @ORM\Column(type="bigint")
     */
    public $valid_until;
    
    public function getFromMail()
    {
        return $this->from_mail;
    }

    public function setFromMail($fromMail)
    {
        $this->from_mail = $fromMail;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getValidUntil()
    {
        return $this->valid_until;
    }

    public function setValidUntil($valid_until)
    {
        $this->valid_until = $valid_until;
    }
}