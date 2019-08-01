<?php
namespace App\Entity;

class AdSearch
{
    /**
     * @var string
     */
    private $global;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $fuel;

    /**
     * @var string
     */
    private $gearbox;

    /**
     * @var string
     */
    private $sort;


    public function countBrands($repository) {
        $ads = $repository->findAll();
        $brands = [];
        foreach($ads as $ad) {
            if(array_key_exists($ad->getBrand(), $brands))
            {
                $brands[$ad->getBrand()]++;
            } else {
                $brands[$ad->getBrand()] = 1;
            }
        }
        return $brands;
    }


    /**
     * @return  string
     */ 
    public function getGlobal(): ?string
    {
        return $this->global;
    }

    /**
     * @param  string  $global
     * @return  self
     */ 
    public function setGlobal(string $global)
    {
        $this->global = $global;

        return $this;
    }

    /**
     * @return  string
     */ 
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param  string  $brand
     * @return  self
     */ 
    public function setBrand(string $brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return  string
     */ 
    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    /**
     * @param  string  $fuel
     * @return  self
     */ 
    public function setFuel(string $fuel)
    {
        $this->fuel = $fuel;

        return $this;
    }

    /**
     * @return  string
     */ 
    public function getGearbox(): ?string
    {
        return $this->gearbox;
    }

    /**
     * @param  string  $gearbox
     * @return  self
     */ 
    public function setGearbox(string $gearbox)
    {
        $this->gearbox = $gearbox;

        return $this;
    }

    /**
     * @return  string
     */ 
    public function getSort(): ?string
    {
        return $this->sort;
    }

    /**
     * @param  string  $sort
     * @return  self
     */ 
    public function setSort(string $sort)
    {
        $this->sort = $sort;

        return $this;
    }
}