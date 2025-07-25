<?php $__env->startSection('wizard'); ?>
	<?php echo $__env->make('front.post.createOrEdit.multiSteps.partials.wizard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php
	$postInput ??= [];
	$cityId = (int)data_get($postInput, 'city_id', 0);
	$cityName = data_get($postInput, 'city_name', '--');
	
	$postTypes ??= [];
	$countries ??= [];
	
	// Get steps URLs & labels
	$previousStepUrl ??= null;
	$previousStepLabel ??= null;
	$formActionUrl ??= request()->fullUrl();
	$nextStepUrl ??= '/';
	$nextStepLabel ??= t('submit') . ' <i class="bi bi-chevron-right"></i>';
?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('front.common.spacer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				<?php echo $__env->make('front.post.partials.notification', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				
				<div class="col-md-9">
					<div class="container border rounded bg-body-tertiary p-4 p-lg-3 p-md-2 mb-sm-3">
						<h3 class="fw-bold border-bottom pb-3 mb-4">
							<i class="fa-regular fa-pen-to-square"></i> <?php echo e(t('create_new_listing')); ?>

						</h3>
						
						<div class="row d-flex justify-content-center">
							<div class="col-md-10 col-sm-12 col-xs-12">
								
								<form id="payableForm"
								      action="<?php echo e($formActionUrl); ?>"
								      method="POST"
								      enctype="multipart/form-data"
								      class="<?php echo e(unsavedFormGuard()); ?>"
								>
									<?php echo csrf_field(); ?>
									<?php echo view('honeypot::honeypot'); ?>
									
									
   									 <input type="hidden" name="type" value="<?php echo e($type); ?>">
									<fieldset>
										
										
										<?php
											$categoryIdError = (isset($errors) && $errors->has('category_id')) ? ' is-invalid' : '';
											$catSelectionUrl = url('browsing/categories/select');
											
											$categoryId = old('category_id', data_get($postInput, 'category_id', 0));
											$categoryType = old('category_type', data_get($postInput, 'category_type'));
											
											$aModal = 'data-bs-toggle="modal"';
											$aHref = 'href="#browseCategories"';
											$aDataUrl = 'data-selection-url="' . $catSelectionUrl . '"';
											$aClass = 'class="modal-cat-link open-selection-url ' . linkClass() . '"';
											
											$customHtml = '<div id="catsContainer" class="form-control' . $categoryIdError . '">';
											$customHtml .= "<a {$aHref} {$aModal} {$aDataUrl} {$aClass}>";
											$customHtml .= t('select_a_category');
											$customHtml .= '</a>';
											$customHtml .= '</div>';
											$customHtml .= '<input type="hidden" name="category_id" id="categoryId" value="' . $categoryId . '">';
											$customHtml .= '<input type="hidden" name="category_type" id="categoryType" value="' . $categoryType . '">';
										?>
										<?php echo $__env->make('helpers.forms.fields.html', [
											'label'    => t('category'),
											'name'     => 'category_id', // <label for="name">
											'required' => true,
											'value'    => $customHtml,
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
										<?php if(config('settings.listing_form.show_listing_type')): ?>
											<?php echo $__env->make('helpers.forms.fields.radio', [
												'label'           => t('type'),
												'id'              => 'postTypeId-',
												'name'            => 'post_type_id',
												'inline'          => true,
												'required'        => true,
												'options'         => $postTypes,
												'optionValueName' => 'id',
												'optionTextName'  => 'label',
												'value'           => data_get($postInput, 'post_type_id'),
												'hint'            => t('post_type_hint'),
												'wrapper'         => ['id' => 'postTypeBloc'],
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										<?php endif; ?>
										
										
										<?php echo $__env->make('helpers.forms.fields.text', [
											'label'       => t('title'),
											'name'        => 'title',
											'placeholder' => t('enter_your_title'),
											'required'    => true,
											'value'       => data_get($postInput, 'title'),
											'hint'        => t('a_great_title_needs_at_least_60_characters'),
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
										<?php echo $__env->make('helpers.forms.fields.wysiwyg', [
											'label'       => t('Description'),
											'name'        => 'description',
											'placeholder' => t('enter_your_message'),
											'required'    => true,
											'value'       => data_get($postInput, 'description'),
											'height'      => 350,
											'attributes'  => ['rows' => 15],
											'hint'        => t('describe_what_makes_your_listing_unique'),
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
										<div id="cfContainer"></div>
										
										
										
										
										<?php
											$countryCodeOptions = collect($countries)
												->map(function($item) {
													return [
														'value'      => $item['code'] ?? null,
														'text'       => $item['name'] ?? null,
														'attributes' => ['data-admin-type' => $item['admin_type'] ?? 0],
													];
												})->toArray();
											
											$selectedCountryCode = !empty(config('ipCountry.code')) ? config('ipCountry.code') : 0;
											$selectedCountryCode = data_get($postInput, 'country_code', $selectedCountryCode);
										?>
										<?php if(empty(config('country.code'))): ?>
											<?php echo $__env->make('helpers.forms.fields.select2', [
												'label'       => t('your_country'),
												'id'          => 'countryCode',
												'name'        => 'country_code',
												'required'    => true,
												'placeholder' => t('select_a_country'),
												'options'     => $countryCodeOptions,
												'value'       => $selectedCountryCode,
												'hint'        => null,
												'baseClass'   => ['wrapper' => 'mb-3 col-md-8'],
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										<?php else: ?>
											<input id="countryCode" name="country_code" type="hidden" value="<?php echo e(config('country.code')); ?>">
										<?php endif; ?>
										
										<?php
											$adminType = config('country.admin_type', 0);
										?>
										<?php if(config('settings.listing_form.city_selection') == 'select'): ?>
											<?php if(in_array($adminType, ['1', '2'])): ?>
												
												<?php echo $__env->make('helpers.forms.fields.select2', [
													'label'        => t('location'),
													'id'           => 'adminCode',
													'name'         => 'admin_code',
													'required'     => true,
													'placeholder'  => t('select_your_location'),
													'options'      => [],
													'largeOptions' => true,
													'hint'         => null,
													'baseClass'    => ['wrapper' => 'mb-3 col-md-8'],
													'wrapper'      => ['id' => 'locationBox'],
												], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
											<?php endif; ?>
										<?php else: ?>
											<?php
												$adminType = data_get($postInput, 'admin_type', $adminType);
												$adminCode = data_get($postInput, 'admin_code', 0);
												$cityId = (int)data_get($postInput, 'city_id', 0);
												$cityName = data_get($postInput, 'city_name', '--');
											?>
											<input type="hidden"
											       id="selectedAdminType"
											       name="selected_admin_type"
											       value="<?php echo e(old('selected_admin_type', $adminType)); ?>"
											>
											<input type="hidden"
											       id="selectedAdminCode"
											       name="selected_admin_code"
											       value="<?php echo e(old('selected_admin_code', $adminCode)); ?>"
											>
											<input type="hidden"
											       id="selectedCityId"
											       name="selected_city_id"
											       value="<?php echo e(old('selected_city_id', $cityId)); ?>"
											>
											<input type="hidden"
											       id="selectedCityName"
											       name="selected_city_name"
											       value="<?php echo e(old('selected_city_name', $cityName)); ?>"
											>
										<?php endif; ?>
										
										
										<?php echo $__env->make('helpers.forms.fields.select2', [
											'label'        => t('city'),
											'id'           => 'cityId',
											'name'         => 'city_id',
											'required'     => true,
											'placeholder'  => t('select_a_city'),
											'options'      => [],
											'largeOptions' => true,
											'hint'         => null,
											'baseClass'    => ['wrapper' => 'mb-3 col-md-8'],
											'wrapper'      => ['id' => 'cityBox'],
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
										<?php
											$tagHint = t('tags_hint', ['limit' => '{limit}', 'min' => '{min}', 'max' => '{max}']);
										?>
										<?php echo $__env->make('helpers.forms.fields.select2-tagging', [
											'label'       => t('Tags'),
											'id'          => 'tags',
											'name'        => 'tags',
											'placeholder' => t('enter_tags'),
											'options'     => data_get($postInput, 'tags'),
											'hint'        => $tagHint,
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
										<?php if(config('settings.listing_form.permanent_listings_enabled') == '3'): ?>
											<input type="hidden" name="is_permanent" id="isPermanent" value="0">
										<?php else: ?>
											<?php echo $__env->make('helpers.forms.fields.checkbox', [
												'label'    => t('is_permanent_label'),
												'id'       => 'isPermanent',
												'name'     => 'is_permanent',
												'switch'   => true,
												'required' => false,
												'value'    => data_get($postInput, 'is_permanent'),
												'hint'     => t('is_permanent_hint'),
												'wrapper'  => ['id' => 'isPermanentBox', 'class' => 'hide']
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										<?php endif; ?>
										
										
										<div class="col-12 fw-bold fs-5 border-bottom py-2 my-5 mb-4">
											<i class="bi bi-person-circle"></i> <?php echo e(t('seller_information')); ?>

										</div>
										
										
										
										<?php if(auth()->check()): ?>
											<input id="contactName" name="contact_name" type="hidden" value="<?php echo e(auth()->user()->name ?? null); ?>">
										<?php else: ?>
											<?php echo $__env->make('helpers.forms.fields.text', [
												'label'       => t('your_name'),
												'id'          => 'contactName',
												'name'        => 'contact_name',
												'placeholder' => t('enter_your_name'),
												'required'    => true,
												'value'       => data_get($postInput, 'contact_name'),
												'prefix'      => '<i class="fa-regular fa-user"></i>',
												'suffix'      => null,
												'baseClass'   => ['wrapper' => 'mb-3 col-md-8'],
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										<?php endif; ?>
										
										
										<?php
											$authFields = getAuthFields(true);
											$authFieldOptions = collect($authFields)
												->map(fn($item, $key) => ['value' => $key, 'text' => $item])
												->toArray();
											
											$usersCanChooseNotifyChannel = isUsersCanChooseNotifyChannel();
											$authFieldValue = data_get($postInput, 'auth_field') ?? getAuthField();
											$authFieldValue = $usersCanChooseNotifyChannel ? old('auth_field', $authFieldValue) : $authFieldValue;
										?>
										<?php if($usersCanChooseNotifyChannel): ?>
											<?php echo $__env->make('helpers.forms.fields.radio', [
												'label'      => trans('auth.notifications_channel'),
												'btnVariant' => 'secondary',
												'btnOutline' => true,
												'id'         => 'authField-',
												'name'       => 'auth_field',
												'inline'     => true,
												'required'   => true,
												'options'    => $authFieldOptions,
												'value'      => $authFieldValue,
												'attributes' => ['class' => 'auth-field-input'],
												'hint'       => trans('auth.notifications_channel_hint'),
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										<?php else: ?>
											<input id="authField-<?php echo e($authFieldValue); ?>" name="auth_field" type="hidden" value="<?php echo e($authFieldValue); ?>">
										<?php endif; ?>
										
										<?php
											$forceToDisplay = isBothAuthFieldsCanBeDisplayed() ? ' force-to-display' : '';
										?>
										
										
										<?php
											$emailValue = (auth()->check() && isset(auth()->user()->email))
												? auth()->user()->email
												: data_get($postInput, 'email');
										?>
										<?php echo $__env->make('helpers.forms.fields.email', [
											'label'       => trans('auth.email'),
											'id'          => 'email',
											'name'        => 'email',
											'required'    => (getAuthField() == 'email'),
											'placeholder' => t('enter_your_email'),
											'value'       => $emailValue,
											'prefix'      => '<i class="fa-regular fa-envelope"></i>',
											'suffix'      => null,
											'baseClass'   => ['wrapper' => 'mb-3 col-md-8'],
											'wrapper'     => ['class' => "auth-field-item{$forceToDisplay}"],
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
										<?php
											$phoneValue = data_get($postInput, 'phone');
											$phoneCountryValue = data_get($postInput, 'phone_country', config('country.code'));
											if (
												auth()->check()
												&& isset(auth()->user()->country_code)
												&& !empty(auth()->user()->phone)
												&& isset(auth()->user()->phone_country)
											) {
												$phoneValue = auth()->user()->phone;
												$phoneCountryValue = auth()->user()->phone_country;
											}
											
											// phone_hidden
											$phoneHiddenValue = old('phone_hidden', data_get($postInput, 'phone_hidden'));
											$phoneHiddenChecked = ($phoneHiddenValue == '1') ? ' checked' : '';
											$suffix = '<input id="phoneHidden" name="phone_hidden" type="checkbox" value="1"' . $phoneHiddenChecked . '>';
											$suffix .= '&nbsp;<small>' . t('Hide') . '</small>';
										?>
										<?php echo $__env->make('helpers.forms.fields.intl-tel-input', [
											'label'       => trans('auth.phone_number'),
											'id'          => 'phone',
											'name'        => 'phone',
											'required'    => (getAuthField() == 'phone'),
											'placeholder' => null,
											'value'       => $phoneValue,
											'countryCode' => $phoneCountryValue,
											'suffix'      => $suffix,
											'baseClass'   => ['wrapper' => 'mb-3 col-md-8'],
											'wrapper'     => ['class' => "auth-field-item{$forceToDisplay}"],
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
										<?php if(!auth()->check()): ?>
											<?php if(in_array(config('settings.listing_form.auto_registration'), [1, 2])): ?>
												<?php if(config('settings.listing_form.auto_registration') == 1): ?>
													<?php echo $__env->make('helpers.forms.fields.checkbox', [
														'label'    => t('I want to register by submitting this listing'),
														'name'     => 'auto_registration',
														'required' => false,
														'value'    => 1,
														'hint'     => t('You will receive your authentication information by email'),
													], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
												<?php else: ?>
													<input type="hidden" name="auto_registration" id="auto_registration" value="1">
												<?php endif; ?>
											<?php endif; ?>
										<?php endif; ?>
										
										
										<?php echo $__env->make('helpers.forms.fields.captcha', ['label' => trans('auth.captcha_human_verification')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										<?php if(!auth()->check()): ?>
											
											<?php echo $__env->make('helpers.forms.fields.checkbox', [
												'label'     => t('accept_terms_label', ['attributes' => getUrlPageByType('terms')]),
												'id'        => 'acceptTerms',
												'name'      => 'accept_terms',
												'required'  => true,
												'value'     => data_get($postInput, 'accept_terms'),
												'baseClass' => ['wrapper' => 'mb-1 col-md-12'],
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
											
											
											<?php echo $__env->make('helpers.forms.fields.checkbox', [
												'label'    => t('accept_marketing_offers_label'),
												'id'       => 'acceptMarketingOffers',
												'name'     => 'accept_marketing_offers',
												'required' => false,
												'value'    => data_get($postInput, 'accept_marketing_offers'),
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										<?php endif; ?>
										
										
										<div class="row mb-3 mt-5">
											<div class="col-md-6 mb-md-0 mb-2 text-start d-grid">
												<a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary btn-lg">
													<?php echo e(t('Cancel')); ?>

												</a>
											</div>
											<div class="col-md-6 mb-md-0 mb-2 text-end d-grid">
												<button id="nextStepBtn" class="btn btn-primary btn-lg">
													<?php echo $nextStepLabel; ?>

												</button>
											</div>
										</div>
									
									</fieldset>
								</form>
							
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-3 reg-sidebar">
					<?php echo $__env->make('front.post.createOrEdit.partials.right-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				</div>
			
			</div>
		</div>
	</div>
	<?php echo $__env->make('front.post.createOrEdit.partials.category-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<?php echo $__env->renderWhen(!auth()->check(), 'auth.login.partials.modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.post.createOrEdit.partials.form-assets', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/front/post/createOrEdit/multiSteps/create/post.blade.php ENDPATH**/ ?>