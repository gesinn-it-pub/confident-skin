<?php

namespace ConfIDentSkin;

use MediaWikiUnitTestCase;

class HooksTest extends MediaWikiUnitTestCase {

	const EXPECTED_STYLES = [
		'ContentHeader',
		'enableShowAllFieldsToggle',
	];

	public function testInitExtensionSetsChameleonExternalStyleModules() {
		global $egChameleonExternalStyleModules;

		Hooks::initExtension();

		$this->assertCount( count( self::EXPECTED_STYLES ), $egChameleonExternalStyleModules );
		foreach ( self::EXPECTED_STYLES as $i => $style ) {
			$this->assertStringEndsWith( 'resources/styles/' . $style . '.scss',
				$egChameleonExternalStyleModules[$i] );
		}
	}

	public function testInitExtensionPrependsToExistingChameleonExternalStyleModules() {
		global $egChameleonExternalStyleModules;
		$egChameleonExternalStyleModules = [ 'x' ];

		Hooks::initExtension();

		$this->assertCount( 1 + count( self::EXPECTED_STYLES ), $egChameleonExternalStyleModules );
		$this->assertEquals( 'x',
			$egChameleonExternalStyleModules[count( self::EXPECTED_STYLES )] );
		foreach ( self::EXPECTED_STYLES as $i => $style ) {
			$this->assertStringEndsWith( 'resources/styles/' . $style . '.scss',
				$egChameleonExternalStyleModules[$i] );
		}
	}

	public function testInitExtensionSetsChameleonLayoutFile() {
		global $egChameleonLayoutFile;

		Hooks::initExtension();

		$this->assertStringEndsWith( 'layouts/standard.xml', $egChameleonLayoutFile );
	}

}
