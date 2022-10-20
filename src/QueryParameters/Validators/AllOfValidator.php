<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\QueryParameters\Validators;

use OpenSearch\ScoutDriverPlus\Exceptions\QueryBuilderValidationException;
use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;

final class AllOfValidator implements ValidatorInterface
{
    private array $required;

    public function __construct(array $required)
    {
        $this->required = $required;
    }

    public function validate(ParameterCollection $parameters): void
    {
        $isInvalid = $parameters->only($this->required)->excludeEmpty()->count() !== count($this->required);

        if ($isInvalid) {
            throw new QueryBuilderValidationException(
                'All required fields have to be specified: ' .
                implode(', ', $this->required)
            );
        }
    }
}
