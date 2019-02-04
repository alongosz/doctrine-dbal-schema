<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace EzSystems\DoctrineSchema\API;

use Doctrine\DBAL\Schema\Schema;

/**
 * Import database schema from custom Yaml Doctrine Schema format into Schema object.
 *
 * @see \Doctrine\DBAL\Schema\Schema
 */
interface SchemaImporter
{
    /**
     * Import database schema into \Doctrine\DBAL\Schema from file containing custom Yaml format.
     *
     * @param string $schemaFilePath
     *
     * @return \Doctrine\DBAL\Schema\Schema imported schema
     *
     * @throws \EzSystems\DoctrineSchema\API\Exception\InvalidConfigurationException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function importFromFile(string $schemaFilePath): Schema;

    /**
     * Import database schema into \Doctrine\DBAL\Schema from string containing custom Yaml format.
     *
     * @param string $schemaDefinition
     *
     * @return \Doctrine\DBAL\Schema\Schema imported schema
     *
     * @throws \EzSystems\DoctrineSchema\API\Exception\InvalidConfigurationException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function importFromSource(string $schemaDefinition): Schema;
}
