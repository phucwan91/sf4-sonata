<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 * @UniqueEntity("email")
 */
class Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="Project", mappedBy="author")
     * @ORM\JoinColumn(nullable=true)
     */
    private $projects;

    /**
     * Author constructor.
     */
    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return ucfirst($this->getName()) ?? 'Author';
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return Author
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email|null
     *
     * @return Author
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return ArrayCollection|Project[]
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @param ArrayCollection|null $projects
     *
     * @return Author
     */
    public function setProjects(?ArrayCollection $projects): self
    {
        if ($projects) {
            $this->projects = new ArrayCollection();

            foreach ($projects as $project) {
                $this->addProject($project);
            }
        }

        return $this;
    }

    /**
     * @param Project $project
     *
     * @return Author
     */
    public function addProject(Project $project): self
    {
        $this->projects->add($project);

        $project->setAuthor($this);

        return $this;
    }
}
