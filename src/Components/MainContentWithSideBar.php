<?php

namespace Skins\Chameleon\Components;

class MainContentWithSideBar extends Component {

	/**
	 * @inheritDoc
	 * @throws \MWException
	 */
	public function getHtml(): string {
		$mainContent = new MainContent(
			$this->getSkinTemplate(), $this->getDomElement(), $this->getIndent());
		return SideBarDecorator::for($mainContent)->getHtml();
	}

}
