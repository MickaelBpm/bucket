<?php

namespace App\Entity;

use App\Repository\WishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: WishRepository::class)]
class Wish
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Un titre est obligatoire")]
    #[Assert\Length(
        min: 1,
        max: 255,
        minMessage: "Minimum {{ value }} character",
        maxMessage: "Maximum {{ value }} characters"
    )]
    #[ORM\Column(length: 250)]
    private ?string $title = null;

    #[Assert\NotBlank(message: "Un message est obligatoire")]
    #[Assert\Length(
        min: 10,
        max: 4000,
        minMessage: "Minimum {{ limit }} caractères",
        maxMessage: "Maximum {{ limit }} caractères"
    )]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Assert\NotBlank(message: "Un auteur est obligatoire")]
    #[Assert\Length(
        min: 1,
        max: 255,
        minMessage: "Minimum {{ value }} character",
        maxMessage: "Maximum {{ value }} characters"
    )]
    #[ORM\Column(length: 50)]
    private ?string $author = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isPublished = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreated = null;

    #[ORM\ManyToOne(inversedBy: 'wishes')]
    private ?Category $categorys = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(?bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(?\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }


    #[ORM\PrePersist()]
    public function setNewWish(){
        $this->setDateCreated(new \DateTime());
        $this->setIsPublished(true);
    }

    public function getCategorys(): ?Category
    {
        return $this->categorys;
    }

    public function setCategorys(?Category $categorys): self
    {
        $this->categorys = $categorys;

        return $this;
    }

}
