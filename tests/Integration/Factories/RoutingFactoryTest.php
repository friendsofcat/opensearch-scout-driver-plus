<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Integration\Factories;

use OpenSearch\Adapter\Documents\Routing;
use OpenSearch\ScoutDriverPlus\Factories\RoutingFactory;
use OpenSearch\ScoutDriverPlus\Tests\App\Book;
use OpenSearch\ScoutDriverPlus\Tests\Integration\TestCase;

/**
 * @covers \OpenSearch\ScoutDriverPlus\Factories\RoutingFactory
 *
 * @uses   \OpenSearch\ScoutDriverPlus\Engine
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\DocumentFactory
 * @uses   \OpenSearch\ScoutDriverPlus\Searchable
 */
final class RoutingFactoryTest extends TestCase
{
    private RoutingFactory $routingFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->routingFactory = new RoutingFactory();
    }

    public function test_routing_can_be_made_from_models(): void
    {
        $models = factory(Book::class, rand(2, 10))->state('belongs_to_author')->create();
        $routing = new Routing();

        foreach ($models as $model) {
            $routing->add((string)$model->getScoutKey(), (string)$model->searchableRouting());
        }

        $this->assertEquals($routing, $this->routingFactory->makeFromModels($models));
    }
}
