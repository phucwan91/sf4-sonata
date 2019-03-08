<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Author.
 *
 * @ORM\Entity
 * @ORM\Table(name="app__author")
 * @UniqueEntity("email")
 *
 * @author Phuc Vo <van-phuc.vo@ekino.com>
 */
class Author extends BaseUser
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * Get id.
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

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
        parent::__construct();

        $this->projects = new ArrayCollection();
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
