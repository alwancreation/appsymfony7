<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Table(name: 'asset')]
#[ORM\Entity]
class Asset
{

    #[
        ORM\Id,
        ORM\GeneratedValue(strategy: 'IDENTITY')
    ]
    #[ORM\Column(name: 'asset_id', type: 'integer')]
    private $assetId;


    #[ORM\Column(name: 'asset_is_main', type: 'boolean', nullable: true)]
    private $assetIsMain;

    #[ORM\Column(name: 'asset_base_path', type: 'string', length: 255, nullable: true)]
    private $assetBasePath;

    #[ORM\Column(name: 'asset_title', type: 'string', length: 255, nullable: true)]
    private $assetTitle;
    #[ORM\Column(name: 'asset_alt', type: 'string', length: 255, nullable: true)]
    private $assetAlt;

    #[ORM\Column(name: 'asset_order', type: 'integer', nullable: true)]
    private $assetOrder;

    #[ORM\Column(name: 'asset_link', type: 'string', length: 255, nullable: true)]
    private $assetLink;

    #[ORM\Column(name: 'asset_icon', type: 'string', length: 255, nullable: true)]
    private $assetIcon;

    #[ORM\Column(name: 'asset_link_title', type: 'string', length: 255, nullable: true)]
    private $assetLinkTitle;

    #[ORM\Column(name: 'asset_description', type: 'text', nullable: true)]
    private $assetDescription;

    /**
     * @var boolean
     */
    public $removeFile;

    #[ORM\Column(name: 'asset_type', type: 'integer', nullable: true)]
    private $assetType;



    /**
     * @return string
     */
    public function getAssetTitle()
    {
        return $this->assetTitle;
    }

    /**
     * @param string $assetTitle
     */
    public function setAssetTitle($assetTitle)
    {
        $this->assetTitle = $assetTitle;
    }

    /**
     * @return string
     */
    public function getAssetAlt()
    {
        return $this->assetAlt;
    }

    /**
     * @param string $assetAlt
     */
    public function setAssetAlt($assetAlt)
    {
        $this->assetAlt = $assetAlt;
    }

    /**
     * @return string
     */
    public function getAssetLink()
    {
        return $this->assetLink;
    }

    /**
     * @param string $assetLink
     */
    public function setAssetLink($assetLink)
    {
        $this->assetLink = $assetLink;
    }

    /**
     * @return string
     */
    public function getAssetLinkTitle()
    {
        return $this->assetLinkTitle;
    }

    /**
     * @param string $assetLinkTitle
     */
    public function setAssetLinkTitle($assetLinkTitle)
    {
        $this->assetLinkTitle = $assetLinkTitle;
    }

    /**
     * @return string
     */
    public function getAssetDescription()
    {
        return $this->assetDescription;
    }

    /**
     * @param string $assetDescription
     */
    public function setAssetDescription($assetDescription)
    {
        $this->assetDescription = $assetDescription;
    }




    /**
     * Get assetId
     *
     * @return integer
     */
    public function getAssetId()
    {
        return $this->assetId;
    }

    /**
     * Set assetIsMain
     *
     * @param boolean $assetIsMain
     *
     * @return Asset
     */
    public function setAssetIsMain($assetIsMain)
    {
        $this->assetIsMain = $assetIsMain;

        return $this;
    }

    /**
     * Get assetIsMain
     *
     * @return boolean
     */
    public function getAssetIsMain()
    {
        return $this->assetIsMain;
    }

    /**
     * Set assetBasePath
     *
     * @param string $assetBasePath
     *
     * @return Asset
     */
    public function setAssetBasePath($assetBasePath)
    {
        $this->assetBasePath = $assetBasePath;

        return $this;
    }

    /**
     * Get assetBasePath
     *
     * @return string
     */
    public function getAssetBasePath()
    {
        return $this->assetBasePath;
    }

    /**
     * Set assetType
     *
     * @param integer $assetType
     *
     * @return Asset
     */
    public function setAssetType($assetType)
    {
        $this->assetType = $assetType;

        return $this;
    }

    /**
     * Get assetType
     *
     * @return integer
     */
    public function getAssetType()
    {
        return $this->assetType;
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
     * @return int
     */
    public function getAssetOrder(): ?int
    {
        return $this->assetOrder;
    }

    /**
     * @param int $assetOrder
     */
    public function setAssetOrder(?int $assetOrder): void
    {
        $this->assetOrder = $assetOrder;
    }

    /**
     * @return string
     */
    public function getAssetIcon(): ?string
    {
        return $this->assetIcon;
    }

    /**
     * @param string $assetIcon
     */
    public function setAssetIcon(?string $assetIcon): void
    {
        $this->assetIcon = $assetIcon;
    }

    public function __clone()
    {
        if ($this->assetId) {
            $this->assetId = null;
        }
    }
}
