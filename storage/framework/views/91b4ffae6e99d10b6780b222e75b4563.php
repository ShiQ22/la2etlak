<?php
	$authUser ??= null;
?>
<?php if(doesUserHavePermission($authUser, 'setting-list') || userHasSuperAdminPermissions()): ?>
	<?php if(config('settings.app.general_settings_as_submenu_in_sidebar')): ?>
		<?php if(isset($settings) && $settings->count() > 0): ?>
			<li class="sidebar-item">
				<a href="#general-settings" class="has-arrow sidebar-link">
					<span class="hide-menu"><?php echo e(trans('admin.general_settings')); ?></span>
				</a>
				<ul aria-expanded="false" class="collapse second-level">
					<?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li class="sidebar-item">
							<a href="<?php echo e(urlGen()->adminUrl('settings/' . $setting->id . '/edit')); ?>" class="sidebar-link">
								<span class="hide-menu"><?php echo e($setting->name); ?></span>
							</a>
						</li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<li class="sidebar-item">&nbsp;</li>
				</ul>
			</li>
		<?php else: ?>
			<li class="sidebar-item">
				<a href="<?php echo e(urlGen()->adminUrl('settings')); ?>" class="sidebar-link">
					<span class="hide-menu"><?php echo e(trans('admin.general_settings')); ?></span>
				</a>
			</li>
		<?php endif; ?>
	<?php else: ?>
		<li class="sidebar-item">
			<a href="<?php echo e(urlGen()->adminUrl('settings')); ?>" class="sidebar-link">
				<span class="hide-menu"><?php echo e(trans('admin.general_settings')); ?></span>
			</a>
		</li>
	<?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/layouts/partials/sidebar/general-settings.blade.php ENDPATH**/ ?>