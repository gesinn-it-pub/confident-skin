<?php

namespace Skins\Chameleon\Components;

use ConfIDentSkin\DomHelpers;

class SideBarDecorator extends Component {

	public static function for( Component $component ) {
		return new self( $component );
	}

	private Component $decoratee;

	public function __construct( Component $decoratee ) {
		$this->decoratee = $decoratee;
		parent::__construct( $decoratee->getSkinTemplate(), $decoratee->getDomElement(),
			$decoratee->getIndent() );
	}

	/**
	 * @inheritDoc
	 * @throws \MWException
	 */
	public function getHtml(): string {
		[ $decorateeHtml, $sidebarHtml ] =
			self::createSidebar( $this->decoratee->getHtml() );

		return $this->indent() .
			'<div class="row">' . $this->indent( 1 ) .
			( $sidebarHtml != '' ?
				'<aside id="sidebar" class="col-12 col-lg-4 order-lg-2">' . $this->indent( 1 ) .
					$sidebarHtml . $this->indent( -1 ) .
				'</aside>' :
				''
			) . $this->indent() .
				'<div class="col">'. $this->indent( 1 ) .
					$decorateeHtml . $this->indent( -1 ) .
				'</div>' . $this->indent( -1 ) .
			'</div>';
	}

	private static function createSidebar( $mainHtml ) {
		$sidebarHtml = '';
		if ( str_contains( $mainHtml, 'sidebarItem' ) ) {
			[ $mainHtml, $sidebarHtml ] =
				DomHelpers::cutElements( $mainHtml, fn( $n ) => self::isSidebarElement( $n ) );
		}
		return [ $mainHtml, $sidebarHtml ];
	}

	private static function isSidebarElement( $node ) {
		if ( !$node->hasAttributes() )
			return false;
		$classes = explode( ' ', $node->getAttribute( 'class' ) );
		return in_array( 'sidebarItem', $classes );
	}
}
