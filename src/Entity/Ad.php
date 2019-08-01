<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdRepository")
 */
class Ad
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="integer")
     */
    private $mileage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fuel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gearbox;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $options = null; 

    /**
     * @ORM\Column(type="integer")
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $prime_conversion;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Viewer", cascade={"persist"})
     */
    private $viewer_id = null;

    public function __construct()
    {
        $date = new \DateTime();
        $now = $date->getTimestamp();

        $this->created_at = $now;
        $this->viewer_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->name);
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, '', ' ');
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function getUnserializedImages(): ?array
    {
        return unserialize($this->images);
    }

    public function setImages(string $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getOptions(): ?string
    {
        return $this->options;
    }

    public function setOptions(string $options = null): self
    {
        $this->options = $options;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function getFormattedMileage()
    {
        return number_format($this->mileage, 0, '', ' ');
    }

    public function setMileage(int $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getGearbox(): ?string
    {
        return $this->gearbox;
    }

    public function setGearbox(string $gearbox): self
    {
        $this->gearbox = $gearbox;

        return $this;
    }

    public function getCreatedAt(): ?int
    {
        return $this->created_at;
    }

    public function setCreatedAt(int $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPrimeConversion(): ?bool
    {
        return $this->prime_conversion;
    }

    public function setPrimeConversion(bool $prime_conversion): self
    {
        $this->prime_conversion = $prime_conversion;

        return $this;
    }

    /**
     * @return Collection|Viewer[]|null
     */
    public function getViewerId(): ?Collection
    {
        return $this->viewer_id;
    }

    public function addViewerId(Viewer $viewerId): self
    {
        if (!$this->viewer_id->contains($viewerId)) {
            $this->viewer_id[] = $viewerId;
        }

        return $this;
    }

    public function removeViewerId(Viewer $viewerId): self
    {
        if ($this->viewer_id->contains($viewerId)) {
            $this->viewer_id->removeElement($viewerId);
        }

        return $this;
    }
    public function removeViewers($viewers): self
    {
        foreach($viewers as $viewer) {
            $this->removeViewerId($viewer);
        }
        return $this;
    }
    public function getNumberViews()
    {
        return $this->viewer_id->count();
    }
}
