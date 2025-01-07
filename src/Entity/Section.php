<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: "App\Repository\SectionRepository")]
#[ORM\Table(name: "section")]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "section_id", type: "integer")]
    private ?int $sectionId = null;

    #[ORM\Column(name: "section_title", type: "string", length: 255, nullable: true)]
    private ?string $sectionTitle = null;

    #[ORM\Column(name: "section_link", type: "string", length: 255, nullable: true)]
    private ?string $sectionLink = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $sectionLinkTitle = null;

    #[ORM\Column(name: "section_sub_title", type: "string", length: 255, nullable: true)]
    private ?string $sectionSubTitle = null;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Page")]
    #[ORM\JoinColumn(name: "page_id", referencedColumnName: "page_id", nullable: true)]
    private ?Page $page = null;

    #[ORM\Column(name: "section_description", type: "text", length: 65535, nullable: true)]
    private ?string $sectionDescription = null;

    #[ORM\Column(name: "section_order", type: "integer", nullable: true)]
    private ?int $sectionOrder = null;

    #[ORM\Column(name: "section_type", type: "integer", nullable: true)]
    private ?int $sectionType = null;

    #[ORM\OrderBy(["assetOrder" => "ASC"])]
    #[ORM\ManyToMany(targetEntity: "App\Entity\Asset", cascade: ["persist"])]
    #[ORM\JoinTable(name: "section_has_asset",
        joinColumns: [new ORM\JoinColumn(name: "section_id", referencedColumnName: "section_id", onDelete: "cascade")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "asset_id", referencedColumnName: "asset_id", onDelete: "cascade")]
    )]
    private Collection $assets;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Asset", cascade: ["persist"])]
    #[ORM\JoinColumn(name: "asset_id", referencedColumnName: "asset_id", nullable: true)]
    private ?Asset $mainAsset = null;

    #[Assert\File(maxSize: "6000000000000")]
    private $assetFile;

    private bool $removeAsset = false;

    public function __construct()
    {
        $this->assets = new ArrayCollection();
    }

    public function getSectionId(): ?int
    {
        return $this->sectionId;
    }

    public function setSectionId(?int $sectionId): void
    {
        $this->sectionId = $sectionId;
    }

    public function getSectionTitle(): ?string
    {
        return $this->sectionTitle;
    }

    public function setSectionTitle(?string $sectionTitle): void
    {
        $this->sectionTitle = $sectionTitle;
    }

    public function getSectionLink(): ?string
    {
        return $this->sectionLink;
    }

    public function setSectionLink(?string $sectionLink): void
    {
        $this->sectionLink = $sectionLink;
    }

    public function getSectionLinkTitle(): ?string
    {
        return $this->sectionLinkTitle;
    }

    public function setSectionLinkTitle(?string $sectionLinkTitle): void
    {
        $this->sectionLinkTitle = $sectionLinkTitle;
    }

    public function getSectionSubTitle(): ?string
    {
        return $this->sectionSubTitle;
    }

    public function setSectionSubTitle(?string $sectionSubTitle): void
    {
        $this->sectionSubTitle = $sectionSubTitle;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): void
    {
        $this->page = $page;
    }

    public function getSectionDescription(): ?string
    {
        return $this->sectionDescription;
    }

    public function setSectionDescription(?string $sectionDescription): void
    {
        $this->sectionDescription = $sectionDescription;
    }

    public function getSectionOrder(): ?int
    {
        return $this->sectionOrder;
    }

    public function setSectionOrder(?int $sectionOrder): void
    {
        $this->sectionOrder = $sectionOrder;
    }

    public function getSectionType(): ?int
    {
        return $this->sectionType;
    }

    public function setSectionType(?int $sectionType): void
    {
        $this->sectionType = $sectionType;
    }

    public function getAssets(): Collection
    {
        return $this->assets;
    }

    public function setAssets(Collection $assets): void
    {
        $this->assets = $assets;
    }

    public function addAsset(Asset $asset): self
    {
        $this->assets->add($asset);
        return $this;
    }

    public function getMainAsset(): ?Asset
    {
        return $this->mainAsset;
    }

    public function setMainAsset(?Asset $mainAsset): void
    {
        $this->mainAsset = $mainAsset;
    }

    public function getAssetFile()
    {
        return $this->assetFile;
    }

    public function setAssetFile($assetFile): void
    {
        $this->assetFile = $assetFile;
    }

    public function getRemoveAsset(): bool
    {
        return $this->removeAsset;
    }

    public function setRemoveAsset(bool $removeAsset): void
    {
        $this->removeAsset = $removeAsset;
    }

    public function __clone()
    {
        if ($this->sectionId) {
            $this->sectionId = null;
            $assets = new ArrayCollection();
            foreach ($this->assets as $asset) {
                $assets->add(clone $asset);
            }
            $this->assets = $assets;
        }
    }
}
