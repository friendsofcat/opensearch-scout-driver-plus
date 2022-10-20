<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Unit\Builders;

use OpenSearch\ScoutDriverPlus\Builders\NestedQueryBuilder;
use OpenSearch\ScoutDriverPlus\Exceptions\QueryBuilderValidationException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenSearch\ScoutDriverPlus\Builders\AbstractParameterizedQueryBuilder
 * @covers \OpenSearch\ScoutDriverPlus\Builders\NestedQueryBuilder
 *
 * @uses   \OpenSearch\ScoutDriverPlus\Factories\ParameterFactory
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\FlatArrayTransformer
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\Validators\AllOfValidator
 */
final class NestedQueryBuilderTest extends TestCase
{
    private NestedQueryBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->builder = new NestedQueryBuilder();
    }

    public function test_exception_is_thrown_when_path_is_not_specified(): void
    {
        $this->expectException(QueryBuilderValidationException::class);

        $this->builder
            ->query([
                'match' => [
                    'obj.name' => 'foo',
                ],
            ])
            ->buildQuery();
    }

    public function test_exception_is_thrown_when_query_is_not_specified(): void
    {
        $this->expectException(QueryBuilderValidationException::class);

        $this->builder
            ->path('obj')
            ->buildQuery();
    }

    public function test_query_with_path_and_query_can_be_built(): void
    {
        $expected = [
            'nested' => [
                'path' => 'obj',
                'query' => [
                    'match' => [
                        'obj.name' => 'foo',
                    ],
                ],
            ],
        ];

        $actual = $this->builder
            ->path('obj')
            ->query([
                'match' => [
                    'obj.name' => 'foo',
                ],
            ])
            ->buildQuery();

        $this->assertSame($expected, $actual);
    }

    public function test_query_with_path_and_query_and_score_mode_can_be_built(): void
    {
        $expected = [
            'nested' => [
                'path' => 'obj',
                'query' => [
                    'match' => [
                        'obj.name' => 'foo',
                    ],
                ],
                'score_mode' => 'avg',
            ],
        ];

        $actual = $this->builder
            ->path('obj')
            ->query([
                'match' => [
                    'obj.name' => 'foo',
                ],
            ])
            ->scoreMode('avg')
            ->buildQuery();

        $this->assertSame($expected, $actual);
    }

    public function test_query_with_path_and_query_and_ignore_unmapped_can_be_built(): void
    {
        $expected = [
            'nested' => [
                'path' => 'obj',
                'query' => [
                    'match' => [
                        'obj.name' => 'foo',
                    ],
                ],
                'ignore_unmapped' => true,
            ],
        ];

        $actual = $this->builder
            ->path('obj')
            ->query([
                'match' => [
                    'obj.name' => 'foo',
                ],
            ])
            ->ignoreUnmapped(true)
            ->buildQuery();

        $this->assertSame($expected, $actual);
    }

    public function test_query_with_path_and_query_and_inner_hits_can_be_built(): void
    {
        $expected = [
            'nested' => [
                'path' => 'obj',
                'query' => [
                    'match' => [
                        'obj.name' => 'foo',
                    ],
                ],
                'inner_hits' => [
                    'name' => 'bar',
                ],
            ],
        ];

        $actual = $this->builder
            ->path('obj')
            ->query([
                'match' => [
                    'obj.name' => 'foo',
                ],
            ])
            ->innerHits([
                'name' => 'bar',
            ])
            ->buildQuery();

        $this->assertSame($expected, $actual);
    }
}
