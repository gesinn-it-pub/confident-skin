<?php

namespace ConfIDentSkin;

use OutputPage;
use Skin;

class Hooks {

	public static function initExtension() {
		self::setChameleonLayoutFile();
		self::setChameleonExternalStyleModules();
	}

	private static function setChameleonLayoutFile() {
		global $egChameleonLayoutFile;
		$egChameleonLayoutFile = __DIR__ . '/../layouts/standard.xml';
	}

	private static function setChameleonExternalStyleModules() {
		global $egChameleonExternalStyleModules;
		$egChameleonExternalStyleModules = array_merge(
			[__DIR__ . '/../resources/styles/confident.scss'],
			$egChameleonExternalStyleModules ?? []
		);
	}

}
