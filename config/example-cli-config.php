<?php
declare(strict_types=1);
/**
 *
 * PHP version 7.3
 *
 * LICENSE:
 * This file is part of person_db_skeleton which is a set of skeleton database
 * tables for people and common associated data.
 *
 * Copyright (C) 2019 Michael Cummings. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, this
 * list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation and/or
 * other materials provided with the distribution.
 *
 * 3. Neither the name of the copyright holder nor the names of its contributors
 * may be used to endorse or promote products derived from this software without
 * specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * You should have received a copy of the BSD-3 Clause License along with
 * this program. If not, see
 * <https://spdx.org/licenses/BSD-3-Clause.html>.
 *
 * You should be able to find a copy of this license in the LICENSE file.
 *
 * @author    Michael Cummings <mgcummings@yahoo.com>
 * @copyright 2019 Michael Cummings
 * @license   BSD-3-Clause
 */
// Your existing code ...
require_once dirname(__DIR__, 1) . '/bin/bootstrap.php';
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Console\Helper\HelperSet;
use Uuid64Type\Type\Uuid64Type;

// --snip--
// --snip--
// Example of your possible existing code to create an EntityManager instance ...
$isDevMode = true;
$dbParams = [
    'charset' => 'utf8mb4',
    'collate' => 'utf8mb4_general_ci',
    'dbname' => 'my_db',
    'driver' => 'pdo_mysql',
    'host' => 'localhost',
    'password' => 'secret',
    'user' => 'user',
];
$paths = [\dirname(__DIR__, 1) . '/src/Entity'];
try {
    $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
} catch (AnnotationException $e) {
    print $e->getMessage() . PHP_EOL;
    print $e->getTraceAsString();
    exit(1);
}
try {
    $em = EntityManager::create($dbParams, $config);
} catch (ORMException $e) {
    print $e->getMessage() . PHP_EOL;
    print $e->getTraceAsString();
    exit(1);
}
// --snip--
// Code to get DB connection from EntityManager.
$conn = $em->getConnection();
$type = 'uuid64';
try {
    // Must insure type itself has been registered.
    Type::addType($type, Uuid64Type::class);
    // Registering type to DBAL so translations work correctly.
    $conn->getDatabasePlatform()
         ->registerDoctrineTypeMapping($type, 'binary');
    $conn->getDatabasePlatform()
         ->markDoctrineTypeCommented($type);
} catch (DBALException $e) {
    print $e->getMessage() . PHP_EOL;
    print $e->getTraceAsString();
    exit(1);
}
// --snip--
// Continue on with setting up CLI tools.
return new HelperSet(
    [
        'em' => new EntityManagerHelper($em),
        'db' => new ConnectionHelper($em->getConnection()),
    ]
);
