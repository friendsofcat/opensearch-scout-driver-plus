<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\QueryParameters\Shared;

trait FuzzinessParameter
{
    public function fuzziness(string $fuzziness): self
    {
        $this->parameters->put('fuzziness', $fuzziness);
        return $this;
    }
}
