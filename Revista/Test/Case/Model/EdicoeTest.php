<?php
App::uses('RevistaEdicoe', 'Revista.Model');

/**
 * RevistaEdicoe Test Case
 *
 */
class EdicoeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.revista.revista_edicoe'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RevistaEdicoe = ClassRegistry::init('Revista.RevistaEdicoe');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RevistaEdicoe);

		parent::tearDown();
	}

}
