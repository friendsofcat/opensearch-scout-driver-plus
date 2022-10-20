<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\QueryParameters\Transformers;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;

interface ArrayTransformerInterface
{
    public function transform(ParameterCollection $parameters): array;
}
