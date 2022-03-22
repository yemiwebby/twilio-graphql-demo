<?php

namespace App\GraphQL\Resolver;

use App\Service\MutationService;
use App\Service\QueryService;
use ArrayObject;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\ArgumentInterface;
use Overblog\GraphQLBundle\Resolver\ResolverMap;

class CustomResolverMap extends ResolverMap {

    public function __construct(
        private QueryService    $queryService,
        private MutationService $mutationService
    ) {
    }

    /**
     * @inheritDoc
     */
    protected function map()
    : array {

        return [
            'RootQuery'    => [
                self::RESOLVE_FIELD => function (
                    $value,
                    ArgumentInterface $args,
                    ArrayObject $context,
                    ResolveInfo $info
                ) {

                    return match ($info->fieldName) {
                        'author' => $this->queryService->findAuthor((int)$args['id']),
                        'authors' => $this->queryService->getAllAuthors(),
                        'findBooksByAuthor' => $this->queryService->findBooksByAuthor($args['name']),
                        'books' => $this->queryService->findAllBooks(),
                        'findBooksByGenre' => $this->queryService->findBooksByGenre($args['genre']),
                        'book' => $this->queryService->findBookById((int)$args['id']),
                        default => null
                    };
                },
            ],
            'RootMutation' => [
                self::RESOLVE_FIELD => function (
                    $value,
                    ArgumentInterface $args,
                    ArrayObject $context,
                    ResolveInfo $info
                ) {

                    return match ($info->fieldName) {
                        'createAuthor' => $this->mutationService->createAuthor($args['author']),
                        'updateBook' => $this->mutationService->updateBook((int)$args['id'], $args['book']),
                        default => null
                    };
                },
            ],
        ];
    }
}