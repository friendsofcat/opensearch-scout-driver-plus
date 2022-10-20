<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Builders;

interface QueryBuilderInterface
{
    public function buildQuery(): array;
}
