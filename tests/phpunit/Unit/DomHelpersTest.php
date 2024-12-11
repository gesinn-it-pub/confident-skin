<?php

namespace ConfIDentSkin;

use PHPUnit\Framework\TestCase;

class DomHelpersTest extends TestCase {

	/**
	 * @covers ConfIDentSkin\DomHelpers::cutElements
	 *
	 * @dataProvider provideCutElementsData
	 */
	public function testCutElements( $source, $expectedRest, $expectedCut ): void {
		$predicate = fn( \DOMNode $n ) => $n->hasAttributes() && $n->getAttribute( 'class' ) === 'x';

		[ $rest, $cut ] = DomHelpers::cutElements( $source, $predicate );

		$this->assertEquals( $expectedRest, $rest );
		$this->assertEquals( $expectedCut, $cut );
	}

	public static function provideCutElementsData() {
		return [
			'rest empty if no matching elements' => [
				'<div class="source"><p>foo</p></div>',
				'<div class="source"><p>foo</p></div>',
				''
			],
			'cuts single element' => [
				'<div class="source"><p>foo</p><p class="x">bar</p></div>',
				'<div class="source"><p>foo</p></div>',
				'<p class="x">bar</p>'
				],
			'cuts multiple elements' => [
				'<div class="source"><p class="x">bar 1</p><p>foo</p><p class="x">bar 2</p></div>',
				'<div class="source"><p>foo</p></div>',
				'<p class="x">bar 1</p><p class="x">bar 2</p>'
			],
			'cuts keeping whitespace' => [
				'<div class="source"> <p> foo </p> <p class="x"> bar '."\n\r\t".'</p> '."\n\r\t".'</div>',
				'<div class="source"> <p> foo </p>  '."\n\r\t".'</div>',
				'<p class="x"> bar '."\n\r\t".'</p>',
			],
			'invalid tags are tolerated' => [
				'<div><invalid1></invalid1><invalid2 class="x"></invalid2></div>',
				'<div><invalid1></invalid1></div>',
				'<invalid2 class="x"></invalid2>'
			],
			'invalid structure is tolerated' => [
				'<div><div><div class="x">x<h1>h</a>',
				'<div><div></div></div>',
				'<div class="x">x<h1>h</h1></div>'
			]
		];
	}
}
