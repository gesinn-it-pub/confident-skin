const resetDom = createDom();
prepareMediaWiki();
const sinon = require('sinon');

QUnit.hooks.beforeEach(assert => {
	sinon.assert.pass = message =>
		assert.pushResult({ result: true, expected: true, actual: true, message });
	sinon.assert.fail = message =>
		assert.pushResult({ result: false, expected: true, actual: false, message });
});

QUnit.hooks.afterEach(() => {
	resetDom();
	sinon.restore();
});

/**
 * first attempt to provide a clean environment for each test
 *
 * @return {(function(): void)|*} a function to reset the DOM between tests
 */
function createDom() {
	// required by jsdom
	const { TextEncoder, TextDecoder } = require('util');
	global.TextEncoder = TextEncoder;
	global.TextDecoder = TextDecoder;

	const { JSDOM } = require('jsdom');
	const dom = new JSDOM();
	global.window = dom.window;
	global.document = window.document;
	global.Node = window.Node;
	global.$ = global.jQuery = require('../../../../resources/lib/jquery/jquery.js');

	return () => {
		global.document.body.innerHTML = '';
	};
}

/**
 * setup MediaWiki globals: OO, mw, ...
 */
function prepareMediaWiki() {
	global.OO = require('../../../../resources/lib/oojs/oojs.jquery.js');
	require('../../../../resources/lib/ooui/oojs-ui-core.js');
	require('../../../../resources/lib/ooui/oojs-ui-widgets.js');
	require('../../../../resources/lib/ooui/oojs-ui-wikimediaui');

	global.mw = global.mediaWiki = {
		message: () => ({
			text: () => {}
		})
	};
}
