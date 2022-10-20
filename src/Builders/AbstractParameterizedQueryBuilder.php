<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;
use OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\ArrayTransformerInterface;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\ValidatorInterface;
use OpenSearch\ScoutDriverPlus\Support\Conditionable;

abstract class AbstractParameterizedQueryBuilder implements QueryBuilderInterface
{
    use Conditionable;

    protected string $type;
    protected ParameterCollection $parameters;
    protected ValidatorInterface $parameterValidator;
    protected ArrayTransformerInterface $parameterTransformer;

    public function buildQuery(): array
    {
        $this->parameterValidator->validate($this->parameters);

        return [
            $this->type => $this->parameterTransformer->transform($this->parameters),
        ];
    }
}
