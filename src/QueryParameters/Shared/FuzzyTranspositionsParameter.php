<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\QueryParameters\Shared;

trait FuzzyTranspositionsParameter
{
    public function fuzzyTranspositions(bool $fuzzyTranspositions): self
    {
        $this->parameters->put('fuzzy_transpositions', $fuzzyTranspositions);
        return $this;
    }
}
