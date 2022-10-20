<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\QueryParameters\Shared;

trait FieldsParameter
{
    public function fields(array $fields): self
    {
        $this->parameters->put('fields', $fields);
        return $this;
    }
}
