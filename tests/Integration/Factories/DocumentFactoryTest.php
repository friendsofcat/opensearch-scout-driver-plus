<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Integration\Factories;

use Illuminate\Support\Facades\DB;
use OpenSearch\ScoutDriverPlus\Factories\DocumentFactory;
use OpenSearch\ScoutDriverPlus\Tests\App\Book;
use OpenSearch\ScoutDriverPlus\Tests\Integration\TestCase;

/**
 * @covers \OpenSearch\ScoutDriverPlus\Factories\DocumentFactory
 *
 * @uses   \OpenSearch\ScoutDriverPlus\Engine
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\RoutingFactory
 * @uses   \OpenSearch\ScoutDriverPlus\Searchable
 */
final class DocumentFactoryTest extends TestCase
{
    private DocumentFactory $documentFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->documentFactory = new DocumentFactory();
    }

    public function test_relations_can_be_preloaded(): void
    {
        $models = factory(Book::class, rand(2, 5))
            ->state('belongs_to_author')
            ->create()
            ->fresh();

        DB::enableQueryLog();
        $this->documentFactory->makeFromModels($models);
        $queryLog = DB::getQueryLog();

        $this->assertCount(1, $queryLog);
    }
}
