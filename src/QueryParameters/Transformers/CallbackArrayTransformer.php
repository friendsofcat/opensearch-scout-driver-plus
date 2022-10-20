<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\QueryParameters\Transformers;

use Closure;
use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;

final class CallbackArrayTransformer implements ArrayTransformerInterface
{
    private Closure $callback;

    public function __construct(Closure $callback)
    {
        $this->callback = $callback;
    }

    public function transform(ParameterCollection $parameters): array
    {
        return call_user_func($this->callback, $parameters);
    }
}
