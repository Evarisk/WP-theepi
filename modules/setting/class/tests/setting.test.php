<?php
/**
 * Test PHPUnit de setting.class.php
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.3.0
 * @version 0.3.0
 * @copyright 2015-2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

use PHPUnit\Framework\TestCase;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les configurations de TheEPI.
 *
 * @return void
 */
class Setting_Test extends WP_UnitTestCase {
	public function testCanTrue() {
		$this->assertEquals(true);
	}
}
