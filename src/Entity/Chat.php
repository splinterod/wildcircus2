<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChatRepository")
 */
class Chat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artistes", inversedBy="chats")
     */
    private $artiste;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organisation", inversedBy="chats")
     */
    private $organisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getArtiste(): ?Artistes
    {
        return $this->artiste;
    }

    public function setArtiste(?Artistes $artiste): self
    {
        $this->artiste = $artiste;

        return $this;
    }

    public function getOrganisateur(): ?Organisation
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Organisation $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }
}
