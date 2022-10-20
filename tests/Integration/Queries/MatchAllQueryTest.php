<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Integration\Queries;

use OpenSearch\ScoutDriverPlus\Support\Query;
use OpenSearch\ScoutDriverPlus\Tests\App\Book;
use OpenSearch\ScoutDriverPlus\Tests\Integration\TestCase;
use const SORT_NUMERIC;

/**
 * @covers \OpenSearch\ScoutDriverPlus\Builders\MatchAllQueryBuilder
 * @covers \OpenSearch\ScoutDriverPlus\Engine
 * @covers \OpenSearch\ScoutDriverPlus\Factories\LazyModelFactory
 * @covers \OpenSearch\ScoutDriverPlus\Factories\ModelFactory
 * @covers \OpenSearch\ScoutDriverPlus\Support\Query
 *
 * @uses   \OpenSearch\ScoutDriverPlus\Builders\DatabaseQueryBuilder
 * @uses   \OpenSearch\ScoutDriverPlus\Builders\SearchParametersBuilder
 * @uses   \OpenSearch\ScoutDriverPlus\Decorators\Hit
 * @uses   \OpenSearch\ScoutDriverPlus\Decorators\SearchResult
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\DocumentFactory
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\ParameterFactory
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\RoutingFactory
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection
 * @uses   \OpenSearch\ScoutDriverPlus\Searchable
 */
final class MatchAllQueryTest extends TestCase
{
    public function test_all_models_can_be_found(): void
    {
        $target = factory(Book::class, rand(8, 10))
            ->state('belongs_to_author')
            ->create()
            ->sortBy('id', SORT_NUMERIC);

        $found = Book::searchQuery(Query::matchAll())
            ->sort('id')
            ->execute();

        $this->assertFoundModels($target, $found);
    }
}
