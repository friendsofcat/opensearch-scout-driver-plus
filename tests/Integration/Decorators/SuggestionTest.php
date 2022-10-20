<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Integration\Decorators;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use OpenSearch\Adapter\Search\Suggestion as BaseSuggestion;
use OpenSearch\ScoutDriverPlus\Builders\DatabaseQueryBuilder;
use OpenSearch\ScoutDriverPlus\Decorators\Suggestion;
use OpenSearch\ScoutDriverPlus\Factories\ModelFactory;
use OpenSearch\ScoutDriverPlus\Tests\App\Author;
use OpenSearch\ScoutDriverPlus\Tests\Integration\TestCase;

/**
 * @covers \OpenSearch\ScoutDriverPlus\Decorators\Suggestion
 *
 * @uses   \OpenSearch\ScoutDriverPlus\Builders\DatabaseQueryBuilder
 * @uses   \OpenSearch\ScoutDriverPlus\Engine
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\DocumentFactory
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\ModelFactory
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\RoutingFactory
 * @uses   \OpenSearch\ScoutDriverPlus\Searchable
 */
final class SuggestionTest extends TestCase
{
    private Collection $models;
    private Suggestion $suggestion;

    protected function setUp(): void
    {
        parent::setUp();

        $this->models = factory(Author::class, 5)->create();

        $baseSuggestion = new BaseSuggestion([
            'text' => 'tes',
            'offset' => 0,
            'length' => 3,
            'options' => $this->models->map(
                static fn (Model $model) => [
                    'text' => 'test' . $model->getScoutKey(),
                    '_index' => $model->searchableAs(),
                    '_id' => (string)$model->getScoutKey(),
                ]
            ),
        ]);

        $modelFactory = new ModelFactory([
            $this->models->first()->searchableAs() => new DatabaseQueryBuilder($this->models->first()),
        ]);

        $this->suggestion = new Suggestion($baseSuggestion, $modelFactory);
    }

    public function test_models_can_be_retrieved(): void
    {
        $this->assertEquals(
            $this->models->toArray(),
            $this->suggestion->models()->toArray()
        );
    }
}
