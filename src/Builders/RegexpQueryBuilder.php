<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\CaseInsensitiveParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FieldParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FlagsParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\MaxDeterminizedStatesParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\RewriteParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\ValueParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\GroupedArrayTransformer;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator;

final class RegexpQueryBuilder extends AbstractParameterizedQueryBuilder
{
    use FieldParameter;
    use ValueParameter;
    use FlagsParameter;
    use MaxDeterminizedStatesParameter;
    use RewriteParameter;
    use CaseInsensitiveParameter;

    protected string $type = 'regexp';

    public function __construct()
    {
        $this->parameters = new ParameterCollection();
        $this->parameterValidator = new AllOfValidator(['field', 'value']);
        $this->parameterTransformer = new GroupedArrayTransformer('field');
    }
}
