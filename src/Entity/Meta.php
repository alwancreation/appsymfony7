<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

#[ORM\Entity]
#[ORM\Table(name: 'meta')]
class Meta
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'meta_id', type: 'integer')]
    private $metaId;

    #[ORM\Column(name: 'meta_title', type: 'string', length: 255, nullable: true)]
    private $metaTitle;





    #[ORM\Column(name: 'meta_description', type: 'text', nullable: true)]
    private $metaDescription;

    #[ORM\Column(name: 'meta_keywords', type: 'text', nullable: true)]
    private $metaKeywords;

    #[ORM\Column(name: 'meta_plus', type: 'text', nullable: true)]
    private $metaPlus;

    /**
     * @return int
     */
    public function getMetaId()
    {
        return $this->metaId;
    }

    /**
     * @param int $metaId
     */
    public function setMetaId($metaId)
    {
        $this->metaId = $metaId;
    }

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * @param string $metaTitle
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param string $metaDescription
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * @param string $metaKeywords
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
    }

    /**
     * @return string
     */
    public function getMetaPlus()
    {
        return $this->metaPlus;
    }

    /**
     * @param string $metaPlus
     */
    public function setMetaPlus($metaPlus)
    {
        $this->metaPlus = $metaPlus;
    }


}
