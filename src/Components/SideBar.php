<?php

namespace Skins\Chameleon\Components;

class SideBar extends Component {

	/**
	 * @inheritDoc
	 */
	public function getHtml(): string {
		return $this->indent() . '<!-- sidebar -->' . $this->indent() .
				'<aside id="sidebar" class="' . $this->getClassString() . '" >' .
				'</aside>' . "\n";
	}
}

