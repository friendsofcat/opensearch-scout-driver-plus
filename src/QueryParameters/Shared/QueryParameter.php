<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\QueryParameters\Shared;

use Closure;
use OpenSearch\ScoutDriverPlus\Builders\QueryBuilderInterface;
use OpenSearch\ScoutDriverPlus\Factories\ParameterFactory;

trait QueryParameter
{
    /**
     * @param Closure|QueryBuilderInterface|array $query
     */
    public function query($query): self
    {
        $this->parameters->put('query', ParameterFactory::makeQuery($query));
        return $this;
    }
}
