<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Integration\Queries;

use OpenSearch\ScoutDriverPlus\Builders\NestedQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\TermQueryBuilder;
use OpenSearch\ScoutDriverPlus\Decorators\Hit;
use OpenSearch\ScoutDriverPlus\Support\Query;
use OpenSearch\ScoutDriverPlus\Tests\App\Author;
use OpenSearch\ScoutDriverPlus\Tests\App\Book;
use OpenSearch\ScoutDriverPlus\Tests\Integration\TestCase;

/**
 * @covers \OpenSearch\ScoutDriverPlus\Builders\AbstractParameterizedQueryBuilder
 * @covers \OpenSearch\ScoutDriverPlus\Builders\NestedQueryBuilder
 * @covers \OpenSearch\ScoutDriverPlus\Engine
 * @covers \OpenSearch\ScoutDriverPlus\Factories\LazyModelFactory
 * @covers \OpenSearch\ScoutDriverPlus\Factories\ModelFactory
 * @covers \OpenSearch\ScoutDriverPlus\Support\Query
 *
 * @uses   \OpenSearch\ScoutDriverPlus\Builders\DatabaseQueryBuilder
 * @uses   \OpenSearch\ScoutDriverPlus\Builders\MatchQueryBuilder
 * @uses   \OpenSearch\ScoutDriverPlus\Builders\SearchParametersBuilder
 * @uses   \OpenSearch\ScoutDriverPlus\Builders\TermQueryBuilder
 * @uses   \OpenSearch\ScoutDriverPlus\Decorators\Hit
 * @uses   \OpenSearch\ScoutDriverPlus\Decorators\SearchResult
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\DocumentFactory
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\ParameterFactory
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\RoutingFactory
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FieldParameter
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Shared\QueryStringParameter
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Shared\ValueParameter
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\FlatArrayTransformer
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\GroupedArrayTransformer
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator
 * @uses   \OpenSearch\ScoutDriverPlus\Searchable
 */
final class NestedQueryTest extends TestCase
{
    public function test_models_can_be_found_using_path_and_query(): void
    {
        // additional mixin
        factory(Book::class, rand(2, 10))->create([
            'author_id' => factory(Author::class)->create([
                'name' => 'John',
            ]),
        ]);

        $target = factory(Book::class)->create([
            'author_id' => factory(Author::class)->create([
                'name' => 'Steven',
            ]),
        ]);

        $query = Query::nested()
            ->path('author')
            ->query(
                Query::match()
                    ->field('author.name')
                    ->query('Steven')
            )
            ->innerHits(['name' => 'authors']);

        $found = Book::searchQuery($query)->execute();

        $this->assertFoundModel($target, $found);

        /** @var Hit $hit */
        foreach ($found->hits() as $hit) {
            $this->assertCount(1, $hit->innerHits()->get('authors'));
        }
    }

    public function test_models_can_be_found_using_path_and_query_builder(): void
    {
        // additional mixin
        factory(Book::class)->create([
            'author_id' => factory(Author::class)->create([
                'phone_number' => '202-555-0165',
            ]),
        ]);

        $target = factory(Book::class)->create([
            'author_id' => factory(Author::class)->create([
                'phone_number' => '202-555-0139',
            ]),
        ]);

        $builder = (new NestedQueryBuilder())
            ->path('author')
            ->query(
                (new TermQueryBuilder())
                    ->field('author.phone_number')
                    ->value('202-555-0139')
            );

        $found = Book::searchQuery($builder)->execute();

        $this->assertFoundModel($target, $found);
    }
}
