<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
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
    private $name;

    public function getId(): ?int
    {
        return $this->id;
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


    /**
     * @ORM\ManyToMany(targetEntity=Subject::class, inversedBy="student")
     */
    private $subjects;
    public function __construct()
    {
        $this->subjects = new ArrayCollection();
    }

    /**
     * @return Collection|Subject[]
     */
    public function getSubjests(): Collection
    {
        return $this->subjects;
    }
    public function addSubject(Subject $subject): self
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects[] = $subject;
        }
        return $this;
    }
    public function removeSubject(Subject $subject): self
    {
        $this->subjects->removeElement($subject);
        return $this;
    }
}
