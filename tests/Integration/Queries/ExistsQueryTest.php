<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Integration\Queries;

use OpenSearch\ScoutDriverPlus\Support\Query;
use OpenSearch\ScoutDriverPlus\Tests\App\Book;
use OpenSearch\ScoutDriverPlus\Tests\Integration\TestCase;

/**
 * @covers \OpenSearch\ScoutDriverPlus\Builders\AbstractParameterizedQueryBuilder
 * @covers \OpenSearch\ScoutDriverPlus\Builders\ExistsQueryBuilder
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
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\FlatArrayTransformer
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator
 * @uses   \OpenSearch\ScoutDriverPlus\Searchable
 */
final class ExistsQueryTest extends TestCase
{
    public function test_models_with_existing_fields_can_be_found(): void
    {
        // additional mixin
        factory(Book::class, rand(2, 10))
            ->state('belongs_to_author')
            ->create(['description' => null]);

        $target = factory(Book::class)
            ->state('belongs_to_author')
            ->create(['description' => 'The best book ever']);

        $query = Query::exists()->field('description');
        $found = Book::searchQuery($query)->execute();

        $this->assertFoundModel($target, $found);
    }
}
