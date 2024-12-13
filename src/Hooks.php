<?php

namespace ConfIDentSkin;

use MediaWiki\Hook\BeforePageDisplayHook;
use MediaWiki\Hook\MediaWikiServicesHook;

class Hooks implements MediaWikiServicesHook, BeforePageDisplayHook {

	/**
	 * List of SCSS files used by the extension or skin.
	 *
	 * @var string[] List of SCSS file identifiers.
	 */
	private $scssFiles = [
		'extension-PageForms',
		'skin-ContentHeader',
		'skin-enableShowAllFieldsToggle',
	];

	public function __construct( $scssFiles = null ) {
		if ( $scssFiles !== null ) {
			$this->scssFiles = $scssFiles;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function onMediaWikiServices( $services ) {
		$this->setChameleonLayoutFile();
		$this->setChameleonExternalStyleModules();
	}

	private function setChameleonLayoutFile() {
		global $egChameleonLayoutFile;
		$egChameleonLayoutFile = __DIR__ . '/../layouts/standard.xml';
	}

	private function setChameleonExternalStyleModules() {
		global $egChameleonExternalStyleModules;
		$styles =
			array_map( fn( $s ) => __DIR__ . '/../resources/styles/' . $s . '.scss',
				$this->scssFiles );

		$egChameleonExternalStyleModules =
			array_merge( $styles, $egChameleonExternalStyleModules ?? [] );
	}

	/**
	 * @inheritDoc
	 */
	public function onBeforePageDisplay( $out, $skin ): void {
		$out->addModules( 'ext.ConfIDentSkin' );
	}
}
