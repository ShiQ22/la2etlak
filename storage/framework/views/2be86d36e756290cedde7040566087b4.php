<script>
	onDocumentReady((event) => {
		let displayModeEl = document.querySelector("select[name=display_mode].select2_from_array");
		if (displayModeEl) {
			getDisplayModeFields(displayModeEl);
			$(displayModeEl).on("change", e => getDisplayModeFields(e.target));
		}
		
		let hideDateEl = document.querySelector("input[type=checkbox][name=hide_date]");
		if (hideDateEl) {
			toggleDateFields(hideDateEl);
			hideDateEl.addEventListener("change", e => toggleDateFields(e.target));
		}
		
		let extendedSearchesEl = document.querySelector("input[type=checkbox][name=cities_extended_searches]");
		if (extendedSearchesEl) {
			toggleExtendedSearchesFields(extendedSearchesEl);
			extendedSearchesEl.addEventListener("change", e => toggleExtendedSearchesFields(e.target));
		}
	});
	
	function getDisplayModeFields(displayModeEl) {
		setElementsVisibility("hide", ".grid-view");
		if (displayModeEl.value === "grid-view") {
			setElementsVisibility("show", ".grid-view");
		}
	}
	
	function toggleDateFields(hideDateEl) {
		let action = !hideDateEl.checked ? "show" : "hide";
		setElementsVisibility(action, ".date-field");
	}
	
	function toggleExtendedSearchesFields(extendedSearchesEl) {
		let action = extendedSearchesEl.checked ? "show" : "hide";
		setElementsVisibility(action, ".extended-searches");
	}
</script>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/js/setting/listings-list.blade.php ENDPATH**/ ?>