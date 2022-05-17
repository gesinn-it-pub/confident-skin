module.exports = {

	click: selector =>
		$(selector).trigger($.Event('click', { which: OO.ui.MouseButtons.LEFT }))

}
