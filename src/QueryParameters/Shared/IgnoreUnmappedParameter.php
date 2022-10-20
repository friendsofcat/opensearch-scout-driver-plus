<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\QueryParameters\Shared;

trait IgnoreUnmappedParameter
{
    public function ignoreUnmapped(bool $ignoreUnmapped): self
    {
        $this->parameters->put('ignore_unmapped', $ignoreUnmapped);
        return $this;
    }
}
