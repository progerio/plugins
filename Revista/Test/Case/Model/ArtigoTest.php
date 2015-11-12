<?php
App::uses('RevistaArtigo', 'Revista.Model');

/**
 * RevistaArtigo Test Case
 *
 */
class ArtigoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.revista.revista_artigo',
		'plugin.revista.edicoes'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RevistaArtigo = ClassRegistry::init('Revista.RevistaArtigo');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RevistaArtigo);

		parent::tearDown();
	}

}
