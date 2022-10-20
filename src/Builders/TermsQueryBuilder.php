<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\BoostParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FieldParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\ValuesParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\CallbackArrayTransformer;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator;

final class TermsQueryBuilder extends AbstractParameterizedQueryBuilder
{
    use FieldParameter;
    use ValuesParameter;
    use BoostParameter;

    protected string $type = 'terms';

    public function __construct()
    {
        $this->parameters = new ParameterCollection();

        $this->parameterValidator = new AllOfValidator(['field', 'values']);

        $this->parameterTransformer = new CallbackArrayTransformer(
            static fn (ParameterCollection $parameters) => array_merge(
                [$parameters->get('field') => $parameters->get('values')],
                $parameters->except(['field', 'values'])->excludeEmpty()->toArray(),
            )
        );
    }
}
