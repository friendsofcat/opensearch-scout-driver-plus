<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Tests\App;

use Illuminate\Database\Eloquent\Model as BaseModel;
use OpenSearch\ScoutDriverPlus\Searchable;

abstract class Model extends BaseModel
{
    use Searchable;

    protected $guarded = [];
    public $timestamps = false;

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->attributesToArray();
    }
}
