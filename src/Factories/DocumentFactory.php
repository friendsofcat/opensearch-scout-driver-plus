<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Factories;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as BaseCollection;
use OpenSearch\ScoutDriver\Factories\DocumentFactory as BaseDocumentFactory;

class DocumentFactory extends BaseDocumentFactory
{
    public function makeFromModels(BaseCollection $models): BaseCollection
    {
        $models = new EloquentCollection($models);

        if ($searchableWith = $models->first()->searchableWith()) {
            $models->loadMissing($searchableWith);
        }

        return parent::makeFromModels($models);
    }
}
