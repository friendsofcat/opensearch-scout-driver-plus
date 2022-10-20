<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Factories;

use Closure;
use OpenSearch\ScoutDriverPlus\Builders\QueryBuilderInterface;

class ParameterFactory
{
    /**
     * @param Closure|QueryBuilderInterface|array $query
     */
    public static function makeQuery($query): array
    {
        /** @var QueryBuilderInterface|array $query */
        $query = value($query);

        return $query instanceof QueryBuilderInterface ? $query->buildQuery() : $query;
    }
}
