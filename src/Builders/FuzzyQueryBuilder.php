<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FieldParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\FuzzinessParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\MaxExpansionsParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\PrefixLengthParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\RewriteParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Shared\ValueParameter;
use OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\GroupedArrayTransformer;
use OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator;

final class FuzzyQueryBuilder extends AbstractParameterizedQueryBuilder
{
    use FieldParameter;
    use ValueParameter;
    use FuzzinessParameter;
    use MaxExpansionsParameter;
    use PrefixLengthParameter;
    use RewriteParameter;

    protected string $type = 'fuzzy';

    public function __construct()
    {
        $this->parameters = new ParameterCollection();
        $this->parameterValidator = new AllOfValidator(['field', 'value']);
        $this->parameterTransformer = new GroupedArrayTransformer('field');
    }

    public function transpositions(bool $transpositions): self
    {
        $this->parameters->put('transpositions', $transpositions);
        return $this;
    }
}
