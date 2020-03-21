<?php
/** @noinspection PhpIllegalPsrClassPathInspection */
/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);
/**
 * Contains class MockUuid4.
 *
 * PHP version 7.3
 *
 * LICENSE:
 * This file is part of Uuid64Type which is a custom Doctrine datatype for
 * UUIDv4 (random) values in MySQL database tables that offers a more compact
 * format that can be useful for primary key columns, etc.
 *
 * Copyright (C) 2020 Michael Cummings. All rights reserved.
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
 * @copyright 2020 Michael Cummings
 * @license   BSD-3-Clause
 */

namespace Spec\Uuid64Type;

use Uuid64Type\Uuid4;

/**
 * Class MockUuid4.
 */
class MockUuid4 {
    use Uuid4;
    
    public function convertBase64ToHex(string $data): string {
        return static::fromBase64ToHexString($data);
    }
    public function convertBase64ToUuid(string $data): string {
        return static::fromBase64ToUuid($data);
    }
    public function convertHexToBase64(string $data): string {
        return static::fromHexStringToBase64($data);
    }
    public function convertHexToUuid(string $data): string {
        return static::fromHexStringToUuid($data);
    }
    public function convertUuidToBase64(string $data): string {
        return static::fromUuidToBase64($data);
    }
    public function convertUuidToHex(string $data): string {
        return static::fromUuidToHexString($data);
    }
    public function getBase64(?array $data = null): string {
        return static::asBase64($data);
    }
    public function getHexString(?array $data = null): string {
        return static::asHexString($data);
    }
    public function getUuid(?array $data = null): string {
        return static::asUuid($data);
    }
}
