<?php
declare(strict_types=1);
/**
 * Contains trait Uuid4.
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

namespace Uuid64Type;

/**
 * Trait Uuid4.
 */
trait Uuid4 {
    /**
     * Generate a custom base 64 encoded UUID v4 (random).
     *
     *
     * @param array|null $data  Should normally be `null` to create a truly
     *                          random v4 UUID.
     *
     * @return string  Returns a custom base 64 encoded UUID v4.
     * @throws \Exception
     */
    protected static function asBase64(?array $data = null): string {
        $binString = '0000' . self::asBinString($data);
        $result = '';
        $pieces = \str_split($binString, 6);
        foreach ($pieces as $piece) {
            $result .= static::$base64[$piece];
        }
        return $result;
    }
    /**
     * Helper method for the common parts of creating new UUID in binary form.
     *
     * @param array|null $data  Should normally be `null` to create a truly
     *                          random v4 UUID.
     *
     * @return string
     * @throws \Exception
     * @private
     */
    protected static function asBinString(?array $data = null): string {
        $binArray = $data ?? \array_map(
                static function ($c) {
                    return \ord($c);
                },
                \str_split(\random_bytes(16))
            );
        if (16 !== \count($binArray)) {
            $mess = 'Expected data array length of 16 but was given length: ' . \count($binArray);
            throw new \LengthException($mess);
        }
        $binArray[6] = $binArray[6] & 0x0f | 0x40;
        $binArray[8] = $binArray[8] & 0x3f | 0x80;
        $binary = '';
        foreach ($binArray as $value) {
            $binary .= \str_pad(\decbin($value), 8, '0', STR_PAD_LEFT);
        }
        return $binary;
    }
    /**
     * Generate a hexadecimal encoded UUID v4 (random).
     *
     * @param array|null $data Should normally be `null` to create a truly
     *                         random v4 UUID.
     *
     * @return string Returns a hexadecimal encoded UUID v4.
     * @throws \Exception
     */
    protected static function asHexString(?array $data = null): string {
        $binString = self::asBinString($data);
        $hexString = '';
        $pieces = \str_split($binString, 32);
        foreach ($pieces as $piece) {
            $hexString .= \str_pad(\base_convert($piece, 2, 16), 8, '0', STR_PAD_LEFT);
            //$hexString .= \str_pad(\dechex(\bindec($piece)), 8, '0', STR_PAD_LEFT);
        }
        return $hexString;
    }
    /**
     * Generate a standard UUID v4 (random).
     *
     * Original code for the function was found in answer at
     * https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
     * by Arie which is based on a function found at
     * http://php.net/manual/en/function.com-create-guid.php
     * by pavel.volyntsev(at)gmail.
     * I've farther changed it to allow parameter to be optional based on a
     * comment by Stephen R from the first page.
     *
     * Many other changes since the above code and changes.
     *
     * @param array|null $data  Should normally be `null` to create a truly
     *                          random v4 UUID.
     *
     * @return string Returns a standard UUID v4.
     * @throws \Exception
     */
    protected static function asUuid(?array $data = null): string {
        $hex = static::asHexString($data);
        return \vsprintf('%s%s-%s-%s-%s-%s%s%s', \str_split($hex, 4));
    }
    /**
     * Convert from a base 64 encoded to a hexadecimal encoded UUID.
     *
     * NOTE: This method does not verify input is valid UUID.
     *
     * @param string $data A base 64 encoded UUID.
     *
     * @return string Returns a hexadecimal encoded UUID.
     */
    protected static function fromBase64ToHexString(string $data): string {
        if (22 !== \strlen($data)) {
            $mess = 'Expected base 64 number length of 22 characters but was given length: ' . \strlen($data);
            throw new \InvalidArgumentException($mess);
        }
        // Need switched keys and values so reverse lookups can be done.
        $flipped = \array_flip(static::$base64);
        $binString = '';
        for ($i = 0, $len = \strlen($data); $i < $len; ++$i) {
            $binString .= $flipped[$data[$i]];
        }
        // Cut off 4 bit zero padding.
        $binString = \substr($binString, -128);
        $hexString = '';
        $pieces = \str_split($binString, 32);
        foreach ($pieces as $piece) {
            $hexString .= \str_pad(\base_convert($piece, 2, 16), 8, '0', STR_PAD_LEFT);
        }
        return $hexString;
    }
    /**
     * Convert from a base 64 encoded to a standard UUID.
     *
     * NOTE: This method does not verify input is valid UUID.
     *
     * @param string $data The base 64 encoded UUID.
     *
     * @return string Returns a standard UUID.
     * @throws \Exception
     */
    protected static function fromBase64ToUuid(string $data): string {
        $hexString = static::fromBase64ToHexString($data);
        return static::fromHexStringToUuid($hexString);
    }
    /**
     * Convert from a hexadecimal encoded to a base 64 encoded UUID.
     *
     * NOTE: This method does not verify input is valid UUID.
     *
     * @param string $data The hexadecimal encoded UUID.
     *
     * @return string Returns base 64 encoded UUID.
     * @throws \Exception
     */
    protected static function fromHexStringToBase64(string $data): string {
        if (32 !== \strlen($data)) {
            $mess = 'Expected hex string length of 32 characters but was given length: ' . \strlen($data);
            throw new \InvalidArgumentException($mess);
        }
        $hexArray = \str_split($data, 8);
        $binString = '0000';
        foreach ($hexArray as $hex) {
            $binString .= \str_pad(\base_convert($hex, 16, 2), 32, '0', STR_PAD_LEFT);
            //$binString .= \str_pad(\decbin(\hexdec($hex)), 32, '0', STR_PAD_LEFT);
        }
        $result = '';
        $pieces = \str_split($binString, 6);
        foreach ($pieces as $piece) {
            $result .= static::$base64[$piece];
        }
        return $result;
    }
    /**
     * Convert from a hexadecimal encoded to a standard UUID.
     *
     * NOTE: This method does not verify input is valid UUID.
     *
     * @param string $data The hexadecimal encoded UUID.
     *
     * @return string Returns a standard UUID.
     */
    protected static function fromHexStringToUuid(string $data): string {
        if (32 !== \strlen($data)) {
            $mess = 'Expected hex string length of 32 characters but was given length: ' . \strlen($data);
            throw new \InvalidArgumentException($mess);
        }
        return \vsprintf('%s%s-%s-%s-%s-%s%s%s', \str_split($data, 4));
    }
    /**
     * Convert from a standard UUID to a base 64 encoded UUID.
     *
     * NOTE: This method does not verify input is valid UUID.
     *
     * @param string $data The standard UUID.
     *
     * @return string Returns base 64 encoded UUID.
     * @throws \Exception
     */
    protected static function fromUuidToBase64(string $data): string {
        $hexString = \str_replace('-', '', $data);
        return static::fromHexStringToBase64($hexString);
    }
    /**
     * Convert from a standard UUID to a hexadecimal encoded UUID.
     *
     * NOTE: This method does not verify input is valid UUID.
     *
     * @param string $data The standard UUID.
     *
     * @return string Returns a hexadecimal encoded UUID.
     */
    protected static function fromUuidToHexString(string $data): string {
        return \str_replace('-', '', $data);
    }
    protected static $base64 = [
        '000000' => 'A',
        '000001' => 'B',
        '000010' => 'C',
        '000011' => 'D',
        '000100' => 'E',
        '000101' => 'F',
        '000110' => 'G',
        '000111' => 'H',
        '001000' => 'I',
        '001001' => 'J',
        '001010' => 'K',
        '001011' => 'L',
        '001100' => 'M',
        '001101' => 'N',
        '001110' => 'O',
        '001111' => 'P',
        '010000' => 'Q',
        '010001' => 'R',
        '010010' => 'S',
        '010011' => 'T',
        '010100' => 'U',
        '010101' => 'V',
        '010110' => 'W',
        '010111' => 'X',
        '011000' => 'Y',
        '011001' => 'Z',
        '011010' => 'a',
        '011011' => 'b',
        '011100' => 'c',
        '011101' => 'd',
        '011110' => 'e',
        '011111' => 'f',
        '100000' => 'g',
        '100001' => 'h',
        '100010' => 'i',
        '100011' => 'j',
        '100100' => 'k',
        '100101' => 'l',
        '100110' => 'm',
        '100111' => 'n',
        '101000' => 'o',
        '101001' => 'p',
        '101010' => 'q',
        '101011' => 'r',
        '101100' => 's',
        '101101' => 't',
        '101110' => 'u',
        '101111' => 'v',
        '110000' => 'w',
        '110001' => 'x',
        '110010' => 'y',
        '110011' => 'z',
        '110100' => '0',
        '110101' => '1',
        '110110' => '2',
        '110111' => '3',
        '111000' => '4',
        '111001' => '5',
        '111010' => '6',
        '111011' => '7',
        '111100' => '8',
        '111101' => '9',
        '111110' => '-',
        '111111' => '_',
    ];
}
