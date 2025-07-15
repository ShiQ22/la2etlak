<?php
	$authUser = auth()->check() ? auth()->user() : null;
	$isLoggedUser = !empty($authUser) ? 'true' : 'false';
	$isLoggedAdmin = doesUserHavePermission($authUser, \App\Models\Permission::getStaffPermissions()) ? 'true' : 'false';
?>
<script>
	
	var siteUrl = '<?php echo e(url('/')); ?>';
	var languageCode = '<?php echo e(config('app.locale')); ?>';
	var isLoggedUser = <?php echo e($isLoggedUser); ?>;
	var isLoggedAdmin = <?php echo e($isLoggedAdmin); ?>;
	var isAdminPanel = <?php echo e(isAdminPanel() ? 'true' : 'false'); ?>;
	var demoMode = <?php echo e(isDemoDomain() ? 'true' : 'false'); ?>;
	var demoMessage = '<?php echo e(addcslashes(t('demo_mode_message'), "'")); ?>';
	
	
	var cookieParams = {
		expires: <?php echo e((int)config('settings.other.cookie_expiration')); ?>,
		path: "<?php echo e(config('session.path', '/')); ?>",
		domain: "<?php echo e(!empty(config('session.domain')) ? config('session.domain') : getCookieDomain()); ?>", 
		secure: <?php echo e(config('session.secure') ? 'true' : 'false'); ?>,
		sameSite: "<?php echo e(config('session.same_site')); ?>"
	};
	
	
	var langLayout = {
		loading: "<?php echo e(t('loading_wd')); ?>",
		errorFound: "<?php echo e(t('error_found')); ?>",
		refresh: "<?php echo e(t('refresh')); ?>",
		confirm: {
			button: {
				yes: "<?php echo e(t('confirm_button_yes')); ?>",
				no: "<?php echo e(t('confirm_button_no')); ?>",
				ok: "<?php echo e(t('confirm_button_ok')); ?>",
				cancel: "<?php echo e(t('confirm_button_cancel')); ?>"
			},
			message: {
				question: "<?php echo e(t('confirm_message_question')); ?>",
				success: "<?php echo e(t('confirm_message_success')); ?>",
				error: "<?php echo e(t('confirm_message_error')); ?>",
				errorAbort: "<?php echo e(t('confirm_message_error_abort')); ?>",
				cancel: "<?php echo e(t('confirm_message_cancel')); ?>"
			}
		},
		waitingDialog: {
			loading: {
				title: "<?php echo e(t('waitingDialog_loading_title')); ?>",
				text: "<?php echo e(t('waitingDialog_loading_text')); ?>"
			},
			complete: {
				title: "<?php echo e(t('waitingDialog_complete_title')); ?>",
				text: "<?php echo e(t('waitingDialog_complete_text')); ?>"
			}
		},
		hideMaxListItems: {
			moreText: "<?php echo e(t('View More')); ?>",
			lessText: "<?php echo e(t('View Less')); ?>"
		},
		select2: {
			errorLoading: function () {
				return "<?php echo t('The results could not be loaded'); ?>"
			},
			inputTooLong: function (e) {
				let t = e.input.length - e.maximum, n = "<?php echo t('Please delete X character'); ?>";
				n = n.replace('{charsLength}', t.toString());
				
				return t != 1 && (n += 's'), n
			},
			inputTooShort: function (e) {
				let t = e.minimum - e.input.length, n = "<?php echo t('Please enter X or more characters'); ?>";
				n = n.replace('{minCharsLength}', t.toString());
				
				return n
			},
			loadingMore: function () {
				return "<?php echo t('Loading more results'); ?>"
			},
			maximumSelected: function (e) {
				let maxItems = e.maximum;
				let t = "<?php echo t('You can only select N item'); ?>";
				t = t.replace('{maxItems}', maxItems.toString());
				
				return maxItems != 1 && (t += 's'), t
			},
			noResults: function () {
				return "<?php echo t('no_results'); ?>"
			},
			searching: function () {
				return "<?php echo t('Searching'); ?>"
			}
		},
		themePreference: {
			light: "<?php echo e(t('theme_preference_light')); ?>",
			dark: "<?php echo e(t('theme_preference_dark')); ?>",
			system: "<?php echo e(t('theme_preference_system')); ?>",
			success: "<?php echo e(t('theme_preference_success')); ?>",
			empty: "<?php echo e(t('theme_preference_empty')); ?>",
			error: "<?php echo e(t('theme_preference_error')); ?>",
		},
		location: {
			area: "<?php echo e(t('area')); ?>"
		},
		autoComplete: {
			searchCities: "<?php echo e(t('search_cities')); ?>",
			enterMinimumChars: (threshold) => `<?php echo e(t('enter_minimum_chars')); ?>`,
			noResultsFor: (query) => {
				query = `<strong>${query}</strong>`;
				return `<?php echo e(t('no_results_for')); ?>`
			},
		},
		payment: {
			submitBtnLabel: {
				pay: "<?php echo e(t('Pay')); ?>",
				submit: "<?php echo e(t('submit')); ?>",
			},
		},
		unsavedFormGuard: {
			error_form_not_found: "<?php echo e(t('unsaved_form_guard.error_form_not_found')); ?>",
			unsaved_changes_prompt: "<?php echo e(t('unsaved_form_guard.unsaved_changes_prompt')); ?>",
		},
	};
	
	const formValidateOptions = {
		formErrorMessage: "<?php echo e(t('formValidation.formErrorMessage')); ?>",
		defaultErrors: {
			required: "<?php echo e(t('formValidation.defaultErrors.required')); ?>",
			validator: "<?php echo e(t('formValidation.defaultErrors.validator')); ?>",
		},
		errors: {
			alphanumeric: "<?php echo e(t('formValidation.errors.alphanumeric')); ?>",
			numeric: "<?php echo e(t('formValidation.errors.numeric')); ?>",
			email: "<?php echo e(t('formValidation.errors.email')); ?>",
			url: "<?php echo e(t('formValidation.errors.url')); ?>",
			username: "<?php echo e(t('formValidation.errors.username')); ?>",
			password: "<?php echo e(t('formValidation.errors.password')); ?>",
			date: "<?php echo e(t('formValidation.errors.date')); ?>",
			time: "<?php echo e(t('formValidation.errors.time')); ?>",
			cardExpiry: "<?php echo e(t('formValidation.errors.cardExpiry')); ?>",
			cardCvc: "<?php echo e(t('formValidation.errors.cardCvc')); ?>",
		},
	};
</script>
<?php /**PATH C:\xampp\htdocs\resources\views/front/common/js/init.blade.php ENDPATH**/ ?>