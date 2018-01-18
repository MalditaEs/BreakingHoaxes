<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Credibility
 *
 * @ORM\Table(name="credibility")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CredibilityRepository")
 */
class Credibility
{
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255, unique=true)
	 */
	private $name;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Source", mappedBy="type")
	 */
	private $sources;

	/**
	 * SourceTypes constructor.
	 *
	 */
	public function __construct() {
		$this->sources = new ArrayCollection();
	}


	/**
	 * @return mixed
	 */
	public function getSources() {
		return $this->sources;
	}

	/**
	 * @param mixed $sources
	 */
	public function setSources( $sources ) {
		$this->sources = $sources;
	}

	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Credibility
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
}

