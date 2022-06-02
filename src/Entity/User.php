<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *  @Table(name="user",
 *      uniqueConstraints={
 *          @UniqueConstraint(name="IDX_UNIQUE_USERNAME",
 *                  columns={"username"}
 *          )
 *      }
 * )
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull (message="El nom de l'usuari és obligatori")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    //TODO: Afegir una restricció en quant a noms d'usuari

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Tweet::class, mappedBy="user")
     */
    private $tweets;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="followers")
     */
    private $following;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="following")
     */
    private $followers;

    public function __construct()
    {
        $this->tweets = new ArrayCollection();
        $this->following = new ArrayCollection();
        $this->followers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Tweet>
     */
    public function getTweets(): Collection
    {
        return $this->tweets;
    }

    public function addTweet(Tweet $tweet): self
    {
        if (!$this->tweets->contains($tweet)) {
            $this->tweets[] = $tweet;
            $tweet->setUser($this);
        }

        return $this;
    }

    public function removeTweet(Tweet $tweet): self
    {
        if ($this->tweets->removeElement($tweet)) {
            // set the owning side to null (unless already changed)
            if ($tweet->getUser() === $this) {
                $tweet->setUser(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
       return $this->getName();
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return ["ROLE_USER"];
    }

    /**
     * @return string|null
     */
    public function getSalt():?string
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->getUsername();
    }

    /**
     * @return Collection<int, self>
     */
    public function getFollowing(): Collection
    {
        return $this->following;
    }

    public function addFollowing(self $following): self
    {
        if (!$this->following->contains($following) && $this->getUsername()!=$following->getUsername()) {
            $this->following[] = $following;
        }

        return $this;
    }

    public function removeFollowing(self $following): self
    {
        $this->following->removeElement($following);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(self $follower): self
    {
        if (!$this->followers->contains($follower)) {
            $this->followers[] = $follower;
            $follower->addFollowing($this);
        }

        return $this;
    }

    public function removeFollower(self $follower): self
    {
        if ($this->followers->removeElement($follower)) {
            $follower->removeFollowing($this);
        }

        return $this;
    }
}
