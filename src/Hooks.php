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
		$styles = array_map(fn ($s) => __DIR__ . '/../resources/styles/' . $s . '.scss', [
			'ContentHeader',
			'enableShowAllFieldsToggle',
		]);

		$egChameleonExternalStyleModules = array_merge(
			$styles,
			$egChameleonExternalStyleModules ?? []
		);
	}

	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		$out->addModules( 'ext.ConfIDentSkin' );
		return true;
	}
}
