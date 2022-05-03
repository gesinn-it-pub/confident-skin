<?php

namespace ConfIDentSkin;

use MediaWikiUnitTestCase;

class HooksTest extends MediaWikiUnitTestCase {

	public function testInitExtensionSetsChameleonExternalStyleModules() {
		global $egChameleonExternalStyleModules;

		Hooks::initExtension();

		$this->assertCount(1, $egChameleonExternalStyleModules);
		$this->assertStringEndsWith('resources/styles/confident.scss',
			$egChameleonExternalStyleModules[0]);
	}

	public function testInitExtensionPrependsToExistingChameleonExternalStyleModules() {
		global $egChameleonExternalStyleModules;
		$egChameleonExternalStyleModules = ['x'];

		Hooks::initExtension();

		$this->assertCount(2, $egChameleonExternalStyleModules);
		$this->assertStringEndsWith('resources/styles/confident.scss',
			$egChameleonExternalStyleModules[0]);
		$this->assertEquals('x', $egChameleonExternalStyleModules[1]);
	}
}
