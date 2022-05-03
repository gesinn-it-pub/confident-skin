<?php

namespace Skins\Chameleon\Components;

use Skins\Chameleon\Components\Component;

class SideBar extends Component {

	/**
	 * @inheritDoc
	 */
	public function getHtml(): string {
		return $this->indent() . '<!-- sidebar -->' . $this->indent() .
				'<aside id="sidebar" class="sidebar ' . $this->getClassString() . '" >' .
				'SIDEBAR' . '</aside>' . "\n";
	}
}

