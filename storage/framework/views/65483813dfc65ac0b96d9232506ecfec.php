<?php
	$postTypes ??= [];
	$countries ??= [];
?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('front.common.spacer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				<?php echo $__env->make('front.post.partials.notification', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				
				<div class="col-md-9">
					<div class="container border rounded bg-body-tertiary p-4 p-lg-3 p-md-2 mb-sm-3">
						<h2 class="fw-bold border-bottom pb-3 mb-4">
							<i class="fa-regular fa-pen-to-square"></i> <?php echo e(t('create_new_listing')); ?>

						</h2>
						
						<div class="row d-flex justify-content-center">
							<div class="col-md-10 col-sm-12 col-xs-12">
								
								<form id="payableForm"
								      action="<?php echo e(request()->fullUrl()); ?>"
								      method="POST"
								      enctype="multipart/form-data"
								      class="<?php echo e(unsavedFormGuard()); ?>"
								>
									<?php echo csrf_field(); ?>
									   
   										<input type="hidden" name="type" value="<?php echo e($type); ?>">
									<?php echo view('honeypot::honeypot'); ?>
									
									<fieldset>
										
										
										<?php
											$categoryIdError = (isset($errors) && $errors->has('category_id')) ? ' is-invalid' : '';
											$catSelectionUrl = url('browsing/categories/select');
											
											$categoryId = old('category_id', 0);
											$categoryType = old('category_type');
											
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
												'value'           => null,
												'hint'            => t('post_type_hint'),
												'wrapper'         => ['id' => 'postTypeBloc'],
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										<?php endif; ?>
										
										
										<?php echo $__env->make('helpers.forms.fields.text', [
											'label'       => t('title'),
											'name'        => 'title',
											'placeholder' => t('enter_your_title'),
											'required'    => true,
											'value'       => null,
											'hint'        => t('a_great_title_needs_at_least_60_characters'),
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
										<?php echo $__env->make('helpers.forms.fields.wysiwyg', [
											'label'       => t('Description'),
											'name'        => 'description',
											'placeholder' => t('enter_your_message'),
											'required'    => true,
											'value'       => null,
											'height'      => 350,
											'attributes'  => ['rows' => 15],
											'hint'        => t('describe_what_makes_your_listing_unique'),
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										<?php if(isset($picturesLimit) && is_numeric($picturesLimit) && $picturesLimit > 0): ?>
											
											<?php
												$pictureMultipleSelectionsAllowed = (
													config('settings.listing_form.one_picture_field_for_multiple_selections') == '1'
												);
												$pictures ??= [];
												$picturesRequired = (config('settings.listing_form.picture_mandatory') == '1');
												
												$savedPictures = collect($pictures)
													->map(function ($item) {
														return [
															'key'  => $item['id'] ?? null,
															'path' => $item['file_path'] ?? null,
															'url'  => $item['url']['medium'] ?? null,
														];
													})->toArray();
												
												$picturesHint = t('add_up_to_x_pictures_text', ['pictures_number' => $picturesLimit]);
												$picturesHint .= ' ' . t('file_types', ['file_types' => getAllowedFileFormatsHint('image')]);
											?>
											<?php if($pictureMultipleSelectionsAllowed): ?>
												<?php echo $__env->make('helpers.forms.fields.fileinput', [
													'label'       => t('pictures'),
													'name'        => 'pictures',
													'required'    => $picturesRequired,
													'attributes'  => ['accept' => 'image/*'],
													'value'       => $savedPictures,
													'hint'        => $picturesHint,
													'allowsMultiple'   => true,
													'limit'            => $picturesLimit,
													'pluginOptions'    => [
														'previewFileType'   => 'image',
														'showPreview'       => 'true',
														'dropZoneEnabled'   => 'true',
														'browseOnZoneClick' => 'true',
														'showCaption'       => 'false',
														'uploadUrl'         => '/',
													],
												], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
											<?php else: ?>
												<?php echo $__env->make('helpers.forms.fields.fileinput-multiple', [
													'label'       => t('pictures'),
													'name'        => 'pictures',
													'placeholder' => t('Picture X', ['number' => '{index}']),
													'required'    => $picturesRequired,
													'attributes'  => ['accept' => 'image/*'],
													'value'       => $savedPictures,
													'hint'        => $picturesHint,
													'limit'       => $picturesLimit,
													'pluginOptions'    => [
														'previewFileType' => 'image',
														'showPreview'     => 'true',
													],
												], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
											<?php endif; ?>
										<?php endif; ?>
										
										
										<div id="cfContainer"></div>
										
										
										<?php
											$currencySymbol = config('currency.symbol', 'X');
											$price = old('price');
											$price = \App\Helpers\Common\Num::format($price, 2, '.', '');
											$isPriceMandatory = (config('settings.listing_form.price_mandatory') == '1');
											$priceHint = !$isPriceMandatory ? t('price_hint') : null;
											
											// negotiable
											$negotiable = old('negotiable');
											$negotiableChecked = ($negotiable == '1') ? ' checked' : '';
											
											$priceSuffix = '<input id="negotiable" name="negotiable" type="checkbox" value="1"' . $negotiableChecked . '>';
											$priceSuffix .= '&nbsp;<small>' . t('negotiable') . '</small>';
										?>
										<?php echo $__env->make('helpers.forms.fields.number', [
											'label'       => t('price'),
											'name'        => 'price',
											'required'    => $isPriceMandatory,
											'placeholder' => t('enter_your_price'),
											'value'       => $price,
											'step'        => getInputNumberStep((int)config('currency.decimal_places', 2)),
											'prefix'      => $currencySymbol,
											'suffix'      => $priceSuffix,
											'hint'        => $priceHint,
											'baseClass'   => ['wrapper' => 'mb-3 col-md-8'],
											'wrapper'     => ['id' => 'priceBloc'],
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
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
											<input type="hidden"
											       id="selectedAdminType"
											       name="selected_admin_type"
											       value="<?php echo e(old('selected_admin_type', $adminType)); ?>"
											>
											<input type="hidden"
											       id="selectedAdminCode"
											       name="selected_admin_code"
											       value="<?php echo e(old('selected_admin_code', 0)); ?>"
											>
											<input type="hidden"
											       id="selectedCityId"
											       name="selected_city_id"
											       value="<?php echo e(old('selected_city_id', 0)); ?>"
											>
											<input type="hidden"
											       id="selectedCityName"
											       name="selected_city_name"
											       value="<?php echo e(old('selected_city_name')); ?>"
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
											'options'     => [],
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
												'value'    => null,
												'hint'     => t('is_permanent_hint'),
												'wrapper'  => ['id' => 'isPermanentBox', 'class' => 'hide']
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										<?php endif; ?>
										
										
										<div class="col-12 fw-bold fs-5 border-bottom py-2 my-5 mb-4">
											<i class="bi bi-person-circle"></i> <?php echo e(t('seller_information')); ?>

										</div>
										
										
										
										<?php if(auth()->check()): ?>
											<input id="contactName" name="contact_name" type="hidden" value="<?php echo e(auth()->user()->name); ?>">
										<?php else: ?>
											<?php echo $__env->make('helpers.forms.fields.text', [
												'label'       => t('your_name'),
												'id'          => 'contactName',
												'name'        => 'contact_name',
												'placeholder' => t('enter_your_name'),
												'required'    => true,
												'value'       => null,
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
											$authFieldValue = getAuthField();
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
											$emailValue = (auth()->check() && isset(auth()->user()->email)) ? auth()->user()->email : '';
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
											$phoneValue = null;
											$phoneCountryValue = config('country.code');
											if (
												auth()->check()
												&& isset(auth()->user()->country_code)
												&& !empty(auth()->user()->phone)
												&& isset(auth()->user()->phone_country)
												// && auth()->user()->country_code == config('country.code')
											) {
												$phoneValue = auth()->user()->phone;
												$phoneCountryValue = auth()->user()->phone_country;
											}
											
											// phone_hidden
											$phoneHiddenChecked = (old('phone_hidden') == '1') ? ' checked' : '';
											$itiSuffix = '<input id="phoneHidden" name="phone_hidden" type="checkbox" value="1"' . $phoneHiddenChecked . '>';
											$itiSuffix .= '&nbsp;<small>' . t('Hide') . '</small>';
										?>
										<?php echo $__env->make('helpers.forms.fields.intl-tel-input', [
											'label'       => trans('auth.phone_number'),
											'id'          => 'phone',
											'name'        => 'phone',
											'required'    => (getAuthField() == 'phone'),
											'placeholder' => null,
											'value'       => $phoneValue,
											'countryCode' => $phoneCountryValue,
											'suffix'      => $itiSuffix,
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
										
										<?php echo $__env->make('front.post.createOrEdit.singleStep.partials.packages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
										<?php echo $__env->make('helpers.forms.fields.captcha', ['label' => trans('auth.captcha_human_verification')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										<?php if(!auth()->check()): ?>
											
											<?php echo $__env->make('helpers.forms.fields.checkbox', [
												'label'     => t('accept_terms_label', ['attributes' => getUrlPageByType('terms')]),
												'id'        => 'acceptTerms',
												'name'      => 'accept_terms',
												'required'  => true,
												'value'     => null,
												'baseClass' => ['wrapper' => 'mb-1 col-md-12'],
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
											
											
											<?php echo $__env->make('helpers.forms.fields.checkbox', [
												'label'    => t('accept_marketing_offers_label'),
												'id'       => 'acceptMarketingOffers',
												'name'     => 'accept_marketing_offers',
												'required' => false,
												'value'    => null,
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										<?php endif; ?>
										
										
										<div class="row mb-3 mt-5">
											<div class="col-md-6 mb-md-0 mb-2 text-start d-grid">
												<a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary btn-lg">
													<?php echo e(t('Cancel')); ?>

												</a>
											</div>
											<div class="col-md-6 mb-md-0 mb-2 text-end d-grid">
												<button id="payableFormSubmitButton" class="btn btn-primary btn-lg">
													<?php echo e(t('submit')); ?>

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

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/front/post/createOrEdit/singleStep/create.blade.php ENDPATH**/ ?>