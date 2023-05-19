# Full Text Queries

* [Match All](#match-all)
* [Match None](#match-none)
* [Match Phrase Prefix](#match-phrase-prefix)
* [Match Phrase](#match-phrase)
* [Match](#match)
* [Multi-Match](#multi-match)

## Match All

You can use `OpenSearch\ScoutDriverPlus\Support\Query::matchAll()` to build a query that [matches all documents](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::matchAll();

$searchResult = Book::searchQuery($query)->execute();
```

## Match None

You can use `OpenSearch\ScoutDriverPlus\Support\Query::matchNone()` to build a query that
[matches no documents](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::matchNone();

$searchResult = Book::searchQuery($query)->execute();

```

## Match Phrase Prefix

You can use `OpenSearch\ScoutDriverPlus\Support\Query::matchPhrasePrefix()` to build a query that matches documents, which
[contain the words of a provided text](https://opensearch.org/docs/search-plugins/sql/full-text/) 
in the same order as provided:

```php
$query = Query::matchPhrasePrefix()
    ->field('title')
    ->query('My boo');

$searchResult = Book::searchQuery($query)->execute();
```

Available methods:

* [analyzer](#match-phrase-prefix-analyzer)
* [field](#match-phrase-prefix-field)
* [maxExpansions](#match-phrase-prefix-max-expansions)
* [query](#match-phrase-prefix-query)
* [slop](#match-phrase-prefix-slop)
* [zeroTermsQuery](#match-phrase-prefix-zero-terms-query)

### <a name="match-phrase-prefix-analyzer"></a> analyzer

`analyzer` is used to [convert the `query` text into tokens](https://opensearch.org/docs/opensearch/query-dsl/full-text/):

```php
$query = Query::matchPhrasePrefix()
    ->field('title')
    ->query('My boo')
    ->analyzer('english');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-phrase-prefix-field"></a> field

Use `field` to specify [the field you wish to search](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::matchPhrasePrefix()
    ->field('title')
    ->query('My boo');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-phrase-prefix-max-expansions"></a> maxExpansions

You can use `maxExpansions` to specify [maximum number of terms to which the last provided term of the `query` value will expand](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::matchPhrasePrefix()
    ->field('title')
    ->query('My boo')
    ->maxExpansions(50);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-phrase-prefix-query"></a> query

Use `query` to set [the text you wish to find in the provided `field`](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::matchPhrasePrefix()
    ->field('title')
    ->query('My boo');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-phrase-prefix-slop"></a> slop

Use `slop` to define [the maximum number of positions allowed between matching tokens](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::matchPhrasePrefix()
    ->field('title')
    ->query('My boo')
    ->slop(0);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-phrase-prefix-zero-terms-query"></a> zeroTermsQuery

You can define [what to return in case `analyzer` removes all tokens](https://opensearch.org/docs/search-plugins/sql/full-text/)
using `zeroTermsQuery`: 

```php
$query = Query::matchPhrasePrefix()
    ->field('title')
    ->query('My boo')
    ->zeroTermsQuery('none');

$searchResult = Book::searchQuery($query)->execute();
```

## Match Phrase

You can use `OpenSearch\ScoutDriverPlus\Support\Query::matchPhrase()` to build a query that matches documents, which [contain the given phrase](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::matchPhrase()
    ->field('title')
    ->query('My book');

$searchResult = Book::searchQuery($query)->execute();
``` 

Available methods:

* [analyzer](#match-phrase-analyzer)
* [field](#match-phrase-field)
* [query](#match-phrase-query)
* [slop](#match-phrase-slop)
* [zeroTermsQuery](#match-phrase-zero-terms-query)

### <a name="match-phrase-analyzer"></a> analyzer

`analyzer` is used to convert the `query` text into tokens:

```php
$query = Query::matchPhrase()
    ->field('title')
    ->query('My book')
    ->analyzer('english');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-phrase-field"></a> field

Use `field` to specify the field you wish to search:

```php
$query = Query::matchPhrase()
    ->field('title')
    ->query('My book');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-phrase-query"></a> query

Use `query` to set the text you wish to find in the provided `field`:

```php
$query = Query::matchPhrase()
    ->field('title')
    ->query('My book');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-phrase-slop"></a> slop

Use `slop` to define the maximum number of positions allowed between matching tokens:

```php
$query = Query::matchPhrase()
    ->field('title')
    ->query('My book')
    ->slop(0);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-phrase-zero-terms-query"></a> zeroTermsQuery

You can define what to return in case `analyzer` removes all tokens with `zeroTermsQuery`: 

```php
$query = Query::matchPhrase()
    ->field('title')
    ->query('My book')
    ->zeroTermsQuery('none'));

$searchResult = Book::searchQuery($query)->execute();
```

## Match

You can use `OpenSearch\ScoutDriverPlus\Support\Query::match()` to build a query that matches documents, which [contain a provided text, number, date or boolean value](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::match()
    ->field('title')
    ->query('My book');

$searchResult = Book::searchQuery($query)->execute();
```

Available methods:

* [analyzer](#match-analyzer)
* [autoGenerateSynonymsPhraseQuery](#match-auto-generate-synonyms-phrase-query)
* [boost](#match-boost)
* [field](#match-field)
* [fuzziness](#match-fuzziness)
* [fuzzyRewrite](#match-fuzzy-rewrite)
* [fuzzyTranspositions](#match-fuzzy-transpositions)
* [lenient](#match-lenient)
* [maxExpansions](#match-max-expansions)
* [minimumShouldMatch](#match-minimum-should-match)
* [operator](#match-operator)
* [prefixLength](#match-prefix-length)
* [query](#match-query)
* [zeroTermsQuery](#match-zero-terms-query)

### <a name="match-analyzer"></a> analyzer

`analyzer` is used to [convert the `query` text into tokens](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::match()
    ->field('title')
    ->query('My book')
    ->analyzer('english');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-auto-generate-synonyms-phrase-query"></a> autoGenerateSynonymsPhraseQuery

`autoGenerateSynonymsPhraseQuery` allows you to define if match phrase queries have to be [automatically created for multi-term synonyms](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::match()
    ->field('title')
    ->query('My book')
    ->autoGenerateSynonymsPhraseQuery(true);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-boost"></a> boost 

`boost` method allows you to [decrease or increase the relevance scores of the query](https://opensearch.org/docs/search-plugins/sql/full-text/):

 ```php
$query = Query::match()
    ->field('title')
    ->query('My book')
    ->boost(2);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-field"></a> field

Use `field` to specify [the field you wish to search](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::match()
    ->field('title')
    ->query('My book');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-fuzziness"></a> fuzziness

`fuzziness` controls [maximum edit distance allowed for matching](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::match()
    ->field('title')
    ->query('My book')
    ->fuzziness('AUTO');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-fuzzy-rewrite"></a> fuzzyRewrite

`fuzzyRewrite` is used to [rewrite the query](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::match()
    ->field('title')
    ->query('My book')
    ->fuzzyRewrite('constant_score');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-fuzzy-transpositions"></a> fuzzyTranspositions

Use `fuzzyTranspositions` to allow [transpositions for two adjacent characters](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::match()
    ->field('title')
    ->query('My book')
    ->fuzziness('AUTO')
    ->fuzzyTranspositions(true);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-lenient"></a> lenient

Use `lenient` to [ignore format-based errors](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::match()
    ->field('price')
    ->query('My book')
    ->lenient(true);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-max-expansions"></a> maxExpansions

You can use `maxExpansions` to specify [maximum number of terms to which the query will expand](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::match()
    ->field('title')
    ->query('My book')
    ->maxExpansions(50);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-minimum-should-match"></a> minimumShouldMatch

`minimumShouldMatch` defines [minimum number of clauses that must match for a document to be returned](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::match()
    ->field('title')
    ->query('My book')
    ->operator('OR')
    ->minimumShouldMatch(1);

$searchResult = Book::searchQuery($query)->execute();
``` 

### <a name="match-operator"></a> operator

Use `operator` to define [the boolean logic used to interpret the `query` text](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::match()
    ->field('title')
    ->query('My book')
    ->operator('OR');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-prefix-length"></a> prefixLength

`prefixLength` is used to determine [the number of beginning characters left unchanged for fuzzy matching](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::match()
    ->field('title')
    ->query('My book')
    ->fuzziness('AUTO')
    ->prefixLength(0);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-query"></a> query

Use `query` to set [the text you wish to find in the provided `field`](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::match()
    ->field('title')
    ->query('My book');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="match-zero-terms-query"></a> zeroTermsQuery

You can define [what to return in case `analyzer` removes all tokens](https://opensearch.org/docs/search-plugins/sql/full-text/)
with `zeroTermsQuery`: 

```php
$query = Query::match()
    ->field('title')
    ->query('My book')  
    ->zeroTermsQuery('none');

$searchResult = Book::searchQuery($query)->execute();
```

## Multi-Match

You can use `OpenSearch\ScoutDriverPlus\Support\Query::multiMatch()` to build a query that matches documents, which
[contain a provided text, number, date or boolean value in multiple fields](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book');

$searchResult = Book::searchQuery($query)->execute();
```

Available methods:

* [analyzer](#multi-match-analyzer)
* [autoGenerateSynonymsPhraseQuery](#multi-match-auto-generate-synonyms-phrase-query)
* [boost](#multi-match-boost)
* [fields](#multi-match-fields)
* [fuzziness](#multi-match-fuzziness)
* [fuzzyRewrite](#multi-match-fuzzy-rewrite)
* [fuzzyTranspositions](#multi-match-fuzzy-transpositions)
* [lenient](#multi-match-lenient)
* [maxExpansions](#multi-match-max-expansions)
* [minimumShouldMatch](#multi-match-minimum-should-match)
* [operator](#multi-match-operator)
* [prefixLength](#multi-match-prefix-length)
* [query](#multi-match-query)
* [slop](#multi-match-phrase-slop)
* [tieBreaker](#multi-match-tie-breaker)
* [type](#multi-match-type)
* [zeroTermsQuery](#multi-match-zero-terms-query)

### <a name="multi-match-analyzer"></a> analyzer 

`analyzer` is used to convert the `query` text into tokens:

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->analyzer('english');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="multi-match-auto-generate-synonyms-phrase-query"></a> autoGenerateSynonymsPhraseQuery 

`autoGenerateSynonymsPhraseQuery` allows you to define, if match phrase queries have to be automatically created
for multi-term synonyms:

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->autoGenerateSynonymsPhraseQuery(true);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="multi-match-boost"></a> boost 

`boost` method allows you to [decrease or increase the relevance scores of a query](https://opensearch.org/docs/search-plugins/sql/full-text/):

 ```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->boost(2);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="multi-match-fields"></a> fields 

Use `fields` to define [the fields you wish to search in](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="multi-match-fuzziness"></a> fuzziness 

`fuzziness` controls maximum edit distance allowed for matching:

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->fuzziness('AUTO');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="multi-match-fuzzy-rewrite"></a> fuzzyRewrite 

`fuzzyRewrite` is used to rewrite the query:

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->fuzzyRewrite('constant_score');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="multi-match-fuzzy-transpositions"></a> fuzzyTranspositions 

Use `fuzzyTranspositions` to allow transpositions for two adjacent characters:

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->fuzziness('AUTO')
    ->fuzzyTranspositions(true);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="multi-match-lenient"></a> lenient 

Use `lenient` to ignore format-based errors:

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->lenient(true);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="multi-match-max-expansions"></a> maxExpansions 

You can use `maxExpansions` to specify maximum number of terms to which the query will expand:

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->maxExpansions(50);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="multi-match-minimum-should-match"></a> minimumShouldMatch 

`minimumShouldMatch` defines minimum number of clauses that must match for a document to be returned:

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->operator('OR')
    ->minimumShouldMatch(1);

$searchResult = Book::searchQuery($query)->execute();
``` 

### <a name="multi-match-operator"></a> operator 

Use `operator` to define the boolean logic used to interpret the `query` text:

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->operator('OR');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="multi-match-prefix-length"></a> prefixLength 

`prefixLength` is used to determine the number of beginning characters left unchanged for fuzzy matching:

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->fuzziness('AUTO')
    ->prefixLength(0);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="multi-match-query"></a> query 

Use `query` to set the text you wish to find in the provided `fields`:

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book');

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="multi-match-phrase-slop"></a> slop 

Use `slop` to define the maximum number of positions allowed between matching tokens:

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->slop(0);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="multi-match-tie-breaker"></a> tieBreaker 

`tieBreaker` is used to increase the [relevance scores](https://opensearch.org/docs/search-plugins/sql/full-text/)
of documents matching the query:

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->tieBreaker(0.3);

$searchResult = Book::searchQuery($query)->execute();
```

### <a name="multi-match-type"></a> type 

Use `type` to define [how the query must be executed](https://opensearch.org/docs/search-plugins/sql/full-text/):

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->type('best_fields');

$searchResult = Book::searchQuery($query)->execute();
``` 

**Note** that not all available methods make sense with every type. Read [the documentation](https://opensearch.org/docs/search-plugins/sql/full-text/) carefully.

### <a name="multi-match-zero-terms-query"></a> zeroTermsQuery 

You can define what to return in case `analyzer` removes all tokens with `zeroTermsQuery`: 

```php
$query = Query::multiMatch()
    ->fields(['title', 'description'])
    ->query('My book')
    ->zeroTermsQuery('none');

$searchResult = Book::searchQuery($query)->execute();
```
