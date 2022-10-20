<?php
declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus;

use Closure;
use Laravel\Scout\Searchable as BaseSearchable;
use OpenSearch\ScoutDriverPlus\Builders\QueryBuilderInterface;
use OpenSearch\ScoutDriverPlus\Builders\SearchParametersBuilder;

trait Searchable
{
    use BaseSearchable {
        searchableUsing as baseSearchableUsing;
    }

    /**
     * @param Closure|QueryBuilderInterface|array|null $query
     */
    public static function searchQuery($query = null): SearchParametersBuilder
    {
        $builder = new SearchParametersBuilder(new static());

        if (isset($query)) {
            $builder->query($query);
        }

        return $builder;
    }

    /**
     * @return string|int|null
     */
    public function searchableRouting()
    {
        return null;
    }

    /**
     * @return array|string|null
     */
    public function searchableWith()
    {
        return null;
    }

    public function searchableConnection(): ?string
    {
        return null;
    }

    /**
     * @return Engine
     */
    public function searchableUsing()
    {
        /** @var Engine $engine */
        $engine = $this->baseSearchableUsing();
        $connection = $this->searchableConnection();

        return isset($connection) ? $engine->connection($connection) : $engine;
    }
}
