<?php
	$packages ??= collect();
	$paymentMethods ??= collect();
	
	$selectedPackage ??= null;
	$currentPackagePrice = $selectedPackage->price ?? 0;
?>
<?php if($packages->count() > 0 && $paymentMethods->count() > 0): ?>
	
	<script>
		
		const packagesRowElsSelector = '#packagesTable tbody tr:not(:last-child)';
		const packagesElsSelector = '#packagesTable input[type="radio"][name="package_id"]';
		
		var currentPackagePrice = <?php echo e($currentPackagePrice ?? 0); ?>;
		var paymentIsActive = <?php echo e($paymentIsActive ?? 0); ?>;
		var forceDisplayPaymentMethods = <?php echo e(!empty($selectedPackage) ? 'true' : 'false'); ?>;
		
		const submitBtnLabel = {
			pay: langLayout.payment.submitBtnLabel.pay ?? 'Pay',
			submit: langLayout.payment.submitBtnLabel.submit ?? 'Submit',
		};
		
		onDocumentReady((event) => {
			
			const selectedPackageEl = document.querySelector(packagesElsSelector + ':checked');
			const paymentMethodEl = document.getElementById('paymentMethodId');
			
			if (!selectedPackageEl || !paymentMethodEl) {
				if (packageType === 'promotion') {
					if (!selectedPackageEl) {
						if (urlQuery().hasParameter('package')) {
							let urlWithoutPackage = urlQuery().removeParameter('package').toString();
							redirect(urlWithoutPackage);
						}
					}
				}
				return false;
			}
			
			
			let selectedPackage = selectedPackageEl.value;
			let packagePrice = getPackagePrice(selectedPackage);
			let packageCurrencySymbol = selectedPackageEl.dataset.currencySymbol;
			let packageCurrencyInLeft = selectedPackageEl.dataset.currencyInLeft;
			
			
			let paymentMethodSelectedOption = paymentMethodEl.options[paymentMethodEl.selectedIndex];
			let paymentMethod = paymentMethodSelectedOption.dataset.name;
			
			showPaymentMethods(packagePrice, forceDisplayPaymentMethods);
			showAmount(packagePrice, packageCurrencySymbol, packageCurrencyInLeft);
			if (formType === 'multiStep') {
				showPaymentSubmitButton(currentPackagePrice, packagePrice, paymentIsActive, paymentMethod, isCreationFormPage);
			}
			
			
			const packagesRowEls = document.querySelectorAll(`${packagesElsSelector}, ${packagesRowElsSelector}`);
			if (packagesRowEls.length > 0) {
				packagesRowEls.forEach((element) => {
					element.style.cursor = 'pointer';
					element.addEventListener('click', (e) => {
						let thisEl = e.target;
						
						thisEl = selectPackageRadioButton(thisEl);
						if (!thisEl) return;
						
						selectedPackage = thisEl.value;
						packagePrice = getPackagePrice(selectedPackage);
						packageCurrencySymbol = thisEl.dataset.currencySymbol;
						packageCurrencyInLeft = thisEl.dataset.currencyInLeft;
						
						showPaymentMethods(packagePrice);
						showAmount(packagePrice, packageCurrencySymbol, packageCurrencyInLeft);
						if (formType === 'multiStep') {
							showPaymentSubmitButton(currentPackagePrice, packagePrice, paymentIsActive, paymentMethod, isCreationFormPage);
						}
					});
				});
			}
			
			
			$(paymentMethodEl).on('change', (e) => {
				let selectedOption = paymentMethodEl.options[paymentMethodEl.selectedIndex];
				paymentMethod = selectedOption.dataset.name;
				
				if (formType === 'multiStep') {
					showPaymentSubmitButton(currentPackagePrice, packagePrice, paymentIsActive, paymentMethod, isCreationFormPage);
				}
			});
			
			
			const formSubmitBtnEl = document.getElementById('payableFormSubmitButton');
			if (formSubmitBtnEl) {
				formSubmitBtnEl.addEventListener('click', (e) => {
					e.preventDefault();
					
					const formEl = document.getElementById('payableForm');
					if (formEl && packagePrice <= 0) {
						formEl.submit();
					}
					
					return false;
				});
			}
			
		});
		
	</script>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/common/js/payment-js.blade.php ENDPATH**/ ?>