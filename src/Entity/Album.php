<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $titre;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $tracklist;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $date;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cover_front;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cover_back;

    #[ORM\ManyToOne(targetEntity: Artiste::class, inversedBy: 'albums')]
    private $artist;

    #[ORM\ManyToOne(targetEntity: Genre::class, inversedBy: 'albums')]
    private $genre;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'album')]
    private Collection $users;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $price;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $spotify;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_added;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    private ?Format $format = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->date_added = new DateTime();
    }

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

    public function getArtist(): ?artiste
    {
        return $this->artist;
    }

    public function setArtist(?artiste $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getGenre(): ?genre
    {
        return $this->genre;
    }

    public function setGenre(?genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addAlbum($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeAlbum($this);
        }

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSpotify(): ?string
    {
        return $this->spotify;
    }

    public function setSpotify(?string $spotify): self
    {
        $this->spotify = $spotify;

        return $this;
    }

    public function getDateAdded(): ?\DateTimeInterface
    {
        return $this->date_added;
    }

    public function setDateAdded(\DateTimeInterface $date_added): self
    {
        $this->date_added = $date_added;

        return $this;
    }

    public function getFormat(): ?format
    {
        return $this->format;
    }

    public function setFormat(?format $format): self
    {
        $this->format = $format;

        return $this;
    }
}
