<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Exceptions;

use OpenSearch\Common\Exceptions\InvalidArgumentException;

final class ModelNotJoinedException extends InvalidArgumentException
{
    public function __construct(string $modelClass)
    {
        parent::__construct(sprintf(
            '%s must be added to search via "join" method',
            $modelClass
        ));
    }
}
