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
     * Custom base 64 encoding of UUID v4 (random).
     *
     * Expected use will be in Doctrine entities instead of using auto-increment IDs.
     *
     * A UUID is 128-bits long in binary so most programming language can only
     * support it in some kind of string or integer array format. Most commonly
     * a binary string is used for compactness where strings can contain (nul)
     * chars. This format is rarely seen except in functions were the UUID is
     * being created as it's hard for programmers to work with since can't be
     * visualized easily. The normal formatted string version with 36
     * characters or as a hexadecimal string with 32 characters are much more
     * commonly used. Both of these formats trade off two times or more memory
     * use to make them easier to work with. By using a base 64 encoding it will
     * increases the memory usage by less than 40 percent (22 chars) over a
     * binary string (16 chars).
     *
     * So in summary these are the benefits to using this custom base 64 encoded
     * format:
     *
     *   * Database compatible - Can be directly stored in any of VARCHAR,
     *     CHAR, BINARY, etc field types.
     *   * URL compatible - Doesn't contain any chars that require special
     *     escaping in URLs.
     *   * HTML compatible - Doesn't include any special chars that need to be
     *     escaped when used in html forms or tag property values. HTML 5
     *     relaxed the rule that required the id's property value have to start
     *     with a letter.
     *   * More Human readable - Base 64 being shorter that other formats
     *     generally make it more readable to most people.
     *   * Best memory to speed trade-off - The binary string takes up the
     *     least memory but it needs to be converted to and from other formats
     *     when using it in URLs etc. which can cause un-needed server load
     *     issues. The normal and hexadecimal forms are both longer which adds
     *     to both memory and server load issues.
     *
     * @param string|null $data Should normally be `null` to create a truly
     *                          random v4 UUID.
     *
     * @return string Returns custom base 64 encoded UUID v4 as string.
     * @throws \Exception Throws an Exception if it was not possible to gather
     * sufficient entropy in random_bytes().
     */
    protected function asBase64(?string $data = null): string {
        $data = $this->asBinString($data);
        return \sodium_bin2base64($data, SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING);
    }
    /**
     * @param string|null $data
     *
     * @return string
     * @throws \Exception
     */
    protected function asHexString(?string $data = null): string {
        $data = $this->asBinString($data);
        return \sodium_bin2hex($data);
    }
    /**
     * Converts custom base 64 encoded UUID v4 back to binary string form.
     *
     * @param string $data
     *
     * @return string The returned string is actually a 128-bit binary string
     * as 16 characters (bytes).
     * @throws \InvalidArgumentException
     */
    protected function fromBase64ToBinString(string $data): string {
        if (22 !== strlen($data)) {
            $mess = 'Expected base 64 number length of 22 characters but was length: ' . strlen($data);
            throw new \InvalidArgumentException($mess);
        }
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        /**
         * @var string $binary
         */
        $binary = \sodium_base642bin($data, SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING);
        if ((0x40 !== (\ord($binary[6]) & 0x40)) || (0x80 !== (\ord($binary[8]) & 0x80))) {
            $mess = 'Not a valid UUID v4';
            throw new \InvalidArgumentException($mess);
        }
        return $binary;
        //// Left pad with 0s and truncate to max length of UUID in base 64.
        //$data = \substr(\str_pad($data, 22, '0', \STR_PAD_LEFT), 0, 22);
        //$base64 = \array_flip(self::$base64);
        //$result = '';
        //$binary = '';
        //// First convert to binary string.
        //foreach (\str_split($data) as $idx) {
        //    if (\array_key_exists($idx, $base64)) {
        //        $binary .= $base64[$idx];
        //    } else {
        //        $mess = 'Invalid base 64 number was given: ' . $idx;
        //        throw new \InvalidArgumentException($mess);
        //    }
        //}
        //// Drop 4 left padding 0s to make 128 bits long again;
        //$binary = \substr($binary, 4);
        //// Finally convert into the binary string.
        //foreach (\str_split($binary, 8) as $value) {
        //    $result .= \chr(\bindec($value));
        //}
        //return $result;
    }
    /**
     * Converts from custom base 64 encoded UUID v4 to normal UUID v4 string.
     *
     * @param string $base64
     *
     * @return string
     * @throws \Exception
     */
    protected function fromBase64ToFull(string $base64): string {
        return $this->uuid($this->fromBase64ToBinString($base64));
    }
    /**
     * Converts normal UUID v4 into custom base 64
     *
     * @param string $uuid
     *
     * @return string
     * @throws \Exception
     */
    protected function fromFullToBase64(string $uuid): string {
        return \sodium_bin2base64($this->fromFullToBinString($uuid), SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING);
    }
    /**
     * @param string $uuid
     *
     * @return string
     */
    protected function fromFullToBinString(string $uuid): string {
        $binary = \sodium_hex2bin($uuid, '{-}');
        if (16 !== strlen($binary)) {
            $mess = 'Expected binary string length to be 16 characters but was length: ' . \strlen($binary);
            throw new \InvalidArgumentException($mess);
        }
        if ((0x40 !== (\ord($binary[6]) & 0x40)) || (0x80 !== (\ord($binary[8]) & 0x80))) {
            $mess = 'Not a valid UUID v4';
            throw new \InvalidArgumentException($mess);
        }
        return $binary;
    }
    /**
     * @param string $hex
     *
     * @return string
     * @throws \Exception
     */
    protected function fromHexStringToBase64(string $hex): string {
        return $this->fromFullToBase64($hex);
    }
    /**
     * Generates a random uuid in full format.
     *
     * Original code for the function was found in answer at
     * https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
     * by Arie which is based on a function found at
     * http://php.net/manual/en/function.com-create-guid.php
     * by pavel.volyntsev(at)gmail.
     * I've farther changed it to allow parameter to be optional based on a
     * comment by Stephen R from the first page.
     *
     * Finally made it into a trait to make adding it to classes easier and
     * renamed it as well.
     *
     * @param string|null $data Should normally be `null` to create a truly
     *                          random v4 UUID.
     *
     * @return string
     * @throws \Exception Throws an Exception if it was not possible to gather
     * sufficient entropy in random_bytes().
     */
    protected function uuid(?string $data = null): string {
        return \vsprintf('%s%s-%s-%s-%s-%s%s%s', \str_split($this->asHexString($data), 4));
    }
    /**
     * Helper method for the common parts of creating new UUID in binary form.
     *
     * @param string|null $data Should normally be `null` to create a truly
     *                          random v4 UUID.
     *
     * @return string The returned string is actually a 128-bit binary string
     * as 16 characters (bytes).
     * @throws \Exception Throws an Exception if it was not possible to gather
     * sufficient entropy in random_bytes().
     */
    private function asBinString(?string $data = null): string {
        $data = $data ?? \random_bytes(16);
        // Left pad string to 16 chars using ascii code 0 if short else
        // truncate strings longer then 16 chars.
        $data = \substr(\str_pad($data, 16, \chr(0), \STR_PAD_LEFT), 0, 16);
        $data[6] = \chr(\ord($data[6]) & 0x0f | 0x40); // set version to 0100 (4 - random)
        $data[8] = \chr(\ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return $data;
    }
}
