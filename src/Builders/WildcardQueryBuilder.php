<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\BoostParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\CaseInsensitiveParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FieldParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\RewriteParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\ValueParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\GroupedArrayTransformer;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator;

final class WildcardQueryBuilder extends AbstractParameterizedQueryBuilder
{
    use FieldParameter;
    use ValueParameter;
    use BoostParameter;
    use RewriteParameter;
    use CaseInsensitiveParameter;

    protected string $type = 'wildcard';

    public function __construct()
    {
        $this->parameters = new ParameterCollection();
        $this->parameterValidator = new AllOfValidator(['field', 'value']);
        $this->parameterTransformer = new GroupedArrayTransformer('field');
    }
}
