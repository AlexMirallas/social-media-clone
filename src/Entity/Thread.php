<?php

namespace App\Entity;

use App\Repository\ThreadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThreadRepository::class)]
class Thread
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dt_creation = null;

    #[ORM\ManyToOne(inversedBy: 'threads')]
    private ?Subreddit $subreddit = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'thread', orphanRemoval: true)]
    private Collection $comments;

    #[ORM\ManyToOne(inversedBy: 'threads')]
    private ?User $originalPoster = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $body = null;

    #[ORM\Column(nullable: true)]
    private ?int $upvotes = null;

    #[ORM\Column(nullable: true)]
    private ?int $downvotes = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getDtCreation(): ?\DateTimeInterface
    {
        return $this->dt_creation;
    }

    public function setDtCreation(\DateTimeInterface $dt_creation): static
    {
        $this->dt_creation = $dt_creation;

        return $this;
    }

    public function getSubreddit(): ?Subreddit
    {
        return $this->subreddit;
    }

    public function setSubreddit(?Subreddit $subreddit): static
    {
        $this->subreddit = $subreddit;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setThread($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getThread() === $this) {
                $comment->setThread(null);
            }
        }

        return $this;
    }

    public function getOriginalPoster(): ?User
    {
        return $this->originalPoster;
    }

    public function setOriginalPoster(?User $originalPoster): static
    {
        $this->originalPoster = $originalPoster;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getUpvotes(): ?int
    {
        return $this->upvotes;
    }

    public function setUpvotes(?int $upvotes): static
    {
        $this->upvotes = $upvotes;

        return $this;
    }

    public function getDownvotes(): ?int
    {
        return $this->downvotes;
    }

    public function setDownvotes(?int $downvotes): static
    {
        $this->downvotes = $downvotes;

        return $this;
    }
}
