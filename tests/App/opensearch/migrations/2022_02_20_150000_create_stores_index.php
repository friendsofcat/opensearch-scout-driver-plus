<?php declare(strict_types=1);

use OpenSearch\Adapter\Indices\Mapping;
use OpenSearch\Migrations\Facades\Index;
use OpenSearch\Migrations\MigrationInterface;

final class CreateStoresIndex implements MigrationInterface
{
    public function up(): void
    {
        Index::dropIfExists('stores');
        Index::create('stores', static function (Mapping $mapping) {
            $mapping->integer('id');
            $mapping->text('name');
            $mapping->geoPoint('location');
        });
    }

    public function down(): void
    {
        Index::dropIfExists('stores');
    }
}
