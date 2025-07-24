<?php
	$authUser ??= null;
?>
<?php if(doesUserHavePermission($authUser, 'language-list') || userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="<?php echo e(urlGen()->adminUrl('languages')); ?>" class="sidebar-link">
			<i class="mdi mdi-adjust"></i>
			<span class="hide-menu"><?php echo e(trans('admin.languages')); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if(doesUserHavePermission($authUser, 'section-list') || userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="<?php echo e(urlGen()->adminUrl('sections')); ?>" class="sidebar-link">
			<i class="mdi mdi-adjust"></i>
			<span class="hide-menu"><?php echo e(trans('admin.homepage')); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if(doesUserHavePermission($authUser, 'meta-tag-list') || userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="<?php echo e(urlGen()->adminUrl('meta_tags')); ?>" class="sidebar-link">
			<i class="mdi mdi-adjust"></i>
			<span class="hide-menu"><?php echo e(trans('admin.meta tags')); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if(doesUserHavePermission($authUser, 'package-list')|| userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="#packages" class="sidebar-link has-arrow">
			<i class="mdi mdi-adjust"></i> <span class="hide-menu"><?php echo e(trans('admin.packages')); ?></span>
		</a>
		<ul aria-expanded="false" class="collapse second-level">
			<li class="sidebar-item">
				<a href="<?php echo e(urlGen()->adminUrl('packages/promotion')); ?>" class="sidebar-link">
					<i class="mdi mdi-adjust"></i>
					<span class="hide-menu"><?php echo e(trans('admin.promotion')); ?></span>
				</a>
			</li>
			<li class="sidebar-item">
				<a href="<?php echo e(urlGen()->adminUrl('packages/subscription')); ?>" class="sidebar-link">
					<i class="mdi mdi-adjust"></i>
					<span class="hide-menu"><?php echo e(trans('admin.subscription')); ?></span>
				</a>
			</li>
			<li class="sidebar-item">&nbsp;</li>
		</ul>
	</li>
<?php endif; ?>
<?php if(doesUserHavePermission($authUser, 'payment-method-list') || userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="<?php echo e(urlGen()->adminUrl('payment_methods')); ?>" class="sidebar-link">
			<i class="mdi mdi-adjust"></i>
			<span class="hide-menu"><?php echo e(trans('admin.payment methods')); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if(doesUserHavePermission($authUser, 'advertising-list') || userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="<?php echo e(urlGen()->adminUrl('advertisings')); ?>" class="sidebar-link">
			<i class="mdi mdi-adjust"></i>
			<span class="hide-menu"><?php echo e(trans('admin.advertising')); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if(
	doesUserHavePermission($authUser, 'country-list')
	|| doesUserHavePermission($authUser, 'currency-list')
	|| userHasSuperAdminPermissions()
): ?>
	<li class="sidebar-item">
		<a href="#international" class="sidebar-link has-arrow">
			<i class="fa-solid fa-globe"></i> <span class="hide-menu"><?php echo e(trans('admin.international')); ?></span>
		</a>
		<ul aria-expanded="false" class="collapse second-level">
			<?php if(doesUserHavePermission($authUser, 'country-list') || userHasSuperAdminPermissions()): ?>
				<li class="sidebar-item">
					<a href="<?php echo e(urlGen()->adminUrl('countries')); ?>" class="sidebar-link">
						<i class="mdi mdi-adjust"></i>
						<span class="hide-menu"><?php echo e(trans('admin.countries')); ?></span>
					</a>
				</li>
			<?php endif; ?>
			<?php if(doesUserHavePermission($authUser, 'currency-list') || userHasSuperAdminPermissions()): ?>
				<li class="sidebar-item">
					<a href="<?php echo e(urlGen()->adminUrl('currencies')); ?>" class="sidebar-link">
						<i class="mdi mdi-adjust"></i>
						<span class="hide-menu"><?php echo e(trans('admin.currencies')); ?></span>
					</a>
				</li>
			<?php endif; ?>
			<li class="sidebar-item">&nbsp;</li>
		</ul>
	</li>
<?php endif; ?>
<?php if(doesUserHavePermission($authUser, 'blacklist-list') || userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="<?php echo e(urlGen()->adminUrl('blacklists')); ?>" class="sidebar-link">
			<i class="mdi mdi-adjust"></i>
			<span class="hide-menu"><?php echo e(trans('admin.blacklist')); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if(doesUserHavePermission($authUser, 'report-type-list') || userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="<?php echo e(urlGen()->adminUrl('report_types')); ?>" class="sidebar-link">
			<i class="mdi mdi-adjust"></i>
			<span class="hide-menu"><?php echo e(trans('admin.report types')); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/layouts/partials/sidebar/tableData-settings.blade.php ENDPATH**/ ?>