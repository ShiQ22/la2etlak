<header class="topbar">
	<?php
		$authUser = auth()->user();
		$photoUrl = $authUser->photo_url ?? '/images/user.png';
		
		$navbarTheme = (config('settings.style.admin_navbar_bg') == 'skin6') ? 'navbar-light' : 'navbar-dark';
		$appName = strtolower(config('settings.app.name'));
		$logoFactoryUrl = config('larapen.media.logo-factory');
		$logoDarkUrl = config('settings.app.logo_dark_url', $logoFactoryUrl);
		$logoLightUrl = config('settings.app.logo_light_url', $logoFactoryUrl);
		
		// Theme Preference (light/dark/system)
		$showIconOnly ??= false;
	?>
	<nav class="navbar top-navbar navbar-expand-md <?php echo e($navbarTheme); ?>">
		
		<div class="navbar-header">
			
			
			<a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
				<i class="fa-solid fa-bars"></i>
			</a>
			
			
			<a class="navbar-brand" href="<?php echo e(url('/')); ?>" target="_blank">
				
				<span class="logo-text m-auto">
					<img src="<?php echo e($logoDarkUrl); ?>"
					     alt="<?php echo e($appName); ?>"
					     class="dark-logo img-fluid"
					     style="width:auto; height:auto; max-width:200px; max-height:40px;"
					/>
					<img src="<?php echo e($logoLightUrl); ?>"
					     alt="<?php echo e($appName); ?>"
					     class="light-logo img-fluid"
					     style="width:auto; height:auto; max-width:200px; max-height:40px;"
					/>
				</span>
			</a>
			
			
			<a class="topbartoggler d-block d-md-none waves-effect waves-light"
			   href="javascript:void(0)"
			   data-bs-toggle="collapse"
			   data-bs-target="#navbarSupportedContent"
			   aria-controls="navbarSupportedContent"
			   aria-expanded="false"
			   aria-label="Toggle navigation"
			>
				<i class="bi bi-three-dots"></i>
			</a>
			
		</div>
		
		<div class="navbar-collapse collapse" id="navbarSupportedContent">
			
			<ul class="navbar-nav me-auto">
				<li class="nav-item">
					<a class="nav-link sidebartoggler d-none d-md-block waves-effect waves-dark" href="javascript:void(0)">
						<i class="fa-solid fa-bars"></i>
					</a>
				</li>
			</ul>
			
			
			<ul class="navbar-nav justify-content-end">
				
				<?php echo $__env->make('front.layouts.partials.navs.themes', [
					'dropdownTag'   => 'li',
					'dropdownClass' => 'nav-item',
					'buttonClass'   => 'nav-link waves-effect waves-dark',
					'menuAlignment' => 'dropdown-menu-end',
					'showIconOnly'  => $showIconOnly,
				], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
				
				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle waves-effect waves-dark"
					   href=""
					   data-bs-toggle="dropdown"
					   aria-haspopup="true"
					   aria-expanded="false"
					>
						<img src="<?php echo e($photoUrl); ?>"
							 alt="Administrator"
							 width="30"
							 class="profile-pic rounded-circle"
						/>
					</a>
					<div class="dropdown-menu dropdown-menu-end user-dd">
						<div class="d-flex no-block align-items-center p-3 bg-primary text-white mb-2">
							<div class="">
								<img src="<?php echo e($photoUrl); ?>" alt="Administrator" class="rounded-circle" width="60">
							</div>
							<div class="ms-2">
								<h4 class="mb-0 text-white"><?php echo e($authUser->name ?? 'Administrator'); ?></h4>
								<p class="mb-0"><?php echo e($authUser->email ?? '--'); ?></p>
							</div>
						</div>
						<a class="dropdown-item" href="<?php echo e(urlGen()->adminUrl('account')); ?>">
							<i data-feather="user" class="feather-sm text-info me-1 ms-1"></i> <?php echo e(trans('admin.my_account')); ?>

						</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo e(urlGen()->signOut()); ?>">
							<i data-feather="log-out" class="feather-sm text-danger me-1 ms-1"></i> <?php echo e(trans('admin.logout')); ?>

						</a>
					</div>
				</li>
			</ul>
		</div>
		
	</nav>
</header>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/layouts/partials/header.blade.php ENDPATH**/ ?>