<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\ValuesParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\FlatArrayTransformer;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator;

final class IdsQueryBuilder extends AbstractParameterizedQueryBuilder
{
    use ValuesParameter;

    protected string $type = 'ids';

    public function __construct()
    {
        $this->parameters = new ParameterCollection();
        $this->parameterValidator = new AllOfValidator(['values']);
        $this->parameterTransformer = new FlatArrayTransformer();
    }
}
