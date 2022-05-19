QUnit.module('init');

QUnit.test('is loadable', assert => {
	require("../../resources/js/init");
	assert.ok(1);
});
