<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dt_creation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img_avatar = null;

    /**
     * @var Collection<int, Subreddit>
     */
    #[ORM\OneToMany(targetEntity: Subreddit::class, mappedBy: 'user')]
    private Collection $subreddits;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $comments;

    /**
     * @var Collection<int, Subreddit>
     */
    #[ORM\ManyToMany(targetEntity: Subreddit::class, mappedBy: 'moderator')]
    private Collection $subredditsMod;

    /**
     * @var Collection<int, Thread>
     */
    #[ORM\OneToMany(targetEntity: Thread::class, mappedBy: 'originalPoster')]
    private Collection $threads;

    public function __construct()
    {
        $this->subreddits = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->subredditsMod = new ArrayCollection();
        $this->threads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

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

    public function getImgAvatar(): ?string
    {
        return $this->img_avatar;
    }

    public function setImgAvatar(?string $img_avatar): static
    {
        $this->img_avatar = $img_avatar;

        return $this;
    }

    /**
     * @return Collection<int, Subreddit>
     */
    public function getSubreddits(): Collection
    {
        return $this->subreddits;
    }

    public function addSubreddit(Subreddit $subreddit): static
    {
        if (!$this->subreddits->contains($subreddit)) {
            $this->subreddits->add($subreddit);
            $subreddit->setUser($this);
        }

        return $this;
    }

    public function removeSubreddit(Subreddit $subreddit): static
    {
        if ($this->subreddits->removeElement($subreddit)) {
            // set the owning side to null (unless already changed)
            if ($subreddit->getUser() === $this) {
                $subreddit->setUser(null);
            }
        }

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
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Subreddit>
     */
    public function getSubredditsMod(): Collection
    {
        return $this->subredditsMod;
    }

    public function addSubredditsMod(Subreddit $subredditsMod): static
    {
        if (!$this->subredditsMod->contains($subredditsMod)) {
            $this->subredditsMod->add($subredditsMod);
            $subredditsMod->addModerator($this);
        }

        return $this;
    }

    public function removeSubredditsMod(Subreddit $subredditsMod): static
    {
        if ($this->subredditsMod->removeElement($subredditsMod)) {
            $subredditsMod->removeModerator($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Thread>
     */
    public function getThreads(): Collection
    {
        return $this->threads;
    }

    public function addThread(Thread $thread): static
    {
        if (!$this->threads->contains($thread)) {
            $this->threads->add($thread);
            $thread->setOriginalPoster($this);
        }

        return $this;
    }

    public function removeThread(Thread $thread): static
    {
        if ($this->threads->removeElement($thread)) {
            // set the owning side to null (unless already changed)
            if ($thread->getOriginalPoster() === $this) {
                $thread->setOriginalPoster(null);
            }
        }

        return $this;
    }
}
