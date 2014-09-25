<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 BitPay, Inc.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Bitpay\Util;

class Base58Test extends \PHPUnit_Framework_TestCase
{
    public function testEncode()
    {
        foreach ($this->getTestData() as $datum) {
            $this->assertSame($datum[1], Base58::encode($datum[0]));
        }
    }

    /**
     * @expectedException Exception
     */
    public function testEncodeSpecial()
    {
        $data = array(
            array('', '', '3QJmnh'),
        );
        foreach ($data as $datum) {
            $this->assertSame($datum[1], Base58::encode($datum[0]));
        }
    }

    public function testDecode()
    {
        foreach ($this->getTestData() as $datum) {
            $this->assertSame($datum[0], Base58::decode($datum[1]));
        }
    }

    public function testDecodeSpecial()
    {
        $data = array(
            // is this right?
            array('', '0', ''),
            array('', '00', ''),
            array('3e', '25', ''),
            array('39', 'z', ''),
        );
        foreach ($data as $datum) {
            $decoded = Base58::decode($datum[1]);
            $this->assertSame($datum[0], $decoded, sprintf('%s != %s', $datum[0], $decoded));
        }
    }

    private function getTestData()
    {
        return array(
            // original, encoded, check
            array('61', '2g', 'C2dGTwc'),
            array('626262', 'a3gV', '4jF5uERJAK'),
            array('636363', 'aPEr', '4mT4krqUYJ'),
            array('73696d706c792061206c6f6e6720737472696e67', '2cFupjhnEsSn59qHXstmK2ffpLv2', 'BXF1HuEUCqeVzZdrKeJjG74rjeXxqJ7dW'),
            array('00eb15231dfceb60925886b67d065299925915aeb172c06647', '1NS17iag9jJgTHD1VXjvLCEnZuQ3rJDE9L', '13REmUhe2ckUKy1FvM7AMCdtyYq831yxM3QeyEu4'),
            array('516b6fcd0f', 'ABnLTmg', '237LSrY9NUUas'),
            array('bf4f89001e670274dd', '3SEo3LWLoPntC', 'GwDDDeduj1jpykc27e'),
            array('572e4794', '3EFU7m', 'FamExfqCeza'),
            array('ecac89cad93923c02321', 'EJDM8drfXA6uyA', '2W1Yd5Zu6WGyKVtHGMrH'),
            array('10c8511e', 'Rt5zm', '3op3iuGMmhs'),
            array('00000000000000000000', '1111111111', '111111111146Momb'),
        );
    }
}
