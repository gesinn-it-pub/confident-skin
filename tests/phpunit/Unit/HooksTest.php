<?php

namespace ConfIDentSkin;

use MediaWikiUnitTestCase;

class HooksTest extends MediaWikiUnitTestCase {

	/**
	 * @covers ConfIDentSkin\Hooks::setChameleonExternalStyleModules
	 *
	 */
	public function testBeforeInitializeSetsChameleonExternalStyleModules() {
		global $egChameleonExternalStyleModules;
		$hooks = new Hooks( [ 'some-style' ] );

		$hooks->onMediaWikiServices( null );

		$this->assertCount( 1, $egChameleonExternalStyleModules );
		$this->assertStringEndsWith( 'resources/styles/some-style.scss',
			$egChameleonExternalStyleModules[0] );
	}

	/**
	 * @covers ConfIDentSkin\Hooks::setChameleonExternalStyleModules
	 *
	 */
	public function testBeforeInitializePrependsToExistingChameleonExternalStyleModules() {
		global $egChameleonExternalStyleModules;
		$egChameleonExternalStyleModules = [ 'some-external-style' ];
		$hooks = new Hooks( [ 'some-style' ] );

		$hooks->onMediaWikiServices( null );

		$this->assertCount( 2, $egChameleonExternalStyleModules );
		$this->assertEquals( 'some-external-style', $egChameleonExternalStyleModules[1] );
		$this->assertStringEndsWith( 'resources/styles/some-style.scss',
			$egChameleonExternalStyleModules[0] );
	}

	/**
	 * @covers ConfIDentSkin\Hooks::setChameleonLayoutFile
	 *
	 */
	public function testBeforeInitializeSetsChameleonLayoutFile() {
		global $egChameleonLayoutFile;
		$hooks = new Hooks();

		$hooks->onMediaWikiServices( null );

		$this->assertStringEndsWith( 'layouts/standard.xml', $egChameleonLayoutFile );
	}

}
