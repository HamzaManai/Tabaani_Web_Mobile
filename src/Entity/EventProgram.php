<?php

namespace App\Entity;

use App\Repository\EventProgramRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventProgramRepository::class)
 */
class EventProgram
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activity;

    /**
     * @ORM\Column(type="time")
     */
    private $timestart;

    /**
     * @ORM\Column(type="time")
     */
    private $timeend;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(string $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function getTimestart(): ?\DateTimeInterface
    {
        return $this->timestart;
    }

    public function setTimestart(\DateTimeInterface $timestart): self
    {
        $this->timestart = $timestart;

        return $this;
    }

    public function getTimeend(): ?\DateTimeInterface
    {
        return $this->timeend;
    }

    public function setTimeend(\DateTimeInterface $timeend): self
    {
        $this->timeend = $timeend;

        return $this;
    }
}
