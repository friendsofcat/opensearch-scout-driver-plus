<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Integration\Factories;

use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
use OpenSearch\Adapter\Search\SearchResult;
use OpenSearch\ScoutDriverPlus\Builders\DatabaseQueryBuilder;
use OpenSearch\ScoutDriverPlus\Factories\LazyModelFactory;
use OpenSearch\ScoutDriverPlus\Factories\ModelFactory;
use OpenSearch\ScoutDriverPlus\Tests\App\Author;
use OpenSearch\ScoutDriverPlus\Tests\App\Book;
use OpenSearch\ScoutDriverPlus\Tests\Integration\TestCase;

/**
 * @covers \OpenSearch\ScoutDriverPlus\Factories\LazyModelFactory
 *
 * @uses   \OpenSearch\ScoutDriverPlus\Builders\DatabaseQueryBuilder
 * @uses   \OpenSearch\ScoutDriverPlus\Engine
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\DocumentFactory
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\ModelFactory
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\RoutingFactory
 * @uses   \OpenSearch\ScoutDriverPlus\Searchable
 */
final class LazyModelFactoryTest extends TestCase
{
    private Author $author;
    private Book $book;
    private LazyModelFactory $lazyModelFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->author = factory(Author::class)->create();
        $this->book = factory(Book::class)->create(['author_id' => $this->author->getKey()]);

        $searchResult = new SearchResult([
            'hits' => [
                'total' => [
                    'value' => 2,
                ],
                'hits' => [
                    [
                        '_id' => (string)$this->author->getScoutKey(),
                        '_index' => $this->author->searchableAs(),
                    ],
                    [
                        '_id' => (string)$this->book->getScoutKey(),
                        '_index' => $this->book->searchableAs(),
                    ],
                ],
            ],
        ]);

        $modelFactory = new ModelFactory([
            $this->author->searchableAs() => new DatabaseQueryBuilder($this->author),
            $this->book->searchableAs() => new DatabaseQueryBuilder($this->book),
        ]);

        $this->lazyModelFactory = new LazyModelFactory($searchResult, $modelFactory);
    }

    public function test_null_is_returned_when_document_is_not_in_search_result(): void
    {
        $this->assertNull(
            $this->lazyModelFactory->makeFromIndexNameAndDocumentId(
                $this->author->searchableAs(),
                '0'
            )
        );
    }

    public function test_models_are_returned_when_documents_are_in_search_result(): void
    {
        /** @var Connection $connection */
        $connection = DB::connection();
        $connection->enableQueryLog();

        // assert that expected models are returned
        $this->assertEquals(
            $this->author->toArray(),
            $this->lazyModelFactory->makeFromIndexNameAndDocumentId(
                $this->author->searchableAs(),
                (string)$this->author->getScoutKey()
            )->toArray()
        );

        $this->assertEquals(
            $this->book->toArray(),
            $this->lazyModelFactory->makeFromIndexNameAndDocumentId(
                $this->book->searchableAs(),
                (string)$this->book->getScoutKey()
            )->toArray()
        );

        // assert that only one query per index is made
        $this->assertCount(2, $connection->getQueryLog());
    }
}
