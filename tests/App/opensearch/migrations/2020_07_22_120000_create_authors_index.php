<?php declare(strict_types=1);

use OpenSearch\Adapter\Indices\Mapping;
use OpenSearch\Migrations\Facades\Index;
use OpenSearch\Migrations\MigrationInterface;

final class CreateAuthorsIndex implements MigrationInterface
{
    public function up(): void
    {
        Index::dropIfExists('book-authors');
        Index::create('book-authors', static function (Mapping $mapping) {
            $mapping->integer('id');
            $mapping->text('name');
            $mapping->text('last_name');
            $mapping->keyword('phone_number');
            $mapping->text('email');
        });

        Index::dropIfExists('authors');
        Index::putAlias('book-authors', 'authors');
    }

    public function down(): void
    {
        Index::dropIfExists('book-authors');
    }
}
