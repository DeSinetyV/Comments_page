<?php

namespace App\Entity;

use App\Repository\PhotosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotosRepository::class)
 */
class Photos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=commentaires::class, inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commentaireId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaireId(): ?commentaires
    {
        return $this->commentaireId;
    }

    public function setCommentaireId(?commentaires $commentaireId): self
    {
        $this->commentaireId = $commentaireId;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
