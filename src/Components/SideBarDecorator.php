<?php

namespace Skins\Chameleon\Components;

use ConfIDentSkin\DomHelpers;
use Skins\Chameleon\ChameleonTemplate;

class SideBarDecorator extends Component {

	public static function for(Component $component) {
		return new self($component);
	}

	private Component $decoratee;

	public function __construct(Component $decoratee) {
		$this->decoratee = $decoratee;
		parent::__construct($decoratee->getSkinTemplate(), $decoratee->getDomElement(),
			$decoratee->indent());
	}

	/**
	 * @inheritDoc
	 * @throws \MWException
	 */
	public function getHtml(): string {
		[$decorateeHtml, $sidebarHtml] =
			self::createSidebar( $this->decoratee->getHtml() );

		return
			'<div class="row">' . $this->indent(1) .
				'<div class="col">'. $this->indent(1) .
					$decorateeHtml . $this->indent(-1) .
				'</div>' .
			($sidebarHtml != '' ? $this->indent() .
				'<aside id="sidebar" class="col-12 col-lg-4">' . $this->indent(1) .
					$sidebarHtml . $this->indent(-1) .
				'</aside>' :
				''
			) . $this->indent(-1) .
			'</div>';
	}

	private static function createSidebar( $mainHtml ) {
		$sidebarHtml = '';
		if (str_contains($mainHtml, 'sidebarItem')) {
			[$mainHtml, $sidebarHtml] =
				DomHelpers::cutElements($mainHtml, fn($n) => self::isSidebarElement($n));
		}
		return [$mainHtml, $sidebarHtml];
	}

	private static function isSidebarElement( $node ) {
		if (!$node->hasAttributes())
			return false;
		$classes = explode(' ', $node->getAttribute('class'));
		return in_array('sidebarItem', $classes);
	}
}
