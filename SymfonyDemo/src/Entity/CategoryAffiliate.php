<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryAffiliateRepository")
 */
class CategoryAffiliate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Affiliate")
     * @ORM\JoinColumn(nullable=false)
     */
    private $affiliate_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryId(): ?Category
    {
        return $this->category_id;
    }

    public function setCategoryId(?Category $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getAffiliateId(): ?Affiliate
    {
        return $this->affiliate_id;
    }

    public function setAffiliateId(?Affiliate $affiliate_id): self
    {
        $this->affiliate_id = $affiliate_id;

        return $this;
    }
}
