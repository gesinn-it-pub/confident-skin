<?php

namespace ConfIDentSkin;

use OutputPage;
use Skin;

class Hooks {

	public static function initExtension() {
		global $egChameleonExternalStyleModules;
		$egChameleonExternalStyleModules = array_merge(
			[__DIR__ . '/../resources/styles/confident.scss'],
			$egChameleonExternalStyleModules ?? []
		);
	}

	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		global $egChameleonLayoutFile;
		$egChameleonLayoutFile = __DIR__ . '/../layouts/standard.xml';

		$out->addModules( 'ext.ConfIDentSkin' );
		return true;
	}
}
