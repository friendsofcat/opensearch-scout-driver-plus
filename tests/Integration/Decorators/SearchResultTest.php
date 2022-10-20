<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Integration\Decorators;

use Illuminate\Database\Eloquent\Collection;
use OpenSearch\Adapter\Documents\Document;
use OpenSearch\Adapter\Search\Highlight;
use OpenSearch\Adapter\Search\SearchResult as BaseSearchResult;
use OpenSearch\ScoutDriverPlus\Decorators\Hit;
use OpenSearch\ScoutDriverPlus\Decorators\SearchResult;
use OpenSearch\ScoutDriverPlus\Factories\ModelFactory;
use OpenSearch\ScoutDriverPlus\Tests\App\Book;
use OpenSearch\ScoutDriverPlus\Tests\App\Model;
use OpenSearch\ScoutDriverPlus\Tests\Integration\TestCase;

/**
 * @covers \OpenSearch\ScoutDriverPlus\Decorators\SearchResult
 *
 * @uses   \OpenSearch\ScoutDriverPlus\Decorators\Hit
 * @uses   \OpenSearch\ScoutDriverPlus\Decorators\Suggestion
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\LazyModelFactory
 */
final class SearchResultTest extends TestCase
{
    private SearchResult $searchResult;

    protected function setUp(): void
    {
        parent::setUp();

        $baseSearchResult = new BaseSearchResult([
            'hits' => [
                'hits' => [
                    [
                        '_id' => '1',
                        '_index' => 'test',
                        '_source' => ['title' => 'foo'],
                        '_score' => 1.1,
                        'highlight' => ['title' => [' <em>foo</em> ']],
                    ],
                ],
            ],
            'suggest' => [
                'bar' => [
                    [
                        'text' => 'foo',
                        'offset' => 0,
                        'length' => 3,
                    ],
                ],
            ],
        ]);

        $model = new Book([
            'id' => 1,
            'title' => 'foo',
        ]);

        $modelFactory = $this->createMock(ModelFactory::class);

        $modelFactory->expects($this->any())
            ->method('makeFromIndexNameAndDocumentIds')
            ->with('test', [(string)$model->getScoutKey()])
            ->willReturn(new Collection([$model]));

        $this->searchResult = new SearchResult($baseSearchResult, $modelFactory);
    }

    public function test_hits_can_be_retrieved(): void
    {
        $hits = $this->searchResult->hits();

        $this->assertCount(1, $hits);
        $this->assertInstanceOf(Hit::class, $hits->first());
        $this->assertSame('test', $hits->first()->indexName());
    }

    public function test_models_can_be_retrieved(): void
    {
        $models = $this->searchResult->models();

        $this->assertCount(1, $models);
        $this->assertInstanceOf(Model::class, $models->first());
        $this->assertSame(1, $models->first()->id);
    }

    public function test_documents_can_be_retrieved(): void
    {
        $documents = $this->searchResult->documents();

        $this->assertCount(1, $documents);
        $this->assertInstanceOf(Document::class, $documents->first());
        $this->assertSame('1', $documents->first()->id());
    }

    public function test_highlights_can_be_retrieved(): void
    {
        $highlights = $this->searchResult->highlights();

        $this->assertCount(1, $highlights);
        $this->assertInstanceOf(Highlight::class, $highlights->first());
        $this->assertSame(' <em>foo</em> ', $highlights->first()->snippets('title')->first());
    }

    public function test_results_can_be_iterated(): void
    {
        foreach ($this->searchResult as $hit) {
            $this->assertInstanceOf(Hit::class, $hit);
            $this->assertSame('test', $hit->indexName());
        }
    }

    public function test_suggestions_can_be_retrieved(): void
    {
        $suggestions = $this->searchResult->suggestions();

        $this->assertCount(1, $suggestions);
        $this->assertCount(1, $suggestions->get('bar'));
        $this->assertSame('foo', $suggestions->get('bar')->first()->text());
    }
}
