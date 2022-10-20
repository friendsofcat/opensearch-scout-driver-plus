<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Decorators;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Traits\ForwardsCalls;
use OpenSearch\Adapter\Search\Hit as BaseHit;
use OpenSearch\ScoutDriverPlus\Factories\LazyModelFactory;

/**
 * @mixin BaseHit
 */
final class Hit implements Arrayable
{
    use ForwardsCalls;

    private BaseHit $baseHit;
    private LazyModelFactory $lazyModelFactory;

    public function __construct(BaseHit $baseHit, LazyModelFactory $lazyModelFactory)
    {
        $this->baseHit = $baseHit;
        $this->lazyModelFactory = $lazyModelFactory;
    }

    public function model(): ?Model
    {
        return $this->lazyModelFactory->makeFromIndexNameAndDocumentId(
            $this->indexName(),
            $this->document()->id()
        );
    }

    public function innerHits(): BaseCollection
    {
        return $this->baseHit->innerHits()->map(
            fn (BaseCollection $baseInnerHits) => $baseInnerHits->map(
                fn (BaseHit $baseInnerHit) => new self($baseInnerHit, $this->lazyModelFactory)
            )
        );
    }

    /**
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        return $this->forwardCallTo($this->baseHit, $method, $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        $model = $this->model();
        $document = $this->document();
        $highlight = $this->highlight();

        return [
            'model' => isset($model) ? $model->toArray() : null,
            'index_name' => $this->indexName(),
            'document' => $document->toArray(),
            'highlight' => isset($highlight) ? $highlight->raw() : null,
            'score' => $this->score(),
        ];
    }
}
