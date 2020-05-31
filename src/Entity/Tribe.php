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

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $sedentism;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $event;

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
        $this->sedentism = 0;
        $this->event = NULL;

        $repository = $entityManager->getRepository(Locale::class);
        // look for a single Product by its primary key (usually "id")
        $locale = $repository->find(1);
        $this->Location = $locale;
    }

    public function reConstruct(EntityManagerInterface $entityManager)
    {
        $this->direction = NULL;
        $this->focus = NULL;
        $this->dogs = 3;
        $this->day = 0;
        $this->horses = 0;
        $this->elders = 0;
        $this->adults = 40;
        $this->children = 2;
        $this->babies = 0;

        $repository = $entityManager->getRepository(Locale::class);
        // look for a single Product by its primary key (usually "id")
        $locale = $repository->find(1);
        $this->Location = $locale;

        $this->sedentism = 0;
        $this->event = NULL;

        $this->Name = 'Nameless';

        $entityManager->flush();
    }

    public function endDay(Tribe $tribe, EntityManagerInterface $manager)
    {
        if(($tribe->checkIfAlive()) && !($tribe->checkIfWon()))
        {
            $tribe->incrementDay($manager);
            $tribe->basicGrowth($manager);
            $tribe->parameterChange($manager);
            $tribe->randomEvent($manager);
            $tribe->checkIfWon();
            $tribe->changeLocation($manager);
            $tribe->preventNegatives($manager);
            $manager->flush();
        }
    }

    public function preventNegatives($manager)
    {
        if($this->getDogs() < 0){$this->setDogs(0);}
        if($this->getHorses() < 0){$this->setHorses(0);}
        if($this->getElders() < 0){$this->setElders(0);}
        if($this->getBabies() < 0){$this->setBabies(0);}
        if($this->getChildren() < 0){$this->setChildren(0);}
        $manager->flush();
    }

    public function randomEvent(EntityManagerInterface $manager)
    {
        srand(time());

        $randomNumber = rand(1, 999);

        if($randomNumber > 950)
        {
            $this->setEvent("Comet Sighting");
            $this->setBabies($this->getBabies() + 1);
        }
        elseif($randomNumber > 900)
        {
            $this->setEvent("Dire Wolf Attack");
            $this->setAdults($this->getAdults() - 4);
        }
        elseif($randomNumber > 700)
        {
            $this->setEvent("Found a Horse");
            $this->setHorses($this->getHorses() + 1);
        }
        elseif($randomNumber > 500)
        {
            $this->setEvent("Found a few Dogs");
            $this->setDogs($this->getDogs() + 3);
        }
        else
        {
            $this->setEvent("Beautiful Weather");
        }

        $manager->flush();
    }

    public function checkIfDead()
    {
        if($this->getAdults() <= 0)
        {
            return true;
        }

        return false;
    }

    public function checkIfAlive()
    {
        if($this->getAdults() <= 0)
        {
            return false;
        }

        return true;
    }

    public function checkIfWon()
    {
        if(($this->sedentism >= 10) && ($this->getAdults() >= 0))
        {
            return true;
        }

        return false;
    }

    public function parameterChange(EntityManagerInterface $manager)
    {
        $fertility = $this->getLocation()->getFertility();

        $this->setBabies($this->getBabies() + $fertility);
        $this->setChildren($this->getChildren() + $fertility);
        $this->setAdults($this->getAdults() + $fertility);
        $this->setElders($this->getElders() + $fertility);

        // Danger
        $danger = $this->getLocation()->getDanger();

        $this->setBabies($this->getBabies() - $danger);
        $this->setChildren($this->getChildren() - $danger);
        $this->setAdults($this->getAdults() - $danger);
        $this->setElders($this->getElders() - $danger);

        // Focus

        $focus = $this->getFocus();

        if ($focus == 'Settle Area')
        {
            $dir = $this->getDirection();
            if(!(($dir == 'North') || ($dir == 'South') || ($dir == 'East') || ($dir == 'West')))
            {
                $this->sedentism = $this->sedentism + 1;
            }
        }
        elseif ($focus == 'Search for Other Tribes')
        {
            // Nothing until multiplayer
        }
        else{// Default aka gather resources
            $this->setBabies($this->getBabies() + 3);
            $this->setChildren($this->getChildren() + 3);
            $this->setAdults($this->getAdults() + 3);
            $this->setElders($this->getElders() + 3);
        }

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

    public function basicGrowth(EntityManagerInterface $manager)
    {
        $oldBabies = $this->getBabies();
        $oldChildren = $this->getChildren();
        $oldAdults = $this->getAdults();
        $oldElders = $this->getElders();

        $newBabies = ((($oldBabies)*2)/3) + $oldAdults/10;
        $newChildren = ((($oldChildren)*2)/3) + $oldBabies/3;
        $newAdults = ((($oldAdults)*4)/5) + $oldChildren/3;
        $newElders = ((($oldElders)*2)/3) + $oldAdults/5;

        //babies
        $this->setBabies($newBabies);
        //children
        $this->setChildren($newChildren);
        //adults
        $this->setAdults($newAdults);
        //elders
        $this->setElders($newElders);

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

    public function getSedentism(): ?int
    {
        return $this->sedentism;
    }

    public function setSedentism(?int $sedentism): self
    {
        $this->sedentism = $sedentism;

        return $this;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function setEvent(?string $event): self
    {
        $this->event = $event;

        return $this;
    }
}
