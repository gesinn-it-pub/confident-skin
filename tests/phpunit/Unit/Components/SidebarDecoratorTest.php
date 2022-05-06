<?php

use PHPUnit\Framework\TestCase;
use Skins\Chameleon\ChameleonTemplate;
use Skins\Chameleon\Components\MainContentWithSideBar;

/**
 * @covers \Skins\Chameleon\Components\SideBarDecorator
 * @covers \Skins\Chameleon\Components\MainContentWithSideBar
 */
class SidebarDecoratorTest extends TestCase {

	// Do not test SideBarDecorator directly but via components using it
	public static function sidebarDecoratorClasses() {
		return [ [ MainContentWithSideBar::class ] ];
	}

	/**
	 * @dataProvider sidebarDecoratorClasses
	 */
	public function testSidebarDisplay( $componentClass ) {
		$component = $this->createComponent($componentClass, '<div><p>foo</p><p class="sidebarItem">bar</p></div>' );
		$html = $component->getHtml();
		$this->assertStringContainsString( '<aside id="sidebar"', $html );
	}

	/**
	 * @dataProvider sidebarDecoratorClasses
	 */
	public function testSidebarIsNotDisplayedIfThereAreNoCorrespondingElements( $componentClass ) {
		$component = $this->createComponent( $componentClass, '<div><p>foo</p><p>fake sidebarItem</p></div>');
		$html = $component->getHtml();
		$this->assertStringNotContainsString( 'id="sidebar"', $html );
	}

	private function createComponent( $componentClass, $mainHtml ) {
		$template = $this->createStub(ChameleonTemplate::class);
		$template->method( 'get' )->willReturnMap([[ 'bodytext', null, $mainHtml ]]);
		$template->method( 'getMsg' )->willReturn( new Message( '' ) );
		$component = new $componentClass( $template );
		return $component;
	}

}
