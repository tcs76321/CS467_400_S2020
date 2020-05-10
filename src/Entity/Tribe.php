<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TribeRepository")
 */
class Tribe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $babies;

    /**
     * @ORM\Column(type="smallint")
     */
    private $children;

    /**
     * @ORM\Column(type="smallint")
     */
    private $adults;

    /**
     * @ORM\Column(type="smallint")
     */
    private $elders;

    /**
     * @ORM\Column(type="smallint")
     */
    private $horses;

    /**
     * @ORM\Column(type="smallint")
     */
    private $dogs;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $focus;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $direction;

    /**
     * @ORM\Column(type="smallint")
     */
    private $day;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="tribe", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Locale::class, inversedBy="tribes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Location;

    public function __construct($user)
    {
        $this->user = $user;
        $this->day = 0;
        $this->direction = NULL;
        $this->focus = NULL;
        $this->dogs = 3;
        $this->horses = 0;
        $this->elders = 0;
        $this->adults = 10;
        $this->children = 2;
        $this->babies = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBabies(): ?int
    {
        return $this->babies;
    }

    public function setBabies(int $babies): self
    {
        $this->babies = $babies;

        return $this;
    }

    public function getChildren(): ?int
    {
        return $this->children;
    }

    public function setChildren(int $children): self
    {
        $this->children = $children;

        return $this;
    }

    public function getAdults(): ?int
    {
        return $this->adults;
    }

    public function setAdults(int $adults): self
    {
        $this->adults = $adults;

        return $this;
    }

    public function getElders(): ?int
    {
        return $this->elders;
    }

    public function setElders(int $elders): self
    {
        $this->elders = $elders;

        return $this;
    }

    public function getHorses(): ?int
    {
        return $this->horses;
    }

    public function setHorses(int $horses): self
    {
        $this->horses = $horses;

        return $this;
    }

    public function getDogs(): ?int
    {
        return $this->dogs;
    }

    public function setDogs(int $dogs): self
    {
        $this->dogs = $dogs;

        return $this;
    }

    public function getFocus(): ?string
    {
        return $this->focus;
    }

    public function setFocus(?string $focus): self
    {
        $this->focus = $focus;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(?string $direction): self
    {
        $this->direction = $direction;

        return $this;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(int $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newTribe = null === $user ? null : $this;
        if ($user->getTribe() !== $newTribe) {
            $user->setTribe($newTribe);
        }

        return $this;
    }

    public function getLocation(): ?Locale
    {
        return $this->Location;
    }

    public function setLocation(?Locale $Location): self
    {
        $this->Location = $Location;

        return $this;
    }
}
