<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Integration\Queries;

use OpenSearch\Adapter\Search\Suggestion;
use OpenSearch\ScoutDriverPlus\Support\Query;
use OpenSearch\ScoutDriverPlus\Tests\App\Book;
use OpenSearch\ScoutDriverPlus\Tests\Integration\TestCase;

/**
 * @covers \OpenSearch\ScoutDriverPlus\Builders\MatchNoneQueryBuilder
 * @covers \OpenSearch\ScoutDriverPlus\Engine
 * @covers \OpenSearch\ScoutDriverPlus\Factories\LazyModelFactory
 * @covers \OpenSearch\ScoutDriverPlus\Factories\ModelFactory
 * @covers \OpenSearch\ScoutDriverPlus\Support\Query
 *
 * @uses   \OpenSearch\ScoutDriverPlus\Builders\DatabaseQueryBuilder
 * @uses   \OpenSearch\ScoutDriverPlus\Builders\SearchParametersBuilder
 * @uses   \OpenSearch\ScoutDriverPlus\Decorators\Hit
 * @uses   \OpenSearch\ScoutDriverPlus\Decorators\SearchResult
 * @uses   \OpenSearch\ScoutDriverPlus\Decorators\Suggestion
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\DocumentFactory
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\ParameterFactory
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\RoutingFactory
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection
 * @uses   \OpenSearch\ScoutDriverPlus\Searchable
 */
final class MatchNoneQueryTest extends TestCase
{
    public function test_none_models_can_be_found(): void
    {
        factory(Book::class, rand(2, 10))
            ->state('belongs_to_author')
            ->create();

        $found = Book::searchQuery(Query::matchNone())->execute();

        $this->assertSame(0, $found->total());
    }

    public function test_terms_can_be_suggested(): void
    {
        $target = factory(Book::class)
            ->state('belongs_to_author')
            ->create(['title' => 'world']);

        $found = Book::searchQuery(Query::matchNone())
            ->suggest('title', [
                'text' => 'word',
                'term' => [
                    'field' => 'title',
                ],
            ])
            ->execute();

        /** @var Suggestion $suggestion */
        $suggestion = $found->suggestions()->get('title')->first();

        $this->assertSame('word', $suggestion->text());
        $this->assertSame($target->title, $suggestion->options()->first()['text']);
        $this->assertSame(0, $found->total());
    }
}
