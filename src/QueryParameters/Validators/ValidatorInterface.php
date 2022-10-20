<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\QueryParameters\Validators;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;

interface ValidatorInterface
{
    public function validate(ParameterCollection $parameters): void;
}
