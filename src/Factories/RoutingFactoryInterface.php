<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Factories;

use Illuminate\Support\Collection;
use OpenSearch\Adapter\Documents\Routing;

interface RoutingFactoryInterface
{
    public function makeFromModels(Collection $models): Routing;
}
