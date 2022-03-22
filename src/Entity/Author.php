<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $dateOfBirth;

    #[ORM\Column(type: 'text')]
    private string $bio;

    #[ORM\OneToMany(
        mappedBy: 'author',
        targetEntity: Book::class,
        orphanRemoval: true
    )]
    private Collection $books;

    public function __construct(
        string            $name,
        DateTimeInterface $dateOfBirth,
        string            $bio
    ) {

        $this->name = $name;
        $this->dateOfBirth = $dateOfBirth;
        $this->bio = $bio;
        $this->books = new ArrayCollection();
    }

    public function getId()
    : ?int {

        return $this->id;
    }

    public function getName()
    : ?string {

        return $this->name;
    }

    public function setName(string $name)
    : void {

        $this->name = $name;
    }

    public function getDateOfBirth()
    : string {

        return $this->dateOfBirth->format('l F jS, Y');
    }

    public function setDateOfBirth(DateTimeInterface $dateOfBirth)
    : void {

        $this->dateOfBirth = $dateOfBirth;
    }

    public function getBio()
    : ?string {

        return $this->bio;
    }

    public function setBio(string $bio)
    : void {

        $this->bio = $bio;
    }

    public function getBooks()
    : Collection {

        return $this->books;
    }

    public function addBook(Book $book)
    : void {

        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setAuthor($this);
        }
    }

    public function removeBook(Book $book)
    : void {

        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getAuthor() === $this) {
                $book->setAuthor(null);
            }
        }
    }
}