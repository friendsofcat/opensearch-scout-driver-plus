<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\BoostParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FieldParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\RelationParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\TimeZoneParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\GroupedArrayTransformer;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\CompoundValidator;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\OneOfValidator;

final class RangeQueryBuilder extends AbstractParameterizedQueryBuilder
{
    use FieldParameter;
    use RelationParameter;
    use BoostParameter;
    use TimeZoneParameter;

    protected string $type = 'range';

    public function __construct()
    {
        $this->parameters = new ParameterCollection();

        $this->parameterValidator = new CompoundValidator(
            new AllOfValidator(['field']),
            new OneOfValidator(['gt', 'gte', 'lt', 'lte'])
        );

        $this->parameterTransformer = new GroupedArrayTransformer('field');
    }

    /**
     * @param string|int $value
     */
    public function gt($value): self
    {
        $this->parameters->put('gt', $value);
        return $this;
    }

    /**
     * @param string|int $value
     */
    public function gte($value): self
    {
        $this->parameters->put('gte', $value);
        return $this;
    }

    /**
     * @param string|int $value
     */
    public function lt($value): self
    {
        $this->parameters->put('lt', $value);
        return $this;
    }

    /**
     * @param string|int $value
     */
    public function lte($value): self
    {
        $this->parameters->put('lte', $value);
        return $this;
    }

    public function format(string $format): self
    {
        $this->parameters->put('format', $format);
        return $this;
    }
}
