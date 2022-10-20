<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\AnalyzerParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\AutoGenerateSynonymsPhraseQueryParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\BoostParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FieldsParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FuzzinessParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FuzzyRewriteParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FuzzyTranspositionsParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\LenientParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\MaxExpansionsParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\MinimumShouldMatchParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\OperatorParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\PrefixLengthParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\QueryStringParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\SlopParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\TieBreakerParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\TypeParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\ZeroTermsQueryParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\FlatArrayTransformer;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator;

final class MultiMatchQueryBuilder extends AbstractParameterizedQueryBuilder
{
    use FieldsParameter;
    use QueryStringParameter;
    use TypeParameter;
    use AnalyzerParameter;
    use BoostParameter;
    use OperatorParameter;
    use MinimumShouldMatchParameter;
    use FuzzinessParameter;
    use LenientParameter;
    use PrefixLengthParameter;
    use MaxExpansionsParameter;
    use FuzzyRewriteParameter;
    use ZeroTermsQueryParameter;
    use AutoGenerateSynonymsPhraseQueryParameter;
    use FuzzyTranspositionsParameter;
    use TieBreakerParameter;
    use SlopParameter;

    protected string $type = 'multi_match';

    public function __construct()
    {
        $this->parameters = new ParameterCollection();
        $this->parameterValidator = new AllOfValidator(['fields', 'query']);
        $this->parameterTransformer = new FlatArrayTransformer();
    }
}
