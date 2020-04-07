<?php
declare(strict_types=1);
/**
 * Contains trait Uuid64Id.
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

namespace Uuid64Type\Entity;

/**
 * Trait to help compose UUID based table primary keys with a custom ID generator.
 *
 * Used in composition pattern vs inherits model with classes.
 *
 * @see Uuid64NGId
 */
trait Uuid64CGId {
    /**
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="uuid64", length=22, nullable=false, options={"fixed":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Uuid64Type\Entity\Uuid64Generator")
     */
    protected $id;
}
