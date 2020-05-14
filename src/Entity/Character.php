<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieActorRepository::class)
 *
 * @ORM\Table(name="movie_character")
 */
class Character
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Ici tu stock le nom du personnage fictif joué par l'acteur
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Movie", inversedBy="characters")
     */
    private $movie;


    /**
     * pour trouver le nom reel de l'cteur tu remonte vers le Person puis la propriété name
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="characters")
     */
    private $person;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacters(): ?string
    {
        return $this->characters;
    }

    public function setCharacters(string $characters): self
    {
        $this->characters = $characters;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }



}
