<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\AnalyzerParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\AutoGenerateSynonymsPhraseQueryParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\BoostParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FieldParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FuzzinessParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FuzzyRewriteParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FuzzyTranspositionsParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\LenientParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\MaxExpansionsParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\MinimumShouldMatchParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\OperatorParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\PrefixLengthParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\QueryStringParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\ZeroTermsQueryParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\GroupedArrayTransformer;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator;

final class MatchQueryBuilder extends AbstractParameterizedQueryBuilder
{
    use FieldParameter;
    use QueryStringParameter;
    use AnalyzerParameter;
    use AutoGenerateSynonymsPhraseQueryParameter;
    use FuzzinessParameter;
    use MaxExpansionsParameter;
    use PrefixLengthParameter;
    use FuzzyTranspositionsParameter;
    use FuzzyRewriteParameter;
    use LenientParameter;
    use OperatorParameter;
    use MinimumShouldMatchParameter;
    use ZeroTermsQueryParameter;
    use BoostParameter;

    protected string $type = 'match';

    public function __construct()
    {
        $this->parameters = new ParameterCollection();
        $this->parameterValidator = new AllOfValidator(['field', 'query']);
        $this->parameterTransformer = new GroupedArrayTransformer('field');
    }
}
