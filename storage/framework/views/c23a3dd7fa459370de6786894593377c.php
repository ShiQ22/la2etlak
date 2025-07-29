<?php $__env->startSection('wizard'); ?>
	<?php echo $__env->make('front.post.createOrEdit.multiSteps.partials.wizard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php
	$post ??= [];
	
	$postTypes ??= [];
	$countries ??= [];
	
	$postCatParentId = data_get($post, 'category.parent_id');
	$postCatParentId = (empty($postCatParentId)) ? data_get($post, 'category.id', 0) : $postCatParentId;
	
	// Get steps URLs & labels
	$previousStepUrl ??= null;
	$previousStepLabel ??= null;
	$formActionUrl ??= request()->fullUrl();
	$nextStepUrl ??= '/';
	$nextStepLabel ??= t('submit') . '  <i class="bi bi-chevron-right"></i>';
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
							<i class="fa-solid fa-pen-to-square"></i> <?php echo e(t('update_my_listing')); ?>

							-&nbsp;<a href="<?php echo e(urlGen()->post($post)); ?>"
							          class="<?php echo e(linkClass()); ?>"
							          data-bs-placement="top"
							          data-bs-toggle="tooltip"
							          title="<?php echo data_get($post, 'title'); ?>"
							><?php echo str(data_get($post, 'title'))->limit(45); ?></a>
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
									<?php echo method_field('PUT'); ?>
									
									<input type="hidden" name="post_id" value="<?php echo e(data_get($post, 'id')); ?>">
									<fieldset>

									 
										<div class="form-group col-md-6">
											<label for="lost_or_found"><?php echo e(t('type')); ?></label>
											<select name="lost_or_found" id="lost_or_found" class="form-control" required>
											<option value="lost"
												<?php echo e(old('lost_or_found', data_get($post, 'lost_or_found')) === 'lost' ? 'selected' : ''); ?>>
												<?php echo e(t('Lost')); ?>

											</option>
											<option value="found"
												<?php echo e(old('lost_or_found', data_get($post, 'lost_or_found')) === 'found' ? 'selected' : ''); ?>>
												<?php echo e(t('Found')); ?>

											</option>
											</select>
										</div>
										
										
											<?php
												// Validation error class
												$catsError = $errors->has('categories') ? ' is-invalid' : '';

												// Modal URL (with ?multiple=1)
												$catsModalUrl = url('browsing/categories/select?multiple=1');

												// Pre-selected IDs from controller: $selected (array), names via $categories
											?>

											<div class="form-group col-md-6">
												<label><?php echo e(t('categories')); ?></label>
												<div id="catsContainer" class="form-control<?php echo e($catsError); ?>">
													<ul id="catsList" class="list-unstyled mb-2">
														<?php $__currentLoopData = $selected; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<?php $cat = $categories->find($catId); ?>
															<?php if($cat): ?>
																<li data-id="<?php echo e($catId); ?>">
																	<?php echo e($cat->name); ?>

																	<span class="remove-cat" data-id="<?php echo e($catId); ?>">×</span>
																	<input type="hidden" name="categories[]" value="<?php echo e($catId); ?>">
																</li>
															<?php endif; ?>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</ul>

													<a href="#browseCategories"
													data-bs-toggle="modal"
													data-selection-url="<?php echo e($catsModalUrl); ?>"
													class="modal-cat-link open-selection-url <?php echo e(linkClass()); ?>">
														<?php echo e(t('select_categories')); ?>

													</a>
												</div>
											</div>

										
										
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
												'value'           => data_get($post, 'post_type_id'),
												'hint'            => t('post_type_hint'),
												'wrapper'         => ['id' => 'postTypeBloc'],
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										<?php endif; ?>
										
										
										<?php echo $__env->make('helpers.forms.fields.text', [
											'label'       => t('title'),
											'name'        => 'title',
											'placeholder' => t('enter_your_title'),
											'required'    => true,
											'value'       => data_get($post, 'title'),
											'hint'        => t('a_great_title_needs_at_least_60_characters'),
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
										<?php echo $__env->make('helpers.forms.fields.wysiwyg', [
											'label'       => t('Description'),
											'name'        => 'description',
											'placeholder' => t('enter_your_message'),
											'required'    => true,
											'value'       => data_get($post, 'description'),
											'height'      => 350,
											'attributes'  => ['rows' => 15],
											'hint'        => t('describe_what_makes_your_listing_unique'),
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
										<div id="cfContainer"></div>
										
										
										
										<input id="countryCode"
										       name="country_code"
										       type="hidden"
										       value="<?php echo e(data_get($post, 'country_code') ?? config('country.code')); ?>"
										>
										
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
												$adminType = (in_array($adminType, ['0', '1', '2'])) ? $adminType : 0;
												$relAdminType = (in_array($adminType, ['1', '2'])) ? $adminType : 1;
												$adminCode = data_get($post, 'city.subadmin' . $relAdminType . '_code', 0);
												$adminCode = data_get($post, 'city.subAdmin' . $relAdminType . '.code', $adminCode);
												$adminName = data_get($post, 'city.subAdmin' . $relAdminType . '.name');
												$cityId = data_get($post, 'city.id', 0);
												$cityName = data_get($post, 'city.name');
												$fullCityName = !empty($adminName) ? $cityName . ', ' . $adminName : $cityName;
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
											       value="<?php echo e(old('selected_city_name', $fullCityName)); ?>"
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
											'options'     => data_get($post, 'tags'),
											'hint'        => $tagHint,
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
										<?php if(config('settings.listing_form.permanent_listings_enabled') == '3'): ?>
											<input id="isPermanent"
											       name="is_permanent"
											       type="hidden"
											       value="<?php echo e(old('is_permanent', data_get($post, 'is_permanent'))); ?>"
											>
										<?php else: ?>
											<?php echo $__env->make('helpers.forms.fields.checkbox', [
												'label'    => t('is_permanent_label'),
												'id'       => 'isPermanent',
												'name'     => 'is_permanent',
												'switch'   => true,
												'required' => false,
												'value'    => data_get($post, 'is_permanent'),
												'hint'     => t('is_permanent_hint'),
												'wrapper'  => ['id' => 'isPermanentBox', 'class' => 'hide']
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										<?php endif; ?>
										
										
										<div class="col-12 fw-bold fs-5 border-bottom py-2 my-5 mb-4">
											<i class="bi bi-person-circle"></i> <?php echo e(t('seller_information')); ?>

										</div>
										
										
										
										<?php echo $__env->make('helpers.forms.fields.text', [
											'label'       => t('your_name'),
											'id'          => 'contactName',
											'name'        => 'contact_name',
											'placeholder' => t('enter_your_name'),
											'required'    => true,
											'value'       => data_get($post, 'contact_name'),
											'prefix'      => '<i class="fa-regular fa-user"></i>',
											'suffix'      => null,
											'baseClass'   => ['wrapper' => 'mb-3 col-md-8'],
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
										<?php
											$authFields = getAuthFields(true);
											$authFieldOptions = collect($authFields)
												->map(fn($item, $key) => ['value' => $key, 'text' => $item])
												->toArray();
											
											$usersCanChooseNotifyChannel = isUsersCanChooseNotifyChannel();
											$authFieldValue = data_get($post, 'auth_field') ?? getAuthField();
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
										
										
										<?php echo $__env->make('helpers.forms.fields.email', [
											'label'       => trans('auth.email'),
											'id'          => 'email',
											'name'        => 'email',
											'required'    => (getAuthField() == 'email'),
											'placeholder' => t('enter_your_email'),
											'value'       => data_get($post, 'email'),
											'prefix'      => '<i class="fa-regular fa-envelope"></i>',
											'suffix'      => null,
											'baseClass'   => ['wrapper' => 'mb-3 col-md-8'],
											'wrapper'     => ['class' => "auth-field-item{$forceToDisplay}"],
										], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
										
										
										<?php
											$phoneValue = data_get($post, 'phone');
											$phoneCountryValue = data_get($post, 'phone_country') ?? config('country.code');
											
											// phone_hidden
											$phoneHiddenValue = old('phone_hidden', data_get($post, 'phone_hidden'));
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
										
										
										<div class="row mb-3 mt-5">
											<div class="col-md-6 mb-md-0 mb-2 text-start d-grid">
												<a href="<?php echo e($previousStepUrl); ?>" class="btn btn-secondary btn-lg">
													<?php echo $previousStepLabel; ?>

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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script>
		defaultAuthField = '<?php echo e(old('auth_field', $authFieldValue ?? getAuthField())); ?>';
		phoneCountry = '<?php echo e(old('phone_country', ($phoneCountryValue ?? ''))); ?>';
		 var postId = <?php echo e(data_get($post, 'id')); ?>;
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.post.createOrEdit.partials.form-assets', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/front/post/createOrEdit/multiSteps/edit/post.blade.php ENDPATH**/ ?>