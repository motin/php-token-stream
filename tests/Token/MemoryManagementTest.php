<?php
/*
 * This file is part of the PHP_TokenStream package.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Tests for memory management.
 *
 * @package    PHP_TokenStream
 * @subpackage Tests
 * @author     Fredrik Wollsén <fredrik@neam.se>
 * @copyright  Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @version    Release: @package_version@
 * @link       http://github.com/sebastianbergmann/php-token-stream/
 * @since      Class available since Release 1.0.0
 */
class PHP_Token_MemoryManagementTest extends PHPUnit_Framework_TestCase
{

    public function testMemoryLeak()
    {
        $initialMemoryUsage = memory_get_usage(true);
        for ($i=0; $i<1000; $i++) {
            $this->createAndDestroyTokenStream();
        }
        $additionalMemoryUsage = memory_get_usage(true) - $initialMemoryUsage;
        $this->assertLessThan(10, round($additionalMemoryUsage / 1024 / 1024, 2), 'Creating and destroying a token stream for Token.php 1000 times increases the memory usage with less than 10mb');
    }

    protected function createAndDestroyTokenStream()
    {
        $tokenStream = new PHP_Token_Stream(
          TEST_FILES_PATH . 'Token.php'
        );
        unset($tokenStream);
    }

}
