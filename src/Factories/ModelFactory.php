<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Factories;

use Illuminate\Database\Eloquent\Collection;
use OpenSearch\Adapter\Indices\IndexManager;
use OpenSearch\ScoutDriverPlus\Builders\DatabaseQueryBuilder;

class ModelFactory
{
    private array $databaseQueryBuilders;

    /**
     * @param array<string, DatabaseQueryBuilder> $databaseQueryBuilders ['my_index' => new DatabaseQueryBuilder($model), ...]
     */
    public function __construct(array $databaseQueryBuilders)
    {
        $this->databaseQueryBuilders = $databaseQueryBuilders;
    }

    public function makeFromIndexNameAndDocumentIds(string $indexName, array $documentIds): Collection
    {
        $databaseQueryBuilder = $this->resolveDatabaseQueryBuilder($indexName);

        if (empty($documentIds) || is_null($databaseQueryBuilder)) {
            return new Collection();
        }

        /** @var Collection */
        return $databaseQueryBuilder->buildQuery($documentIds)->get();
    }

    private function resolveDatabaseQueryBuilder(string $indexName): ?DatabaseQueryBuilder
    {
        if (isset($this->databaseQueryBuilders[$indexName])) {
            return $this->databaseQueryBuilders[$indexName];
        }

        /** @var IndexManager $indexManager */
        $indexManager = app(IndexManager::class);

        foreach ($indexManager->getAliases($indexName) as $aliasName) {
            /** @var string $aliasName */
            if (isset($this->databaseQueryBuilders[$aliasName])) {
                return $this->databaseQueryBuilders[$aliasName];
            }
        }

        return null;
    }
}
