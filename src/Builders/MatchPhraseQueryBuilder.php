<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\AnalyzerParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\BoostParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FieldParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\QueryStringParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\SlopParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\ZeroTermsQueryParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\GroupedArrayTransformer;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator;

final class MatchPhraseQueryBuilder extends AbstractParameterizedQueryBuilder
{
    use FieldParameter;
    use QueryStringParameter;
    use SlopParameter;
    use AnalyzerParameter;
    use ZeroTermsQueryParameter;
    use BoostParameter;

    protected string $type = 'match_phrase';

    public function __construct()
    {
        $this->parameters = new ParameterCollection();
        $this->parameterValidator = new AllOfValidator(['field', 'query']);
        $this->parameterTransformer = new GroupedArrayTransformer('field');
    }
}
