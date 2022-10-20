<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\QueryParameters\Shared;

trait MaxExpansionsParameter
{
    public function maxExpansions(int $maxExpansions): self
    {
        $this->parameters->put('max_expansions', $maxExpansions);
        return $this;
    }
}
