module.exports = function toggleShowAllFields() {

	const togglingTemplate = '.form-template-wrapper .hideEmptyFields';
	const toggleSwitchContainer = '.panel-heading';
	const templateRow = '.sfFieldRow';
	const hiddenRowClass = 'hiddenFieldRow';

	const skipRowClasses = ['mandatoryInput', 'recommendedInput'];
	const skipInputTypes = ['radio', 'checkbox'];

	/*  Template structure
		-----------------------------------------------------------
		.form-template-wrapper
			div[.hideEmptyFields]
				.panel-heading
					.oo-ui-toggleSwitchWidget
				.panel-body
					.sfFieldRow [recommendedInput mandatoryInput]
						.sfFieldContent
							:input
	 */

	$(togglingTemplate).each((_, template) => {
		const $template = $(template);
		addToggleSwitch($template);
		changeVisibility($template, false);
	});

	function addToggleSwitch($template) {
		$template.children(toggleSwitchContainer).append(createToggleSwitch());

		function createToggleSwitch() {
			const toggleSwitch = new OO.ui.ToggleSwitchWidget({value: false});
			toggleSwitch.on('change', value => changeVisibility($template, value));

			const fieldlayout = new OO.ui.FieldLayout(toggleSwitch, {
				label: mw.message('scs-hide-show-empty-input-fields').text(),
				align: 'left',
				classes: ['floatRightOOUIFieldSet']
			});
			return fieldlayout.$element;
		}
	}

	function changeVisibility($template, visible) {
		const hide = $row => $row.addClass(hiddenRowClass);
		const show = $row => $row.removeClass(hiddenRowClass);

		const $inputs = $template.find(':input');
		$inputs.each((_, input) => {
			const $input = $(input);
			const $row = $input.closest(templateRow);

			if (visible) {
				show($row);
			} else {
				if ( skipRowClasses.find(c => $row.hasClass(c)) || skipInputTypes.includes($input.attr('type')) )
					return;

				// rows with empty input (inputField.attr('name') != "" is required for Datepicker)
				const isEmptyInput = $input.val() === "" && ($input.attr('name') || '') !== '';
				// MultiValue select, e.g. "Related To Epic"
				const isMultiValueSelect = $input.hasClass('createboxInput') && $input.is('select')
					&& ($input.children().length === 0 || ($input.children().length === 1 && $input.children().html() === ""))

				if (isEmptyInput || isMultiValueSelect)
					hide($row);
			}
		});
	}
};
