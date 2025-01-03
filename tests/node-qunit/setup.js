const fs = require('fs');
const path = require('path');
const resetDom = createDom();
const sinon = require('sinon');

// Define paths for both versions
const oojsJqueryPath = path.resolve(__dirname, '../../../../resources/lib/oojs/oojs.jquery.js');
const oojsPath = path.resolve(__dirname, '../../../../resources/lib/oojs/oojs.js');

QUnit.hooks.beforeEach(assert => {
	sinon.assert.pass = message =>
		assert.pushResult({ result: true, expected: true, actual: true, message });
	sinon.assert.fail = message =>
		assert.pushResult({ result: false, expected: true, actual: false, message });
});

prepareMediaWiki();

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
	global.HTMLElement = dom.window.HTMLElement;
	global.customElements = dom.window.customElements;
	global.$ = global.jQuery = require('../../../../resources/lib/jquery/jquery.js');

	return () => {
		global.document.body.innerHTML = '';
	};
}

/**
 * setup MediaWiki globals: OO, mw, ...
 */
function prepareMediaWiki() {
	// Check if oojs.js exists (for MW 1.39+), otherwise use oojs.jquery.js (for MW 1.35)
	if (fs.existsSync(oojsPath)) {
		global.OO = require(oojsPath);
	} else if (fs.existsSync(oojsJqueryPath)) {
		global.OO = require(oojsJqueryPath);
	} else {
		throw new Error('Neither oojs.js nor oojs.jquery.js could be found.');
	}
	require('../../../../resources/lib/ooui/oojs-ui-core.js');
	require('../../../../resources/lib/ooui/oojs-ui-widgets.js');
	require('../../../../resources/lib/ooui/oojs-ui-wikimediaui');

	global.mw = global.mediaWiki = {
		message: () => ({
			text: () => {}
		})
	};
}
