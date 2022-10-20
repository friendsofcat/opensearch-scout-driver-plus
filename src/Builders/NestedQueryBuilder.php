<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\IgnoreUnmappedParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\QueryParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\ScoreModeParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\FlatArrayTransformer;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator;
use stdClass;

final class NestedQueryBuilder extends AbstractParameterizedQueryBuilder
{
    use QueryParameter;
    use ScoreModeParameter;
    use IgnoreUnmappedParameter;

    protected string $type = 'nested';

    public function __construct()
    {
        $this->parameters = new ParameterCollection();
        $this->parameterValidator = new AllOfValidator(['path', 'query']);
        $this->parameterTransformer = new FlatArrayTransformer();
    }

    public function path(string $path): self
    {
        $this->parameters->put('path', $path);
        return $this;
    }

    public function innerHits(array $options = []): self
    {
        $this->parameters->put('inner_hits', empty($options) ? new stdClass() : $options);
        return $this;
    }
}
