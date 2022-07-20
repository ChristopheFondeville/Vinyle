<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text', nullable: true)]
    private $tracklist;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cover_front;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cover_back;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTracklist(): ?string
    {
        return $this->tracklist;
    }

    public function setTracklist(?string $tracklist): self
    {
        $this->tracklist = $tracklist;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCoverFront(): ?string
    {
        return $this->cover_front;
    }

    public function setCoverFront(?string $cover_front): self
    {
        $this->cover_front = $cover_front;

        return $this;
    }

    public function getCoverBack(): ?string
    {
        return $this->cover_back;
    }

    public function setCoverBack(?string $cover_back): self
    {
        $this->cover_back = $cover_back;

        return $this;
    }
}
