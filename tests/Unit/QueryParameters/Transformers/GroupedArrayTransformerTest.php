<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\Unit\QueryParameters\Transformers;

use OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection;
use OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\GroupedArrayTransformer;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenSearch\ScoutDriverPlus\QueryParameters\Transformers\GroupedArrayTransformer
 *
 * @uses   \OpenSearch\ScoutDriverPlus\QueryParameters\ParameterCollection
 */
final class GroupedArrayTransformerTest extends TestCase
{
    public function test_parameters_can_be_transformed_to_grouped_array(): void
    {
        $parameters = new ParameterCollection([
            'field' => 'title',
            'query' => 'The Best Book',
            'operator' => 'AND',
            'analyzer' => '',
            'lenient' => null,
        ]);

        $transformer = new GroupedArrayTransformer('field');

        $this->assertSame(
            [
                'title' => [
                    'query' => 'The Best Book',
                    'operator' => 'AND',
                ],
            ],
            $transformer->transform($parameters)
        );
    }
}
