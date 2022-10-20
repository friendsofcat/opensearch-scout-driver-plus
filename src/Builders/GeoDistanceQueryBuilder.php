<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FieldParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\IgnoreUnmappedParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\LatParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\LonParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\ValidationMethodParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\CallbackArrayTransformer;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator;

final class GeoDistanceQueryBuilder extends AbstractParameterizedQueryBuilder
{
    use FieldParameter;
    use LatParameter;
    use LonParameter;
    use ValidationMethodParameter;
    use IgnoreUnmappedParameter;

    protected string $type = 'geo_distance';

    public function __construct()
    {
        $this->parameters = new ParameterCollection();

        $this->parameterValidator = new AllOfValidator(['field', 'distance', 'lat', 'lon']);

        $this->parameterTransformer = new CallbackArrayTransformer(
            static fn (ParameterCollection $parameters) => array_merge(
                [$parameters->get('field') => $parameters->only(['lat', 'lon'])->toArray()],
                $parameters->except(['field', 'lat', 'lon'])->excludeEmpty()->toArray()
            )
        );
    }

    public function distance(string $distance): self
    {
        $this->parameters->put('distance', $distance);
        return $this;
    }

    public function distanceType(string $distanceType): self
    {
        $this->parameters->put('distance_type', $distanceType);
        return $this;
    }
}
