<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="event_selector")
	 */
	public function indexAction(Request $request)
	{

		$em = $this->get( 'doctrine' )->getManager();

		/** @var Event[] $events */
		$events = $em->getRepository( 'AppBundle:Event' )->findOpenEvents();

		return $this->render('default/selector.html.twig', array("events" => $events));
	}

	/**
	 * @Route("/dashboard/{eventId}", name="dashboard")
	 * @param Request $request
	 */
	public function dashboardAction(Request $request, $eventId){

		$em = $this->get( 'doctrine' )->getManager();
		/** @var Event $event */
		$event = $em->getRepository( 'AppBundle:Event' )->findOneById($eventId);

		return $this->render('default/dashboard.html.twig', array("event" => $event));
	}

	/**
	 * @Route("/dashboard/{eventId}/data/{obtainedAt}", name="data")
	 * @param Request $request
	 */
	public function dataAction(Request $request, $eventId, $obtainedAt){

		$em = $this->get( 'doctrine' )->getManager();
		$infos = $em->getRepository( 'AppBundle:Information' )->findInformation( $eventId, $obtainedAt );

		$context = SerializationContext::create()->setGroups(array('data'));
		$serializer = $this->get('jms_serializer');
		return new Response($serializer->serialize($infos, "json", $context));
	}

	/**
	 * @Route("/dashboard/{eventId}/data/information/{id}", name="information")
	 * @param Request $request
	 */
	public function infoAction(Request $request, $id){
		$em = $this->get( 'doctrine' )->getManager();
		$infos = $em->getRepository( 'AppBundle:Information' )->findOneById( $id );

		$context = SerializationContext::create()->setGroups(array('data'));
		$serializer = $this->get('jms_serializer');
		return new Response($serializer->serialize($infos, "json", $context));
	}

	/**
	 * @Route("/dashboard/{eventId}/data/search/{query}", name="search_information")
	 * @param Request $request
	 */
	public function searchAction(Request $request, $query){
		$em = $this->get( 'doctrine' )->getManager();
		$infos = $em->getRepository( 'AppBundle:Information' )->searchInformation( $query, 5 );

		$context = SerializationContext::create()->setGroups(array('data'));
		$serializer = $this->get('jms_serializer');
		return new Response($serializer->serialize($infos, "json", $context));
	}

	/**
	 * @Route("/dashboard/{eventId}/bulo/{obtainedAt}", name="bulo")
	 * @param Request $request
	 */
	public function buloAction(Request $request, $eventId, $obtainedAt){
		$em = $this->get( 'doctrine' )->getManager();
		$bulos = $em->getRepository( 'AppBundle:Misinformation' )->getBulos( $eventId, $obtainedAt );

		$context = SerializationContext::create()->setGroups(array('data'));
		$serializer = $this->get('jms_serializer');
		return new Response($serializer->serialize($bulos, "json", $context));
	}

}
