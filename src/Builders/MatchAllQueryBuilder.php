<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

use stdClass;

final class MatchAllQueryBuilder implements QueryBuilderInterface
{
    protected string $type = 'match_all';

    public function buildQuery(): array
    {
        return [
            $this->type => new stdClass(),
        ];
    }
}
