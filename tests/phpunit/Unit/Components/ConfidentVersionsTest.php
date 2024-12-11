<?php

use PHPUnit\Framework\TestCase;
use Skins\Chameleon\ChameleonTemplate;
use Skins\Chameleon\Components\ConfidentVersions;

/**
 * @covers \Skins\Chameleon\Components\ConfidentVersions
 */
class ConfidentVersionsTest extends TestCase {

	public function testGetHtml() {
		global $wgOpenResearchStackVersion, $wgConfidentVersion;
		$wgOpenResearchStackVersion = '0.0.1';
		$wgConfidentVersion = '0.0.2';
		$versions = new ConfidentVersions( new ChameleonTemplate(), null );

		$result = $versions->getHtml();

		$this->assertRegExp( '/OpenResearchStack.*0\.0\.1.*Confident.*0\.0\.2/s', $result );
	}
}
