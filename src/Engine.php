<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus;

use Illuminate\Database\Eloquent\Model;
use OpenSearch\Adapter\Documents\DocumentManager;
use OpenSearch\Adapter\Indices\IndexManager;
use OpenSearch\Adapter\Search\SearchParameters;
use OpenSearch\Adapter\Search\SearchResult;
use OpenSearch\ScoutDriver\Engine as BaseEngine;
use OpenSearch\ScoutDriver\Factories\DocumentFactoryInterface;
use OpenSearch\ScoutDriver\Factories\ModelFactoryInterface;
use OpenSearch\ScoutDriver\Factories\SearchParametersFactoryInterface;
use OpenSearch\ScoutDriverPlus\Factories\RoutingFactoryInterface;

class Engine extends BaseEngine
{
    private RoutingFactoryInterface $routingFactory;

    public function __construct(
        DocumentManager $documentManager,
        IndexManager $indexManager,
        DocumentFactoryInterface $documentFactory,
        SearchParametersFactoryInterface $searchParametersFactory,
        ModelFactoryInterface $modelFactory,
        RoutingFactoryInterface $routingFactory
    ) {
        parent::__construct($documentManager, $documentFactory, $searchParametersFactory, $modelFactory, $indexManager);

        $this->routingFactory = $routingFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function update($models)
    {
        if ($models->isEmpty()) {
            return;
        }

        $indexName = $models->first()->searchableAs();
        $routing = $this->routingFactory->makeFromModels($models);
        $documents = $this->documentFactory->makeFromModels($models);

        $this->documentManager->index($indexName, $documents, $this->refreshDocuments, $routing);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($models)
    {
        if ($models->isEmpty()) {
            return;
        }

        $indexName = $models->first()->searchableAs();
        $routing = $this->routingFactory->makeFromModels($models);
        $documentIds = $models->map(static fn (Model $model) => (string)$model->getScoutKey())->all();

        $this->documentManager->delete($indexName, $documentIds, $this->refreshDocuments, $routing);
    }

    public function searchWithParameters(SearchParameters $searchParameters): SearchResult
    {
        return $this->documentManager->search($searchParameters);
    }

    public function connection(string $connection): self
    {
        $self = clone $this;
        $self->documentManager = $self->documentManager->connection($connection);
        $self->indexManager = $self->indexManager->connection($connection);
        return $self;
    }
}
