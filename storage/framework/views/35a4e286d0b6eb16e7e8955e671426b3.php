<?php
	$countries ??= collect();
	
	// Search parameters
	$queryString = request()->getQueryString();
	$queryString = !empty($queryString) ? '?' . $queryString : '';
	
	$showCountryFlagNextLogo = (config('settings.localization.show_country_flag') == 'in_next_logo');
	
	// Check if the Multi-Countries selection is enabled
	$multiCountryIsEnabled = false;
	$multiCountryLabel = '';
	if ($showCountryFlagNextLogo) {
		if (!empty(config('country.code'))) {
			if ($countries->count() > 1) {
				$multiCountryIsEnabled = true;
				$multiCountryLabel = 'title="' . t('select_country') . '"';
			}
		}
	}
	
	// Country
	$countryName = config('country.name');
	$countryFlag24Url = config('country.flag24_url');
	$countryFlag32Url = config('country.flag32_url');
	
	// Logo
	$logoFactoryUrl = config('larapen.media.logo-factory');
	$logoDarkUrl = config('settings.app.logo_dark_url', $logoFactoryUrl);
	$logoLightUrl = config('settings.app.logo_light_url', $logoFactoryUrl);
	$logoAlt = strtolower(config('settings.app.name'));
	$logoWidth = (int)config('settings.upload.img_resize_logo_width', 454);
	$logoHeight = (int)config('settings.upload.img_resize_logo_height', 80);
	
	// Logo Label
	$logoLabel = '';
	if ($multiCountryIsEnabled) {
		$logoLabel = config('settings.app.name') . (!empty($countryName) ? ' ' . $countryName : '');
	}
	
	// User Menu
	$authUser = auth()->check() ? auth()->user() : null;
	$userMenu ??= collect();
	
	// Links CSS Class
	$linkClass = linkClass('body-emphasis');
	
	// Theme Preference (light/dark/system)
	$showIconOnly ??= false;
	
	$isFixedTopHeader = (config('settings.style.header_fixed_top') == '1');
	$fixedTopClass = $isFixedTopHeader ? ' fixed-top' : '';
	
	$isFullWidthHeader = (config('settings.style.header_full_width') == '1');
	$containerClass = $isFullWidthHeader ? 'container-fluid' : 'container';
?>
<header>
	
	<nav class="navbar<?php echo e($fixedTopClass); ?> navbar-expand-xl bg-body-tertiary border-bottom navbar-website" role="navigation">
		<div class="<?php echo e($containerClass); ?>">
			
			
			<a href="<?php echo e(url('/')); ?>" class="navbar-brand logo logo-title">
				<img src="<?php echo e($logoDarkUrl); ?>"
				     alt="<?php echo e($logoAlt); ?>"
				     class="main-logo light-logo"
				     data-bs-placement="bottom"
				     data-bs-toggle="tooltip"
				     title="<?php echo $logoLabel; ?>"
				     style="max-width: <?php echo e($logoWidth); ?>px; max-height: <?php echo e($logoHeight); ?>px; width:auto;"
				/>
				<img src="<?php echo e($logoLightUrl); ?>"
				     alt="<?php echo e($logoAlt); ?>"
				     class="main-logo dark-logo d-none"
				     data-bs-placement="bottom"
				     data-bs-toggle="tooltip"
				     title="<?php echo $logoLabel; ?>"
				     style="max-width: <?php echo e($logoWidth); ?>px; max-height: <?php echo e($logoHeight); ?>px; width:auto;"
				/>
			</a>
			
			
			<button class="navbar-toggler float-end"
			        type="button"
			        data-bs-toggle="collapse"
			        data-bs-target="#navbarDefault"
			        aria-controls="navbarDefault"
			        aria-expanded="false"
			        aria-label="Toggle navigation"
			>
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="navbarDefault">
				<ul class="navbar-nav me-md-auto">
					
					<?php if($showCountryFlagNextLogo): ?>
						<?php if(!empty($countryFlag32Url)): ?>
							<li class="nav-item flag-menu country-flag"
							    data-bs-toggle="tooltip"
							    data-bs-placement="<?php echo e((config('lang.direction') == 'rtl') ? 'bottom' : 'right'); ?>" <?php echo $multiCountryLabel; ?>

							>
								<?php if($multiCountryIsEnabled): ?>
									<a class="nav-link p-0 <?php echo e($linkClass); ?>" data-bs-toggle="modal" data-bs-target="#selectCountry" style="cursor: pointer">
										<img class="flag-icon mt-1" src="<?php echo e($countryFlag32Url); ?>" alt="<?php echo e($countryName); ?>">
										<i class="bi bi-chevron-down float-end mt-1 mx-2"></i>
									</a>
								<?php else: ?>
									<a class="nav-link p-0" style="cursor: default;">
										<img class="flag-icon" src="<?php echo e($countryFlag32Url); ?>" alt="<?php echo e($countryName); ?>">
									</a>
								<?php endif; ?>
							</li>
						<?php endif; ?>
					<?php endif; ?>
				</ul>
				
				<ul class="navbar-nav ms-auto">
					<?php if(config('plugins.currencyexchange.installed')): ?>
						<?php echo $__env->make('currencyexchange::select-currency', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					<?php endif; ?>
					
					<?php if(config('settings.listings_list.display_browse_listings_link')): ?>
						<li class="nav-item">
							<?php
								$currDisplay = config('settings.listings_list.display_mode');
								$browseListingsIconClass = 'bi bi-grid-fill';
								if ($currDisplay == 'make-list') {
									$browseListingsIconClass = 'fa-solid fa-list';
								}
								if ($currDisplay == 'make-compact') {
									$browseListingsIconClass = 'fa-solid fa-bars';
								}
							?>
							<a href="<?php echo e(urlGen()->searchWithoutQuery()); ?>" class="nav-link <?php echo e($linkClass); ?>">
								<i class="<?php echo e($browseListingsIconClass); ?>"></i> <?php echo e(t('Browse Listings')); ?>

							</a>
						</li>
					<?php endif; ?>
					
					<?php if(config('settings.listing_form.pricing_page_enabled') == '2'): ?>
						<li class="nav-item pricing">
							<a href="<?php echo e(urlGen()->pricing()); ?>" class="nav-link <?php echo e($linkClass); ?>">
								<i class="fa-solid fa-tags"></i> <?php echo e(t('pricing_label')); ?>

							</a>
						</li>
					<?php endif; ?>
					
					<?php
						[$createListingLinkUrl, $createListingLinkAttr] = getCreateListingLinkInfo();
					?>
					<li class="nav-item">
						<a id="createListingBtn"
						class="btn btn-listing btn-border"
						href="#"
						data-bs-toggle="modal"
						data-bs-target="#listingTypeModal"
						<?php echo $createListingLinkAttr; ?>

						>
							<i class="fa-regular fa-pen-to-square"></i> <?php echo e(t('create_listing')); ?>

						</a>
					</li>

					
					<?php
						$openOnHover = ''; // ' open-on-hover'
					?>
					<?php if(empty($authUser)): ?>
						<li class="nav-item dropdown<?php echo e($openOnHover); ?>">
							<a href="#" class="nav-link dropdown-toggle <?php echo e($linkClass); ?>" data-bs-toggle="dropdown">
								<i class="fa-solid fa-user"></i>
								<span><?php echo e(trans('auth.log_in')); ?></span>
							</a>
							<ul id="authNavDropdown" class="dropdown-menu user-menu shadow-sm">
								<li>
									<a href="<?php echo urlGen()->signInModal(); ?>" class="dropdown-item">
										<i class="fa-solid fa-user"></i> <?php echo e(trans('auth.log_in')); ?>

									</a>
								</li>
								<li>
									<a href="<?php echo e(urlGen()->signUp()); ?>" class="dropdown-item">
										<i class="fa-regular fa-user"></i> <?php echo e(trans('auth.sign_up')); ?>

									</a>
								</li>
							</ul>
						</li>
					<?php else: ?>
						<li class="nav-item dropdown<?php echo e($openOnHover); ?>">
							<a href="#" class="nav-link dropdown-toggle <?php echo e($linkClass); ?>" data-bs-toggle="dropdown">
								<i class="bi bi-person-circle"></i>
								<span><?php echo e($authUser->name); ?></span>
								<span class="badge rounded-pill text-bg-danger count-threads-with-new-messages">0</span>
							</a>
							<ul id="userNavDropdown" class="dropdown-menu shadow-sm">
								<?php if($userMenu->count() > 0): ?>
									<?php
										$menuGroup = '';
										$dividerNeeded = false;
									?>
									<?php $__currentLoopData = $userMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if(!$value['inDropdown']) continue; ?>
										<?php
											if ($menuGroup != $value['group']) {
												$menuGroup = $value['group'];
												if (!empty($menuGroup) && !$loop->first) {
													$dividerNeeded = true;
												}
											} else {
												$dividerNeeded = false;
											}
											$activeClass = (isset($value['isActive']) && $value['isActive']) ? ' active' : '';
										?>
										<?php if($dividerNeeded): ?>
											<li><hr class="dropdown-divider"></li>
										<?php endif; ?>
										<li>
											<a href="<?php echo e($value['url']); ?>" class="dropdown-item<?php echo e($activeClass); ?> px-4">
												<i class="<?php echo e($value['icon']); ?>"></i> <?php echo e($value['name']); ?>

												<?php if(!empty($value['countCustomClass']) && !is_null($value['countVar'])): ?>
													<span class="badge rounded-pill text-bg-danger<?php echo e($value['countCustomClass']); ?>">0</span>
												<?php endif; ?>
											</a>
										</li>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</ul>
						</li>
					<?php endif; ?>
					
					<?php if(isSettingsAppDarkModeEnabled()): ?>
						<?php echo $__env->make('front.layouts.partials.navs.themes', [
							'dropdownTag'   => 'li',
							'dropdownClass' => 'nav-item',
							'buttonClass'   => 'nav-link',
							'menuAlignment' => 'dropdown-menu-end',
							'showIconOnly'  => $showIconOnly,
							'linkClass'     => $linkClass,
						], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					<?php endif; ?>
					
					<?php echo $__env->make('front.layouts.partials.navs.languages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					
				</ul>
			</div>
		
		</div>
	</nav>
</header>
<?php /**PATH C:\xampp\htdocs\resources\views/front/layouts/partials/header.blade.php ENDPATH**/ ?>