<?php

namespace App\Entity;

use App\Repository\LocaleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocaleRepository::class)
 */
class Locale
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="smallint")
     */
    private $Fertility;

    /**
     * @ORM\Column(type="smallint")
     */
    private $Danger;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Type;

    /**
     * @ORM\OneToOne(targetEntity=Locale::class, cascade={"persist", "remove"})
     */
    private $North;

    /**
     * @ORM\OneToOne(targetEntity=Locale::class, cascade={"persist", "remove"})
     */
    private $East;

    /**
     * @ORM\OneToOne(targetEntity=Locale::class, cascade={"persist", "remove"})
     */
    private $South;

    /**
     * @ORM\OneToOne(targetEntity=Locale::class, cascade={"persist", "remove"})
     */
    private $West;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getFertility(): ?int
    {
        return $this->Fertility;
    }

    public function setFertility(int $Fertility): self
    {
        $this->Fertility = $Fertility;

        return $this;
    }

    public function getDanger(): ?int
    {
        return $this->Danger;
    }

    public function setDanger(int $Danger): self
    {
        $this->Danger = $Danger;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getNorth(): ?self
    {
        return $this->North;
    }

    public function setNorth(?self $North): self
    {
        $this->North = $North;

        return $this;
    }

    public function getEast(): ?self
    {
        return $this->East;
    }

    public function setEast(?self $East): self
    {
        $this->East = $East;

        return $this;
    }

    public function getSouth(): ?self
    {
        return $this->South;
    }

    public function setSouth(?self $South): self
    {
        $this->South = $South;

        return $this;
    }

    public function getWest(): ?self
    {
        return $this->West;
    }

    public function setWest(?self $West): self
    {
        $this->West = $West;

        return $this;
    }
}
