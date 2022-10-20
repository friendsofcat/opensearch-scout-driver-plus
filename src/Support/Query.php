<?php declare(strict_types=1);

namespace OpenSearch\ScoutDriverPlus\Support;

use Illuminate\Support\Traits\Macroable;
use OpenSearch\ScoutDriverPlus\Builders\BoolQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\ExistsQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\FuzzyQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\GeoDistanceQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\IdsQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\MatchAllQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\MatchNoneQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\MatchPhrasePrefixQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\MatchPhraseQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\MatchQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\MultiMatchQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\NestedQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\PrefixQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\RangeQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\RegexpQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\TermQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\TermsQueryBuilder;
use OpenSearch\ScoutDriverPlus\Builders\WildcardQueryBuilder;

class Query
{
    use Macroable;

    public static function bool(): BoolQueryBuilder
    {
        return new BoolQueryBuilder();
    }

    public static function nested(): NestedQueryBuilder
    {
        return new NestedQueryBuilder();
    }

    public static function matchAll(): MatchAllQueryBuilder
    {
        return new MatchAllQueryBuilder();
    }

    public static function matchNone(): MatchNoneQueryBuilder
    {
        return new MatchNoneQueryBuilder();
    }

    public static function match(): MatchQueryBuilder
    {
        return new MatchQueryBuilder();
    }

    public static function matchPhrase(): MatchPhraseQueryBuilder
    {
        return new MatchPhraseQueryBuilder();
    }

    public static function matchPhrasePrefix(): MatchPhrasePrefixQueryBuilder
    {
        return new MatchPhrasePrefixQueryBuilder();
    }

    public static function multiMatch(): MultiMatchQueryBuilder
    {
        return new MultiMatchQueryBuilder();
    }

    public static function exists(): ExistsQueryBuilder
    {
        return new ExistsQueryBuilder();
    }

    public static function fuzzy(): FuzzyQueryBuilder
    {
        return new FuzzyQueryBuilder();
    }

    public static function ids(): IdsQueryBuilder
    {
        return new IdsQueryBuilder();
    }

    public static function prefix(): PrefixQueryBuilder
    {
        return new PrefixQueryBuilder();
    }

    public static function range(): RangeQueryBuilder
    {
        return new RangeQueryBuilder();
    }

    public static function regexp(): RegexpQueryBuilder
    {
        return new RegexpQueryBuilder();
    }

    public static function term(): TermQueryBuilder
    {
        return new TermQueryBuilder();
    }

    public static function terms(): TermsQueryBuilder
    {
        return new TermsQueryBuilder();
    }

    public static function wildcard(): WildcardQueryBuilder
    {
        return new WildcardQueryBuilder();
    }

    public static function geoDistance(): GeoDistanceQueryBuilder
    {
        return new GeoDistanceQueryBuilder();
    }
}
