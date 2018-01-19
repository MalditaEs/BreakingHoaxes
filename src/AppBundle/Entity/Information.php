<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use JMS\Serializer\Annotation as Serializer;

/**
 * Information
 *
 * @ORM\Table(name="information", indexes={@Index(columns={"title", "content"}, flags={"fulltext"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InformationRepository")
 */
class Information
{
	/**
	 * @var int
	 *
	 * @Serializer\Groups({"data"})
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @Serializer\Groups({"data"})
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $title;

	/**
	 * @Serializer\Groups({"data"})
	 * @var Source
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Source", inversedBy="informations", fetch="EAGER")
	 * @ORM\JoinColumn(name="source_id", referencedColumnName="id")
	 */
	private $source;

	/**
	 * @var \DateTime
	 * @Serializer\Groups({"data"})
	 * @ORM\Column(name="obtainedAt", type="datetime")
	 */
	private $obtainedAt;

	/**
	 * @var string
	 * @Serializer\Groups({"data"})
	 * @ORM\Column(name="originalUrl", type="string", length=255, nullable=true)
	 */
	private $originalUrl;

	/**
	 * @var string
	 * @Serializer\Groups({"data"})
	 * @ORM\Column(name="content", type="text")
	 */
	private $content;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Event", inversedBy="informations")
	 * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
	 */
	private $event;

	/**
	 * @return mixed
	 */
	public function getEvent() {
		return $this->event;
	}

	/**
	 * @param mixed $event
	 */
	public function setEvent( $event ) {
		$this->event = $event;
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
	 * Set source
	 *
	 * @param Source $source
	 *
	 * @return Information
	 */
	public function setSource($source)
	{
		$this->source = $source;

		return $this;
	}

	/**
	 * Get source
	 * @return Source
	 */
	public function getSource()
	{
		return $this->source;
	}

	/**
	 * Set obtainedAt
	 *
	 * @param \DateTime $obtainedAt
	 *
	 * @return Information
	 */
	public function setObtainedAt($obtainedAt)
	{
		$this->obtainedAt = $obtainedAt;

		return $this;
	}

	/**
	 * Get obtainedAt
	 *
	 * @return \DateTime
	 */
	public function getObtainedAt()
	{
		return $this->obtainedAt;
	}

	/**
	 * Set originalUrl
	 *
	 * @return Information
	 */
	public function setOriginalUrl($originalUrl)
	{
		$this->originalUrl = $originalUrl;

		return $this;
	}

	/**
	 * Get originalUrl
	 *
	 * @return string
	 */
	public function getOriginalUrl()
	{
		return $this->originalUrl;
	}

	/**
	 * Set content
	 *
	 * @param string $content
	 *
	 * @return Information
	 */
	public function setContent($content)
	{
		$this->content = $content;

		return $this;
	}

	/**
	 * Get content
	 *
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @return mixed
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle( $title ) {
		$this->title = $title;
	}

	public function __toString() {
		return "";
	}

}

