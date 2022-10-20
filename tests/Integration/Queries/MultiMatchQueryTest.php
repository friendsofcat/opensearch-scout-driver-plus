<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Integration\Queries;

use OpenSearch\ScoutDriverPlus\Support\Query;
use OpenSearch\ScoutDriverPlus\Tests\App\Book;
use OpenSearch\ScoutDriverPlus\Tests\Integration\TestCase;

/**
 * @covers \OpenSearch\ScoutDriverPlus\Builders\AbstractParameterizedQueryBuilder
 * @covers \OpenSearch\ScoutDriverPlus\Builders\MultiMatchQueryBuilder
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
final class MultiMatchQueryTest extends TestCase
{
    public function test_models_can_be_found_using_fields_and_text(): void
    {
        // additional mixin
        factory(Book::class)
            ->state('belongs_to_author')
            ->create([
                'title' => 'mixin title',
                'description' => 'mixin description',
            ]);

        $target = factory(Book::class)
            ->state('belongs_to_author')
            ->create([
                'title' => 'foo',
                'description' => 'bar',
            ]);

        $query = Query::multiMatch()
            ->fields(['title', 'description'])
            ->query('foo bar');

        $found = Book::searchQuery($query)->execute();

        $this->assertFoundModel($target, $found);
    }
}
