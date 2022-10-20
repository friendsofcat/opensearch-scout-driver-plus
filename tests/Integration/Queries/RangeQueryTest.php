<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Integration\Queries;

use OpenSearch\ScoutDriverPlus\Support\Query;
use OpenSearch\ScoutDriverPlus\Tests\App\Book;
use OpenSearch\ScoutDriverPlus\Tests\Integration\TestCase;

/**
 * @covers \OpenSearch\ScoutDriverPlus\Builders\AbstractParameterizedQueryBuilder
 * @covers \OpenSearch\ScoutDriverPlus\Builders\RangeQueryBuilder
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
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\GroupedArrayTransformer
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Validators\CompoundValidator
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Validators\OneOfValidator
 * @uses   \OpenSearch\ScoutDriverPlus\Searchable
 */
final class RangeQueryTest extends TestCase
{
    public function test_models_can_be_found_using_field_and_gt(): void
    {
        // additional mixin
        factory(Book::class)
            ->state('belongs_to_author')
            ->create(['price' => 100]);

        $target = factory(Book::class)
            ->state('belongs_to_author')
            ->create(['price' => 200]);

        $query = Query::range()
            ->field('price')
            ->gt(100);

        $found = Book::searchQuery($query)->execute();

        $this->assertFoundModel($target, $found);
    }

    public function test_models_can_be_found_using_field_and_lt_and_format(): void
    {
        // additional mixin
        factory(Book::class)
            ->state('belongs_to_author')
            ->create(['published' => '2020-10-18']);

        $target = factory(Book::class)
            ->state('belongs_to_author')
            ->create(['published' => '2010-06-17']);

        $query = Query::range()
            ->field('published')
            ->lt('2020')
            ->format('yyyy');

        $found = Book::searchQuery($query)->execute();

        $this->assertFoundModel($target, $found);
    }
}
