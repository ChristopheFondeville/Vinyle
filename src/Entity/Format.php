<?php

namespace App\Entity;

use App\Repository\FormatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormatRepository::class)]
class Format
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 45)]
    private $format_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormatName(): ?string
    {
        return $this->format_name;
    }

    public function setFormatName(string $format_name): self
    {
        $this->format_name = $format_name;

        return $this;
    }
}
