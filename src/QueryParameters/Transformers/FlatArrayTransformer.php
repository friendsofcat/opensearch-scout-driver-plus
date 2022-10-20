<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\QueryParameters\Transformers;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;

final class FlatArrayTransformer implements ArrayTransformerInterface
{
    public function transform(ParameterCollection $parameters): array
    {
        return $parameters->excludeEmpty()->toArray();
    }
}
