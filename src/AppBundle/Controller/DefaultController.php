<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

}
