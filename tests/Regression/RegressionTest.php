<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace EzSystems\Tests\DoctrineSchema;

use Doctrine\DBAL\Platforms\MySQL80Platform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaConfig;
use EzSystems\DoctrineSchema\Importer\SchemaImporter;
use EzSystems\Tests\DoctrineSchema\Database\TestDatabaseFactory;
use PHPUnit\Framework\TestCase;

class RegressionTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \EzSystems\DoctrineSchema\API\Exception\InvalidConfigurationException
     */
    public function testRegression(string $tableName, Schema $oldSchema, Schema $newSchema)
    {
        $oldTable = $oldSchema->getTable($tableName);
        $newTable = $newSchema->getTable($tableName);

        self::assertEquals(
            $oldTable,
            $newTable
        );
    }

    public function dataProvider(): array
    {
        $importer = new SchemaImporter();
        $testDatabaseFactory = new TestDatabaseFactory();

        $dir = __DIR__;
        $inputSchemaSQL = file_get_contents("{$dir}/old.sql");
        $connection = $testDatabaseFactory->prepareAndConnect(new MySQL80Platform());
        $connection->exec($inputSchemaSQL);

        $oldSchema = $connection->getSchemaManager()->createSchema();

        $newConfig = new SchemaConfig();
        $newConfig->setName('testdb');
        $newSchema = new Schema([], [], $newConfig);
        $newSchema = $importer->importFromFile("{$dir}/new.yaml", $newSchema);

        return [
            0 => ['ezcurrencydata', $oldSchema, $newSchema],
            1 => ['ezdfsfile', $oldSchema, $newSchema],
            2 => ['ezdiscountsubrule', $oldSchema, $newSchema],
            3 => ['ezdiscountsubrule_value', $oldSchema, $newSchema],
            4 => ['ezm_block', $oldSchema, $newSchema],
            5 => ['ezm_pool', $oldSchema, $newSchema],
            6 => ['[eztrigger', $oldSchema, $newSchema],
            7 => ['ezvatrule_product_category', $oldSchema, $newSchema],
            8 => ['ezworkflow_group_link', $oldSchema, $newSchema],
        ];
    }
}
