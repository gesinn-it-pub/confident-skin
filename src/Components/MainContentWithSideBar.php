<?php

namespace Skins\Chameleon\Components;

use Skins\Chameleon\IdRegistry;

class MainContentWithSideBar extends Component {

	/**
	 * @inheritDoc
	 */
	public function getHtml(): string {

		$mainContentHtml = (new MainContent($this->getSkinTemplate(), $this->getDomElement(),
			$this->getIndent()))->getHtml();
		$asideHtml = '';

		return
			'<div class="container">' . $this->indent(1) .
			'<div class="row">' . $this->indent(1) .
				'<div class="col">'. $this->indent(1) .
					$mainContentHtml . $this->indent(-1) .
				'</div>' . $this->indent() .
				'<aside id="sidebar" class="col-12 col-lg-4">' . $asideHtml. '</aside>' . $this->indent(-1) .
			'</div>';
	}
}
