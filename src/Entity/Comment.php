<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Movie::class, inversedBy: 'comments')]
    private ?Movie $movie = null;

    #[ORM\ManyToOne(targetEntity: Author::class, inversedBy: 'comments')]
    private ?Author $author = null;

    #[ORM\ManyToOne(targetEntity: Comment::class, inversedBy: 'answers')]
    private ?Comment $parent = null;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Comment::class)]
    private Collection $answers;

    #[ORM\Column]
    private \DateTime $createdAt;

    #[ORM\Column]
    private int $likes;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->likes = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): void
    {
        $this->movie = $movie;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): void
    {
        $this->author = $author;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }

    public function getParent(): ?Comment
    {
        return $this->parent;
    }

    public function setParent(?Comment $parent): void
    {
        $this->parent = $parent;
    }

    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function setAnswers(Collection $answers): void
    {
        $this->answers = $answers;
    }
}