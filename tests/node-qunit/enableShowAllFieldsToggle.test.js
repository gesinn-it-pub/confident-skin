const enableShowAllFieldsToggle = require('../../resources/js/enableShowAllFieldsToggle');
const ui = require('./ui-helpers');

QUnit.module('enableShowAllFieldsToggle', { beforeEach: beforeEach });

const classes = {
	toggleWidget: 'oo-ui-toggleWidget',
	row: 'sfFieldRow',
}

QUnit.test('adds the toggle to all marked headings', assert => {
	$(`
		${template(1, true)}
	    <div>
	      <div>
	      	${template(2, true)}
	      	${template(3, false)}
		  </div>
	    </div>
    `).appendTo(document.body);

	enableShowAllFieldsToggle();

	assert.equal($('#1 .' + classes.toggleWidget).length, 1);
	assert.equal($('#2 .' + classes.toggleWidget).length, 1);
	assert.equal($('#3 .' + classes.toggleWidget).length, 0);
});

const hidden = {
	optional: row(false, '<input name="x">'),
	createboxInputSelectWithoutChildren:
		row(false, '<select class="createboxInput">'),
	createboxInputSelectWithExactlyOneEmptyChild:
		row(false, '<select class="createboxInput"><option></option></select>'),
	optionalInTemplateStarter: `<div class="multipleTemplateStarter">${row(false, '<input name="x">')}</div>`,
}

QUnit.test.each('hidden initially', hidden, (assert, row) => {
	body(template(1, true,[row]));
	enableShowAllFieldsToggle();
	assert.visibility('hidden');
});

QUnit.test.each('visible after first toggle', hidden, (assert, row) => {
	body(template(1, true,[row]));
	enableShowAllFieldsToggle();

	click();

	assert.visibility('visible');
});

QUnit.test.each('hidden after toggling twice', hidden, (assert, row) => {
	body(template(1, true,[row]));
	enableShowAllFieldsToggle();

	click();
	click();

	assert.visibility('hidden');
});


const notHidden = {
	radio: row(false, '<input type="radio" name="x" value="">'),
	checkbox: row(false, '<input type="checkbox" name="x" value="">'),
	recommended: row('recommendedInput', '<input name="x">'),
	mandatory: row('mandatoryInput', '<input name="x">'),
	optionalNotEmpty: row(false, '<input name="x" value="x">'),
	nameless: row(false, '<input value="">'),
};

QUnit.test.each('not hidden initially', notHidden, (assert, row) => {
	body(template(1, true,[row]));
	enableShowAllFieldsToggle();
	assert.visibility('visible');
});

QUnit.test.each('not hidden after toggling once', notHidden, (assert, row) => {
	body(template(1, true,[row]));
	enableShowAllFieldsToggle();

	click();

	assert.visibility('visible');
});

QUnit.test.each('not hidden after toggling twice', notHidden, (assert, row) => {
	body(template(1, true,[row]));
	enableShowAllFieldsToggle();

	click();
	click();

	assert.visibility('visible');
});

function body(elements) {
	const $form = $('<div id="pfForm"></div>');
	$(elements).appendTo($form);
	$form.appendTo(document.body);
}

function template(id, hideEmptyFields = true, rows = []) {
	const idString = `id="${id}"`;
	const hideEmptyFieldsString = hideEmptyFields ? 'class="hideEmptyFields"' : '';
	const rowsString = rows.join("\n", rows);

	return `
	  <div ${idString} class="form-template-wrapper">
		<div ${hideEmptyFieldsString}>
          <div class="panel-heading">heading</div>
		  <div class="panel-body">
		  	${rowsString}
		  </div>
		</div>
	  </div>
	`;
}

function row(additionalClass, input) {
	const mandatoryInput = additionalClass ? additionalClass : '';
	return `
	    <div class="${classes.row} ${mandatoryInput}">
	        ${input}
		</div>
	`;
}

function click(selector = '.oo-ui-toggleSwitchWidget') {
	ui.click(selector);
}

function beforeEach(assert) {
	const hasHiddenClass = s => {
		$s = $(s);
		if ($s.length !== 1)
			throw 'selector ' + s + ' must have exactly one matching element; has ' + $s.length;
		return $(s).hasClass('hiddenFieldRow');
	}
	assert.visibility = function(expected, selector = '.' + classes.row) {
		const visibility = hasHiddenClass(selector) ? 'hidden' : 'visible';
		this.pushResult({
			result: visibility === expected,
			actual: visibility,
			expected: expected
		})
	};
}
