<?php

namespace Bitapp\ParkingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bitapp\ParkingBundle\Entity\Placemark;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
    /**
     * @Route("/create")
     */
    public function createAction(){
    	
    	$kml_url = "http://sosta.atc.bo.it/kml/parcometri_attivi.txt";
    	$kml = simplexml_load_file($kml_url);
    	
    	$em = $this->getDoctrine()->getManager();
    	
    	foreach ($kml->xpath('//Placemark') as $kk){
    		list($lng, $lat, $h) = explode(',',$kk->Point->coordinates);
    		$placemark = new Placemark();
    		$placemark->setName($kk->name);
    		$placemark->setDescr($kk->description);
    		$placemark->setLat($lat);
    		$placemark->setLng($lng);
    		$placemark->setH($h);
    		$em->persist($placemark);
    	}
    	$em->flush();
    	return new Response("Parchimetri sincronizzati");
    }
}
