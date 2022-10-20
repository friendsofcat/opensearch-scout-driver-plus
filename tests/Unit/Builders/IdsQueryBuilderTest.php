<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Unit\Builders;

use OpenSearch\ScoutDriverPlus\Builders\IdsQueryBuilder;
use OpenSearch\ScoutDriverPlus\Exceptions\QueryBuilderValidationException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenSearch\ScoutDriverPlus\Builders\AbstractParameterizedQueryBuilder
 * @covers \OpenSearch\ScoutDriverPlus\Builders\IdsQueryBuilder
 *
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\FlatArrayTransformer
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator
 */
final class IdsQueryBuilderTest extends TestCase
{
    private IdsQueryBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->builder = new IdsQueryBuilder();
    }

    public function test_exception_is_thrown_when_values_are_not_specified(): void
    {
        $this->expectException(QueryBuilderValidationException::class);

        $this->builder
            ->buildQuery();
    }

    public function test_query_with_values_can_be_built(): void
    {
        $expected = [
            'ids' => [
                'values' => ['1', '2', '3'],
            ],
        ];

        $actual = $this->builder
            ->values(['1', '2', '3'])
            ->buildQuery();

        $this->assertSame($expected, $actual);
    }
}
