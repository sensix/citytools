<?php

namespace Bitapp\ParkingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bitapp\ParkingBundle\Entity\Placemark;
use Doctrine\ORM\Query\ResultSetMapping;

class ParkingController extends Controller
{
    /**
     * Fetch all placemarks
     * @Route("/parking/placemarks.json")
     */
		public function allAction(){
			$placemarks = $this->getDoctrine()
				->getRepository('BitappParkingBundle:Placemark')
				->findAll();
			return new Response(json_encode($this->toArray($placemarks)));
		}
		/**
		 * Fetch point near to center point
		 * @Route("/parking/{point}/placemarks.json")
		 */
		public function nearestAction($point){
			list($lat, $lng) = explode(',', $point);
			define('PI',3.1415927);
			$math = "(acos(sin(".PI." * p.lat / 180)*sin(".PI." * :lat / 180)+cos(".PI." * p.lat / 180)*cos(".PI." * :lat / 180)*cos(abs(".PI." * :lng / 180 - ".PI." * p.lng / 180)))*6371)";
			$sql = "SELECT p.placemarkID,p.name,p.lat,p.lng, $math * 1000 as distance FROM Placemark p 
					WHERE $math < :distance
					ORDER BY distance ASC
					LIMIT 0,10";
			
			$em = $this->getDoctrine()->getConnection();
			$stmt = $em->prepare($sql);
			$stmt->bindValue('lat', $lat);
			$stmt->bindValue('lng', $lng);
			$stmt->bindValue('distance', 50);
			$stmt->execute();
			$items = $stmt->fetchAll();
			return new Response(json_encode($items));
		}
		/**
     * @Route("/parking/sync")
     */
    public function syncAction(){
    	
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
    
    
    private function toArray($placemarks){
    	$items = array();
    	foreach($placemarks as $obj){
    		$item['placemarkID'] = $obj->getPlacemarkID();
    		$item['name'] = $obj->getName();
    		$item['descr'] = $obj->getDescr();
    		$item['lat'] = $obj->getLat();
    		$item['lng'] = $obj->getLng();
    		$item['h'] = $obj->getH();
    		$items[] = $item;
    	}
    	return $items;
    }
}
