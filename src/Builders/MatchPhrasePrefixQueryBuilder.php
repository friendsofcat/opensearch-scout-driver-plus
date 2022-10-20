<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\AnalyzerParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FieldParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\MaxExpansionsParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\QueryStringParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\SlopParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\ZeroTermsQueryParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\GroupedArrayTransformer;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator;

final class MatchPhrasePrefixQueryBuilder extends AbstractParameterizedQueryBuilder
{
    use FieldParameter;
    use QueryStringParameter;
    use AnalyzerParameter;
    use MaxExpansionsParameter;
    use SlopParameter;
    use ZeroTermsQueryParameter;

    protected string $type = 'match_phrase_prefix';

    public function __construct()
    {
        $this->parameters = new ParameterCollection();
        $this->parameterValidator = new AllOfValidator(['field', 'query']);
        $this->parameterTransformer = new GroupedArrayTransformer('field');
    }
}
