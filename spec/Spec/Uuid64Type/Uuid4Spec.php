<?php
/** @noinspection PhpIllegalPsrClassPathInspection */
/** @noinspection PhpUndefinedMethodInspection */
/** @noinspection PhpUnused */
declare(strict_types=1);

namespace Spec\Uuid64Type;

use PhpSpec\ObjectBehavior;

/**
 * Class Uuid4Spec
 *
 * @mixin MockUuid4
 *
 */
class Uuid4Spec extends ObjectBehavior {
    public function it_should_convert_from_base64_to_hex_string(): void {
        $data = [
            ['AAYmNkZWZHaKlqMDEyMzQ1', '0062636465664768a96a303132333435'],
            ['BhYmNkZWZHaKlqMDEyMzQ1', '6162636465664768a96a303132333435'],
            ['AAAGNkZWZHaKlqMDEyMzQ1', '0000636465664768a96a303132333435'],
            ['D_YmNkZWZHaKlqMDEyMzQ1', 'ff62636465664768a96a303132333435'],
            ['BhYmNkZWZHaKlqMDEyMzT_', '6162636465664768a96a3031323334ff'],
            ['D__2NkZWZHaKlqMDEyMzQ1', 'ffff636465664768a96a303132333435'],
        ];
        foreach ($data as [$input, $expected]) {
            $this->convertBase64ToHex($input)
                 ->shouldReturn($expected);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_convert_from_base64_to_uuid(): void {
        $data = [
            ['AAYmNkZWZHaKlqMDEyMzQ1', '00626364-6566-4768-a96a-303132333435'],
            ['BhYmNkZWZHaKlqMDEyMzQ1', '61626364-6566-4768-a96a-303132333435'],
            ['AAAGNkZWZHaKlqMDEyMzQ1', '00006364-6566-4768-a96a-303132333435'],
            ['D_YmNkZWZHaKlqMDEyMzQ1', 'ff626364-6566-4768-a96a-303132333435'],
            ['BhYmNkZWZHaKlqMDEyMzT_', '61626364-6566-4768-a96a-3031323334ff'],
            ['D__2NkZWZHaKlqMDEyMzQ1', 'ffff6364-6566-4768-a96a-303132333435'],
        ];
        foreach ($data as [$input, $expected]) {
            $this->convertBase64ToUuid($input)
                 ->shouldReturn($expected);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_convert_from_hex_string_to_base64(): void {
        $data = [
            ['0062636465664768a96a303132333435', 'AAYmNkZWZHaKlqMDEyMzQ1'],
            ['6162636465664768a96a303132333435', 'BhYmNkZWZHaKlqMDEyMzQ1'],
            ['0000636465664768a96a303132333435', 'AAAGNkZWZHaKlqMDEyMzQ1'],
            ['ff62636465664768a96a303132333435', 'D_YmNkZWZHaKlqMDEyMzQ1'],
            ['6162636465664768a96a3031323334ff', 'BhYmNkZWZHaKlqMDEyMzT_'],
            ['ffff636465664768a96a303132333435', 'D__2NkZWZHaKlqMDEyMzQ1'],
        ];
        foreach ($data as [$input, $expected]) {
            $this->convertHexToBase64($input)
                 ->shouldReturn($expected);
        }
    }
    public function it_should_convert_from_hex_string_to_uuid(): void {
        $data = [
            ['0062636465664768a96a303132333435', '00626364-6566-4768-a96a-303132333435'],
            ['6162636465664768a96a303132333435', '61626364-6566-4768-a96a-303132333435'],
            ['0000636465664768a96a303132333435', '00006364-6566-4768-a96a-303132333435'],
            ['ff62636465664768a96a303132333435', 'ff626364-6566-4768-a96a-303132333435'],
            ['6162636465664768a96a3031323334ff', '61626364-6566-4768-a96a-3031323334ff'],
            ['ffff636465664768a96a303132333435', 'ffff6364-6566-4768-a96a-303132333435'],
        ];
        foreach ($data as [$input, $expected]) {
            $this->convertHexToUuid($input)
                 ->shouldReturn($expected);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_convert_from_uuid_to_base64(): void {
        $data = [
            ['00626364-6566-4768-a96a-303132333435', 'AAYmNkZWZHaKlqMDEyMzQ1'],
            ['61626364-6566-4768-a96a-303132333435', 'BhYmNkZWZHaKlqMDEyMzQ1'],
            ['00006364-6566-4768-a96a-303132333435', 'AAAGNkZWZHaKlqMDEyMzQ1'],
            ['ff626364-6566-4768-a96a-303132333435', 'D_YmNkZWZHaKlqMDEyMzQ1'],
            ['61626364-6566-4768-a96a-3031323334ff', 'BhYmNkZWZHaKlqMDEyMzT_'],
            ['ffff6364-6566-4768-a96a-303132333435', 'D__2NkZWZHaKlqMDEyMzQ1'],
        ];
        foreach ($data as [$input, $expected]) {
            $this->convertUuidToBase64($input)
                 ->shouldReturn($expected);
        }
    }
    public function it_should_convert_from_uuid_to_hex_string(): void {
        $data = [
            ['00626364-6566-4768-a96a-303132333435', '0062636465664768a96a303132333435'],
            ['61626364-6566-4768-a96a-303132333435', '6162636465664768a96a303132333435'],
            ['00006364-6566-4768-a96a-303132333435', '0000636465664768a96a303132333435'],
            ['ff626364-6566-4768-a96a-303132333435', 'ff62636465664768a96a303132333435'],
            ['61626364-6566-4768-a96a-3031323334ff', '6162636465664768a96a3031323334ff'],
            ['ffff6364-6566-4768-a96a-303132333435', 'ffff636465664768a96a303132333435'],
        ];
        foreach ($data as [$input, $expected]) {
            $this->convertUuidToHex($input)
                 ->shouldReturn($expected);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_correctly_base64_encode_0_inputs(): void {
        $data = [
            [
                [0, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53],
                'AAYmNkZWZHaKlqMDEyMzQ1',
            ],
            [
                [97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 0],
                'BhYmNkZWZHaKlqMDEyMzQA',
            ],
            [
                [0, 0, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53],
                'AAAGNkZWZHaKlqMDEyMzQ1',
            ],
        ];
        foreach ($data as [$input, $expected]) {
            /**
             * @var $input array
             */
            $this->getBase64($input)
                 ->shouldReturn($expected);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_correctly_base64_encode_255_inputs(): void {
        $data = [
            [
                [255, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53],
                'D_YmNkZWZHaKlqMDEyMzQ1',
            ],
            [
                [97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 255],
                'BhYmNkZWZHaKlqMDEyMzT_',
            ],
            [
                [255, 255, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53],
                'D__2NkZWZHaKlqMDEyMzQ1',
            ],
        ];
        foreach ($data as [$input, $expected]) {
            /**
             * @var $input array
             */
            $this->getBase64($input)
                 ->shouldReturn($expected);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_correctly_base64_encode_uuid(): void {
        $data = [97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53];
        $expected = 'BhYmNkZWZHaKlqMDEyMzQ1';
        $this->getBase64($data)
             ->shouldReturn($expected);
        $this->getBase64()
             ->shouldBeString();
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_correctly_encode_0_inputs(): void {
        $data = [
            [
                [0, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53],
                '00626364-6566-4768-a96a-303132333435',
            ],
            [
                [97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 0],
                '61626364-6566-4768-a96a-303132333400',
            ],
            [
                [0, 0, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53],
                '00006364-6566-4768-a96a-303132333435',
            ],
        ];
        foreach ($data as [$input, $expected]) {
            /**
             * @var $input array
             */
            $this->getUuid($input)
                 ->shouldReturn($expected);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_correctly_encode_255_inputs(): void {
        $data = [
            [
                [255, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53],
                'ff626364-6566-4768-a96a-303132333435',
            ],
            [
                [97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 255],
                '61626364-6566-4768-a96a-3031323334ff',
            ],
            [
                [255, 255, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53],
                'ffff6364-6566-4768-a96a-303132333435',
            ],
        ];
        foreach ($data as [$input, $expected]) {
            /**
             * @var $input array
             */
            $this->getUuid($input)
                 ->shouldReturn($expected);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_correctly_encode_uuid(): void {
        $data = [97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53];
        $expected = '61626364-6566-4768-a96a-303132333435';
        $this->getUuid($data)
             ->shouldReturn($expected);
        $this->getUuid()
             ->shouldBeString();
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_correctly_hexadecimal_encode_0_inputs(): void {
        $data = [
            [
                [0, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53],
                '0062636465664768a96a303132333435',
            ],
            [
                [97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 0],
                '6162636465664768a96a303132333400',
            ],
            [
                [0, 0, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53],
                '0000636465664768a96a303132333435',
            ],
        ];
        foreach ($data as [$input, $expected]) {
            /**
             * @var $input array
             */
            $this->getHexString($input)
                 ->shouldReturn($expected);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_correctly_hexadecimal_encode_255_inputs(): void {
        $data = [
            [
                [255, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53],
                'ff62636465664768a96a303132333435',
            ],
            [
                [97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 255],
                '6162636465664768a96a3031323334ff',
            ],
            [
                [255, 255, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53],
                'ffff636465664768a96a303132333435',
            ],
        ];
        foreach ($data as [$input, $expected]) {
            /**
             * @var $input array
             */
            $this->getHexString($input)
                 ->shouldReturn($expected);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_correctly_hexadecimal_encode_uuid(): void {
        $data = [97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53];
        $expected = '6162636465664768a96a303132333435';
        $this->getHexString($data)
             ->shouldReturn($expected);
        $this->getHexString()
             ->shouldBeString();
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_throw_invalid_argument_exception_for_incorrect_base64_to_hex_string_input(): void {
        $data = [
            ['AAYmNkZWZHaKlqMDEyMzQ', 21],
            ['BhYmNkZWZHaKlqMDEyMzQ11', 23],
            ['AAAGNkZWZHaKlqMDEyMz', 20],
            ['D_YmNkZWZHaKlqMDEyMzQ111', 24],
        ];
        foreach ($data as [$input, $given]) {
            $mess = 'Expected base 64 number length of 22 characters but was given length: ' . $given;
            $this->shouldThrow(new \InvalidArgumentException($mess))
                 ->during('convertBase64ToHex', [$input]);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_throw_invalid_argument_exception_for_incorrect_hex_string_to_base64_input(): void {
        $data = [
            ['0062636465664768a96a30313233343', 31],
            ['6162636465664768a96a3031323334353', 33],
            ['0000636465664768a96a3031323334', 30],
            ['ff62636465664768a96a30313233343535', 34],
        ];
        foreach ($data as [$input, $given]) {
            $mess = 'Expected hex string length of 32 characters but was given length: ' . $given;
            $this->shouldThrow(new \InvalidArgumentException($mess))
                 ->during('convertHexToBase64', [$input]);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_throw_invalid_argument_exception_for_incorrect_hex_string_to_uuid_input(): void {
        $data = [
            ['0062636465664768a96a30313233343', 31],
            ['6162636465664768a96a3031323334353', 33],
            ['0000636465664768a96a3031323334', 30],
            ['ff62636465664768a96a30313233343535', 34],
        ];
        foreach ($data as [$input, $given]) {
            $mess = 'Expected hex string length of 32 characters but was given length: ' . $given;
            $this->shouldThrow(new \InvalidArgumentException($mess))
                 ->during('convertHexToUuid', [$input]);
        }
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_throw_length_exception_for_long_input(): void {
        $data = [96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53];
        $this->shouldThrow(new \LengthException('Expected data array length of 16 but was given length: 17'))
             ->during('getBase64', [$data]);
        $this->shouldThrow(new \LengthException('Expected data array length of 16 but was given length: 17'))
             ->during('getHexString', [$data]);
        $this->shouldThrow(new \LengthException('Expected data array length of 16 but was given length: 17'))
             ->during('getUuid', [$data]);
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    public function it_should_throw_length_exception_for_short_input(): void {
        $data = [98, 99, 100, 101, 102, 103, 104, 105, 106, 48, 49, 50, 51, 52, 53];
        $this->shouldThrow(new \LengthException('Expected data array length of 16 but was given length: 15'))
             ->during('getBase64', [$data]);
        $this->shouldThrow(new \LengthException('Expected data array length of 16 but was given length: 15'))
             ->during('getHexString', [$data]);
        $this->shouldThrow(new \LengthException('Expected data array length of 16 but was given length: 15'))
             ->during('getUuid', [$data]);
    }
    public function let(): void {
        $this->beAnInstanceOf(MockUuid4::class);
    }
}
