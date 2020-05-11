<?php

namespace App\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Name;

    public function __construct($user, EntityManagerInterface $entityManager)
    {
        $this->user = $user;
        $this->day = 0;
        $this->direction = NULL;
        $this->focus = NULL;
        $this->dogs = 3;
        $this->horses = 0;
        $this->elders = 0;
        $this->adults = 40;
        $this->children = 2;
        $this->babies = 0;

        $repository = $entityManager->getRepository(Locale::class);
        // look for a single Product by its primary key (usually "id")
        $locale = $repository->find(1);
        $this->Location = $locale;
    }

    public function endDay(Tribe $tribe, EntityManagerInterface $manager)
    {
        //Random Events

        //Basic Dynamics
        $tribe->incrementDay($manager);
        $tribe->updateBaseValues($manager);
        //change location last
        $tribe->changeLocation($manager);
        $manager->flush();
    }

    public function incrementDay(EntityManagerInterface $manager)
    {
        $this->setDay($this->getDay() + 1);
        $manager->flush();
    }

    public function changeLocation(EntityManagerInterface $manager)
    {
        $direction = $this->getDirection();
        if($direction)
        {
            if(($direction == 'North') && $this->getLocation()->getNorth())
            {
                $this->setLocation($this->getLocation()->getNorth());
            }
            elseif (($direction == 'South') && $this->getLocation()->getSouth())
            {
                $this->setLocation($this->getLocation()->getSouth());
            }
            elseif (($direction == 'East') && $this->getLocation()->getEast())
            {
                $this->setLocation($this->getLocation()->getEast());
            }
            elseif (($direction == 'West') && $this->getLocation()->getWest())
            {
                $this->setLocation($this->getLocation()->getWest());
            }
            $manager->flush();
        }
    }

    public function updateBaseValues(EntityManagerInterface $manager)
    {
        //babies
        $this->setBabies($this->getBabies() + 1);
        //children
        $this->setChildren($this->getChildren() + 1);
        //adults
        $this->setAdults($this->getAdults() + 1);
        //elders
        $this->setElders($this->getElders() + 1);
        //horses
        $this->setHorses($this->getHorses() + 1);
        //dogs
        $this->setDogs($this->getDogs() + 1);

        $manager->flush();
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

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }
}
