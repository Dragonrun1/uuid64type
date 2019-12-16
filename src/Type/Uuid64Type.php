<?php
declare(strict_types=1);
/**
 * Contains class Uuid64Type.
 *
 * PHP version 7.3
 *
 * LICENSE:
 * This file is part of Uuid64Type which is a custom Doctrine datatype for
 * UUIDv4 (random) values in MySQL database tables that offers a more compact
 * format that can be useful for primary key columns, etc.
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

namespace Uuid64Type\Type;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Uuid64Type\Uuid4;

/**
 * Custom doctrine UUID v4 (random) datatype using custom base 64 encoding.
 */
class Uuid64Type extends StringType {
    use Uuid4;
    public const UUID64 = 'uuid64';
    /**
     * Converts a value from its PHP representation to its database representation
     * of this type.
     *
     * @param mixed            $value    The value to convert.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return mixed The database representation of the value.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        return (string)$value;
    }
    /**
     * Converts a value from its database representation to its PHP representation
     * of this type.
     *
     * @param mixed            $value    The value to convert.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return mixed The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if (null === $value) {
            return null;
        }
        return (string)$value;
    }
    /**
     * Gets the name of this type.
     *
     * This is the name you will need in Doctrine ORM to use the type.
     *
     * @return string
     */
    public function getName(): string {
        return self::UUID64;
    }
    /**
     * {@inheritdoc}
     * @throws DBALException
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string {
        $dec = \array_merge($fieldDeclaration, ['length' => 22, 'fixed' => true]);
        return parent::getSQLDeclaration($dec, $platform);
    }
    /**
     * Force SQL comment containing DC2Type so Doctrine reverse engineering works correctly.
     *
     * @param AbstractPlatform $platform
     *
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool {
        return true;
    }
}
