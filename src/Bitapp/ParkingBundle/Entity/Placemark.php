<?php 
namespace Bitapp\ParkingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Placemark")
 *
 */
class Placemark{
	/**
	 * 
	 * @ORM\id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */	
	protected $placemarkID;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $name;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $descr;
	/**
	 * @ORM\Column(type="float", precision=9, scale=7)
	 */
	protected $lat;
	/**
	 * @ORM\Column(type="float", precision=9, scale=7)
	 */
	protected $lng;
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $h;
	 

    /**
     * Get placemarkID
     *
     * @return integer 
     */
    public function getPlacemarkID()
    {
        return $this->placemarkID;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Placemark
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
     * Set descr
     *
     * @param string $descr
     * @return Placemark
     */
    public function setDescr($descr)
    {
        $this->descr = $descr;
    
        return $this;
    }

    /**
     * Get descr
     *
     * @return string 
     */
    public function getDescr()
    {
        return $this->descr;
    }

    /**
     * Set lat
     *
     * @param float $lat
     * @return Placemark
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    
        return $this;
    }

    /**
     * Get lat
     *
     * @return float 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param float $lng
     * @return Placemark
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    
        return $this;
    }

    /**
     * Get lng
     *
     * @return float 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set h
     *
     * @param integer $h
     * @return Placemark
     */
    public function setH($h)
    {
        $this->h = $h;
    
        return $this;
    }

    /**
     * Get h
     *
     * @return integer 
     */
    public function getH()
    {
        return $this->h;
    }
}