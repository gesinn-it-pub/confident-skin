<?php

namespace ConfIDentSkin;

use DOMDocument;
use DOMNode;

class DomHelpers {

	public static function cutElements( string $source, callable $predicate
	): array {
		$sourceNode = self::load( $source );
		$targetNode = self::load();

		$toCut = iterator_to_array(self::filter( $sourceNode, $predicate ), false);
		foreach ( $toCut as $cut ) {
			$cut->parentNode->removeChild($cut);
			self::append( $cut, $targetNode );
		}

		return [self::save( $sourceNode ), self::save( $targetNode )];
	}

	private static function filter( DOMNode $n, $predicate ): \Generator {
		if ( $predicate( $n ) ) {
			yield $n;
		} else {
			foreach ( $n->childNodes as $c )
				yield from self::filter( $c, $predicate );
		}
	}

	private static function load( string $source = null ): DOMNode {
		$source ??= '<body>';
		$doc = new DOMDocument();
		$doc->loadHTML('<?xml encoding="utf-8"?>' . $source, LIBXML_NOERROR);
		return $doc->getElementsByTagName( 'body' )->item( 0 );
	}

	private static function save( DOMNode $node ): string {
		$result = $node->ownerDocument->saveHTML( $node );
		return preg_match( '/^<body>.*<\/body>$/s', $result )
			? substr( $result, 6, -7 )
			: $result;
	}

	private static function append( $child, $target ) {
		$target->appendChild( $target->ownerDocument->importNode( $child, true ) );
	}

}
