<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\ManyToOne(targetEntity: Author::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private Author $author;

    #[ORM\Column(type: 'text')]
    private string $synopsis;

    #[ORM\Column(type: 'string', length: 4)]
    private string $releaseYear;

    #[ORM\Column(type: 'string')]
    private string $genre;

    #[ORM\Column(type: 'integer')]
    private int $averageRating;

    #[ORM\Column(type: 'integer')]
    private int $copiesSold;

    public function __construct(
        string $title,
        Author $author,
        string $synopsis,
        string $releaseYear,
        int    $averageRating,
        int    $copiesSold,
        string $genre
    ) {

        $this->title = $title;
        $this->author = $author;
        $this->synopsis = $synopsis;
        $this->releaseYear = $releaseYear;
        $this->averageRating = $averageRating;
        $this->copiesSold = $copiesSold;
        $this->genre = $genre;
    }

    public function getId()
    : ?int {

        return $this->id;
    }

    public function getTitle()
    : ?string {

        return $this->title;
    }

    public function setTitle(string $title)
    : void {

        $this->title = $title;
    }

    public function getAuthor()
    : ?Author {

        return $this->author;
    }

    public function setAuthor(?Author $author)
    : void {

        $this->author = $author;
    }

    public function getSynopsis()
    : ?string {

        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis)
    : void {

        $this->synopsis = $synopsis;
    }

    public function getReleaseYear()
    : ?string {

        return $this->releaseYear;
    }

    public function setReleaseYear(string $releaseYear)
    : void {

        $this->releaseYear = $releaseYear;
    }

    public function getAverageRating()
    : ?int {

        return $this->averageRating;
    }

    public function setAverageRating(int $averageRating)
    : void {

        $this->averageRating = $averageRating;
    }

    public function getCopiesSold()
    : ?int {

        return $this->copiesSold;
    }

    public function setCopiesSold(int $copiesSold)
    : void {

        $this->copiesSold = $copiesSold;

    }

    public function getGenre()
    : string {

        return $this->genre;
    }

    public function setGenre(string $genre)
    : void {

        $this->genre = $genre;
    }

    public function __set(string $property, mixed $value)
    : void {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}