<?php

namespace App\Entity;

use Absmoca\Leboncoin as Lbc;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\AdRepository;
use App\Repository\ArticleRepository;
use App\Repository\ViewerRepository;
use Symfony\Component\DependencyInjection\LazyProxy\PhpDumper\NullDumper;

class Leboncoin
{

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em) 
    {
        $this->em = $em;
    }

    public function getAds(AdRepository $repository, int $adsUpdated = 0): array
    {
        $ads = $this->getParams();

        foreach ($ads['annonces'] as $ad) {
            if($this->verificationAccount($ad)):

            $attributes = $this->getOptions($ad);

            if(isset($attributes['mileage'])):
            $mileage = substr($attributes['mileage'], 0, -3);   // DELETE ' km' FROM DEFAULT MILEAGE
            endif;

            $prime_conversion = false;
            if(strpos($ad->getDescription(), 'prime à la conversion')) {
                $prime_conversion = true;
            }

            $adEntity = new Ad();
            $adEntity->setName($ad->getName())
                     ->setId($ad->getId())
                     ->setDate($ad->getDate())
                     ->setDescription($ad->getDescription())
                     ->setUrl($ad->getUrl())
                     ->setPrice($ad->getPrice())
                     ->setImages(serialize($ad->getImages()))
                     ->setBrand($attributes['brand'] ?? 'Non renseignée')
                     ->setModel($attributes['model'] ?? 'Non renseignée')
                     ->setYear($attributes['regdate'] ?? 'Non renseignée')
                     ->setMileage($mileage ?? 'Non renseignée')
                     ->setFuel($attributes['fuel'] ?? 'Non renseignée')
                     ->setGearbox($attributes['gearbox'] ?? 'Non renseignée')
                     ->setPrimeConversion($prime_conversion)
                     ;
                    
                $this->em->merge($adEntity);
                $adsUpdated++;
            endif;
        }

        $this->em->flush();

        $adsRemoved = $this->removeAds($repository);

        return [$adsUpdated, $adsRemoved];
    }

    public function getArticles(ArticleRepository $repository, ViewerRepository $viewerRepository, int $articlesUpdated = 0): array
    {
        $articles = $this->getParams(31);
        $articlesJob = $this->getParams(71);

        foreach ($articles['annonces'] as $article){
            if($this->verificationAccount($article)):
                $this->mergeArticle($article);
                $articlesUpdated++;
            endif;
        }
        foreach ($articlesJob['annonces'] as $articleJob){
            if($this->verificationAccount($articleJob)):
                $this->mergeArticle($articleJob);
                $articlesUpdated++;
            endif;
        }
        $this->em->flush();

        $articlesRemoved = $this->removeAds($repository);

        return [$articlesUpdated, $articlesRemoved];
    }

    private function mergeArticle($article) {
        $articleEntity = new Article();

        $articleEntity->setId($article->getId())
        ->setName($article->getName())
        ->setDate($article->getDate())
        ->setDescription($article->getDescription())
        ->setUrl($article->getUrl())
        ->setImages(serialize($article->getImages()));

        return $this->em->merge($articleEntity);
    }

    private function verificationAccount($ad) : bool 
    {
        $id = $ad->getOwner()["name"];
        if($id === 'AUTO CLEAN') {
            return true;
        }
        return false;
    }

    private function getOptions($ad):array 
    {
        foreach($ad->getAttributes() as $a) {
            $attributes[$a->key] = $a->value_label;
        }

        return $attributes;
    }

    private function removeAds($repository, int $adsRemoved = 0)
    {  
        $ads = $repository->findAllByInterval();
        if($ads == 0){
            exit;
        }
        foreach ($ads as $ad) {
            $this->em->remove($ad);
            $ad->removeViewers($ad->getViewerId());
            $this->em->persist($ad);
            $adsRemoved++;
        }
        $this->em->flush();

        return $adsRemoved;
    }

    private function getParams(int $category = 2): array 
    {
        $lbc = new Lbc();
        $params = array(
            "query" => "auto clean",
            "title_only" => false,
            "category" => $category,
            "location" => [
                'regions' => [17,]
            ],
            "professionnels" => true
        );
        return $lbc->getAnnonces($params);
    }
}