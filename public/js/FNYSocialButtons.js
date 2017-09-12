function FNYSocialButtons() {
	this.selectedButtons = [];
}

FNYSocialButtons.prototype.addToSelected = function(elementId) {
	this.selectedButtons.push(elementId);
}

FNYSocialButtons.prototype.getSelectedButtons = function() {
	return this.selectedButtons;
}

FNYSocialButtons.prototype.removeFromSelected = function(index) {
	delete this.selectedButtons[index];
}
