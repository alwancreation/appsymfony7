<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'page')]

class Page
{

    #[
        ORM\Id,
        ORM\GeneratedValue(strategy: 'IDENTITY')
    ]
    #[ORM\Column(name: 'page_id', type: 'integer')]
    private $pageId;

    #[ORM\Column(name: 'page_name', type: 'string', length: 255, nullable: true)]
    private $pageName;

    #[ORM\Column(name: 'page_title', type: 'string', length: 255, nullable: true)]
    private $pageTitle;

    #[ORM\Column(name: 'page_url', type: 'string', length: 255, nullable: true)]
    private $pageUrl;

    #[ORM\Column(name: 'page_sub_title', type: 'string', length: 255, nullable: true)]
    private $pageSubTitle;

    #[ORM\Column(name: 'page_long_description', type: 'text', nullable: true)]
    private $pageLongDescription;
    #[ORM\Column(name: 'page_short_description', type: 'text', nullable: true)]
    private $pageShortDescription;

    /**
     * @return string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    #[ORM\ManyToOne(targetEntity: Meta::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'meta_id', referencedColumnName: 'meta_id')]
    private ?Meta $meta = null;



    #[ORM\OneToMany(targetEntity: Section::class, mappedBy: 'page')]
    #[ORM\OrderBy(['sectionOrder' => 'ASC'])]
    private $sections;

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $sections
     */
    public function setSections($sections)
    {
        $this->sections = $sections;
    }



    /**
     * @return Meta
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param Meta $meta
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
    }



    /**
     * @return string
     */
    public function getPageSubTitle()
    {
        return $this->pageSubTitle;
    }

    /**
     * @param string $pageSubTitle
     */
    public function setPageSubTitle($pageSubTitle)
    {
        $this->pageSubTitle = $pageSubTitle;
    }


    /**
     * @param string $pageTitle
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;
    }

    /**
     * @return string
     */
    public function getPageLongDescription()
    {
        return $this->pageLongDescription;
    }

    /**
     * @param string $pageLongDescription
     */
    public function setPageLongDescription($pageLongDescription)
    {
        $this->pageLongDescription = $pageLongDescription;
    }

    /**
     * @return string
     */
    public function getPageShortDescription()
    {
        return $this->pageShortDescription;
    }

    /**
     * @param string $pageShortDescription
     */
    public function setPageShortDescription($pageShortDescription)
    {
        $this->pageShortDescription = $pageShortDescription;
    }


    /**
     * @Assert\File(maxSize="6000000000000")
     */
    private $assetFile;

    /**
     * @return mixed
     */
    public function getAssetFile()
    {
        return $this->assetFile;
    }

    /**
     * @param mixed $assetFile
     */
    public function setAssetFile($assetFile)
    {
        $this->assetFile = $assetFile;
    }


    /**
     * @var \App\Entity\Asset
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Asset" , cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asset_id", referencedColumnName="asset_id")
     * })
     */
    private $asset;

    /**
     * @return int
     */
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * @param int $pageId
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;
    }

    /**
     * @return string
     */
    public function getPageName()
    {
        return $this->pageName;
    }

    /**
     * @param string $pageName
     */
    public function setPageName($pageName)
    {
        $this->pageName = $pageName;
    }

    /**
     * @return Asset
     */
    public function getAsset()
    {
        return $this->asset;
    }

    /**
     * @param Asset $asset
     */
    public function setAsset($asset)
    {
        $this->asset = $asset;
    }

    /**
     * @return string
     */
    public function getPageUrl(): ?string
    {
        return $this->pageUrl;
    }

    /**
     * @param string $pageUrl
     */
    public function setPageUrl(?string $pageUrl): void
    {
        $this->pageUrl = $pageUrl;
    }

    function __toString()
    {
        return $this->pageName;
    }
}
