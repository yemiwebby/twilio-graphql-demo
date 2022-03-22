<?php

namespace App\Service;

use App\Entity\Author;
use App\Entity\Book;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\Error;

class MutationService {

    public function __construct(
        private EntityManagerInterface $manager
    ) {
    }

    public function createAuthor(array $authorDetails)
    : Author {

        $author = new Author(
            $authorDetails['name'],
            DateTime::createFromFormat('d/m/Y', $authorDetails['dateOfBirth']),
            $authorDetails['bio']
        );

        $this->manager->persist($author);
        $this->manager->flush();

        return $author;
    }

    public function updateBook(int $bookId, array $newDetails)
    : Book {

        $book = $this->manager->getRepository(Book::class)->find($bookId);

        if (is_null($book)) {
            throw new Error("Could not find book for specified ID");
        }

        foreach ($newDetails as $property => $value) {
            $book->$property = $value;
        }

        $this->manager->persist($book);
        $this->manager->flush();

        return $book;
    }
}