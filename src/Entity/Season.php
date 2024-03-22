<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SeasonRepository::class)
 */
class Season
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"movies"})
     */
    private $numberEpisode;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"movies"})
     */
    private $numberSeason;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="seasons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberEpisode(): ?int
    {
        return $this->numberEpisode;
    }

    public function setNumberEpisode(int $numberEpisode): self
    {
        $this->numberEpisode = $numberEpisode;

        return $this;
    }

    public function getNumberSeason(): ?int
    {
        return $this->numberSeason;
    }

    public function setNumberSeason(int $numberSeason): self
    {
        $this->numberSeason = $numberSeason;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }
}
