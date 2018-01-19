<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Source
 *
 * @ORM\Table(name="source")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SourceRepository")
 */
class Source {
	/**
	 * @var int
	 *
	 * @Serializer\Groups({"data"})
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @Serializer\Groups({"data"})
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
	 * @var string
	 * @Serializer\Groups({"data"})
	 * @ORM\Column(name="image", type="string", length=255)
	 */
	private $image;

	/**
	 * @Serializer\Groups({"data"})
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SourceTypes", inversedBy="sources")
	 * @ORM\JoinColumn(name="sourcetype_id", referencedColumnName="id")
	 */
	private $type;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Credibility", inversedBy="sources")
	 * @ORM\JoinColumn(name="credibility_id", referencedColumnName="id")
	 */
	private $credibility;

	/**
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Event", mappedBy="sources")
	 */
	private $event;

	/**
	 * @Serializer\Exclude()
	 * @var array
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Information", mappedBy="source")
	 */
	private $informations;

	/**
	 * Source constructor.
	 *
	 * @param array $informations
	 */
	public function __construct() {
		$this->informations = new ArrayCollection();
		$this->event        = new ArrayCollection();
	}

	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Source
	 */
	public function setName( $name ) {
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Set image
	 *
	 * @param string $image
	 *
	 * @return Source
	 */
	public function setImage( $image ) {
		$this->image = $image;

		return $this;
	}

	/**
	 * Get image
	 *
	 * @return string
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Set type
	 *
	 * @param \stdClass $type
	 *
	 * @return Source
	 */
	public function setType( $type ) {
		$this->type = $type;

		return $this;
	}

	/**
	 * Get type
	 *
	 * @return \stdClass
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Set credibility
	 *
	 * @param \stdClass $credibility
	 *
	 * @return Source
	 */
	public function setCredibility( $credibility ) {
		$this->credibility = $credibility;

		return $this;
	}

	/**
	 * Get credibility
	 *
	 * @return \stdClass
	 */
	public function getCredibility() {
		return $this->credibility;
	}

	/**
	 * Set event
	 *
	 * @param \stdClass $event
	 *
	 * @return Source
	 */
	public function setEvent( $event ) {
		$this->event = $event;

		return $this;
	}

	/**
	 * Get event
	 *
	 * @return \stdClass
	 */
	public function getEvent() {
		return $this->event;
	}

	/**
	 * @return array
	 */
	public function getInformations() {
		return $this->informations;
	}

	/**
	 * @param array $informations
	 */
	public function setInformations( $informations ) {
		$this->informations = $informations;
	}

	public function __toString() {
		return $this->getName();
	}


}

