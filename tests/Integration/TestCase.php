<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Integration;

use Illuminate\Config\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Laravel\Scout\ScoutServiceProvider;
use OpenSearch\Laravel\Client\ServiceProvider as OpenSearchClientServiceProvider;
use OpenSearch\Migrations\ServiceProvider as OpenSearchMigrationsServiceProvider;
use OpenSearch\ScoutDriver\ServiceProvider as OpenSearchScoutDriverServiceProvider;
use OpenSearch\ScoutDriverPlus\Decorators\SearchResult;
use OpenSearch\ScoutDriverPlus\ServiceProvider as OpenSearchScoutDriverPlusServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    protected Repository $config;

    protected function getPackageProviders($app)
    {
        return [
            ScoutServiceProvider::class,
            OpenSearchClientServiceProvider::class,
            OpenSearchMigrationsServiceProvider::class,
            OpenSearchScoutDriverServiceProvider::class,
            OpenSearchScoutDriverPlusServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $this->config = $app['config'];
        $this->config->set('scout.driver', 'opensearch');
        $this->config->set('opensearch.migrations.storage.default_path', dirname(__DIR__) . '/App/opensearch/migrations');
        $this->config->set('opensearch.scout_driver.refresh_documents', true);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(dirname(__DIR__) . '/App/database/migrations');
        $this->withFactories(dirname(__DIR__) . '/App/database/factories');

        $this->artisan('migrate')->run();
        $this->artisan('opensearch:migrate')->run();
    }

    protected function tearDown(): void
    {
        $this->artisan('opensearch:migrate:reset')->run();
        $this->artisan('migrate:reset')->run();

        parent::tearDown();
    }

    protected function assertFoundModel(Model $model, SearchResult $searchResult): void
    {
        $this->assertCount(1, $searchResult->models());
        $this->assertEquals($model->toArray(), $searchResult->models()->first()->toArray());
    }

    protected function assertFoundModels(Collection $models, SearchResult $searchResult): void
    {
        $this->assertEquals($models->values()->toArray(), $searchResult->models()->values()->toArray());
    }
}
