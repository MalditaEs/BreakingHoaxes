<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SourceTypes
 *
 * @ORM\Table(name="source_types")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SourceTypesRepository")
 */
class SourceTypes
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
	 * @ORM\Column(name="name", type="string", length=255)
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
	 * @return SourceTypes
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

