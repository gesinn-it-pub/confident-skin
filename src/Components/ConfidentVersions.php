<?php

namespace Skins\Chameleon\Components;

class ConfidentVersions extends Component {

	/**
	 * @inheritDoc
	 */
	public function getHtml(): string {
		global $wgOpenResearchStackVersion;
		global $wgConfidentVersion;

		return $this->indent() . '<!-- versions -->' . $this->indent() .
				'<div id="confident-versions" class="' . $this->getClassString() . '" >' .
			$this->indent(1) .
				'<span class="openresearch-stack-version">OpenResearchStack: ' .
					$wgOpenResearchStackVersion . '</span>' . $this->indent() .
				'<span class="confident-version">Confident: ' .
					$wgConfidentVersion . '</span>' . $this->indent(-1) .
				'</div>';
	}
}
