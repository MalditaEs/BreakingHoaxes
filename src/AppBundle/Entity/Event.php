<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 */
class Event
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
	 * @var \DateTime
	 *
	 * @ORM\Column(name="createdAt", type="datetime")
	 */
	private $createdAt;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="closedAt", type="datetime", nullable=true)
	 */
	private $closedAt;

	/**
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Source", inversedBy="event")
	 * @ORM\JoinTable(name="events_sources")
	 */
	private $sources;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Information", mappedBy="event")
	 *
	 */
	private $informations;

	/**
	 * @var
	 * @ORM\Column(type="string", length=255)
	 */
	private $image;

	public function __construct() {
		$this->sources = new ArrayCollection();
		$this->informations = new ArrayCollection();
	}

	/**
	 * @return mixed
	 */
	public function getInformations() {
		return $this->informations;
	}

	/**
	 * @param mixed $informations
	 */
	public function setInformations( $informations ) {
		$this->informations = $informations;
	}


	/**
	 * @return ArrayCollection
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
	 * @return Event
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

	/**
	 * Set createdAt
	 *
	 * @param \DateTime $createdAt
	 *
	 * @return Event
	 */
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	/**
	 * Get createdAt
	 *
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * Set closedAt
	 *
	 * @param \DateTime $closedAt
	 *
	 * @return Event
	 */
	public function setClosedAt($closedAt)
	{
		$this->closedAt = $closedAt;

		return $this;
	}

	/**
	 * Get closedAt
	 *
	 * @return \DateTime
	 */
	public function getClosedAt()
	{
		return $this->closedAt;
	}

	/**
	 * @return mixed
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * @param mixed $image
	 */
	public function setImage( $image ) {
		$this->image = $image;
	}

	public function __toString() {
		return $this->getName();
	}

}

