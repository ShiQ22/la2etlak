<?php
	use App\Enums\ThemePreference;
?>
<?php if(isSettingsAppDarkModeEnabled() || isFromAdminPanel()): ?>
	<?php
		$showIconOnly ??= false;
		
		// Get all themes
		$userThemes = getFormattedThemes();
		
		// Get selected theme
		$defaultTheme = isSettingsAppSystemThemeEnabled()
			? ThemePreference::SYSTEM->value
			: ThemePreference::LIGHT->value;
		$defaultThemeLabel = isSettingsAppSystemThemeEnabled()
			? ThemePreference::SYSTEM->label()
			: ThemePreference::LIGHT->label();
		$selectedTheme = getThemePreference() ?? $defaultTheme;
		$selectedThemeLabel = getFormattedThemes(theme: $selectedTheme, iconOnly: $showIconOnly)['label'] ?? $defaultThemeLabel;
		
		// Tag & CSS Classes
		$dropdownTag ??= 'div';
		$dropdownClass ??= '';
		$buttonClass ??= ''; // btn btn-secondary
		$menuAlignment ??= ''; // dropdown-menu-end
		
		$dropdownTag = in_array($dropdownTag, ['div', 'li', 'span', 'p']) ? $dropdownTag : 'div';
		$dropdownClass = !empty($dropdownClass) ? ' ' . $dropdownClass : '';
		$menuAlignment = !empty($menuAlignment) ? ' ' . $menuAlignment : '';
		
		$linkClass ??= linkClass('body-emphasis');
	?>
	<?php if(!empty($userThemes)): ?>
		<<?php echo e($dropdownTag); ?> id="themeSwitcher" class="dropdown<?php echo e($dropdownClass); ?>">
			<a href="#"
			   data-theme="<?php echo e($selectedTheme); ?>"
			   class="<?php echo e($buttonClass); ?> dropdown-toggle <?php echo e($linkClass); ?>"
			   role="button"
			   data-bs-toggle="dropdown"
			   aria-expanded="false"
			>
				<?php echo $selectedThemeLabel; ?>

			</a>
			
			<ul id="themesNavDropdown" class="dropdown-menu shadow-sm<?php echo e($menuAlignment); ?>">
				<?php $__currentLoopData = $userThemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
						$activeClass = ($selectedTheme == $key) ? ' active' : '';
					?>
					<li>
						<a href=""
						   data-csrf-token="<?php echo e(csrf_token()); ?>"
						   data-theme="<?php echo e($key); ?>"
						   data-user-id="<?php echo e($authUser->id ?? null); ?>"
						   class="dropdown-item<?php echo e($activeClass); ?>"
						>
							<?php echo $label['label'] ?? ''; ?>

						</a>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</<?php echo e($dropdownTag); ?>>
	<?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/layouts/partials/navs/themes.blade.php ENDPATH**/ ?>