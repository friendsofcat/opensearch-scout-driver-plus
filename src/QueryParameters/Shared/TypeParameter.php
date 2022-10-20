<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\QueryParameters\Shared;

trait TypeParameter
{
    public function type(string $type): self
    {
        $this->parameters->put('type', $type);
        return $this;
    }
}
