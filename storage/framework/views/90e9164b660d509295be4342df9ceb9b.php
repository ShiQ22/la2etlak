<?php if(auth()->check()): ?>
	<?php
		$authUser = auth()->user();
		
		// Get plugins admin menu
		$pluginsMenu = '';
		$plugins = plugin_installed_list();
		if (!empty($plugins)) {
			foreach($plugins as $plugin) {
				if (method_exists($plugin->class, 'getAdminMenu')) {
					$pluginsMenu .= call_user_func($plugin->class . '::getAdminMenu');
				}
			}
		}
	?>
	<style>
		#adminSidebar ul li span {
			text-transform: capitalize;
		}
	</style>
	<aside class="left-sidebar" id="adminSidebar">
		
		<div class="scroll-sidebar">
			
			<nav class="sidebar-nav">
				<ul id="sidebarnav">
					<li class="sidebar-item user-profile">
						<a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
							<img src="<?php echo e($authUser->photo_url ?? '/images/user.png'); ?>" alt="Administrator">
							<span class="hide-menu"><?php echo e($authUser->name ?? 'Administrator'); ?></span>
						</a>
						<ul aria-expanded="false" class="collapse first-level">
							<li class="sidebar-item">
								<a href="<?php echo e(urlGen()->adminUrl('account')); ?>" class="sidebar-link p-0">
									<i class="mdi mdi-adjust"></i>
									<span class="hide-menu"><?php echo e(trans('admin.my_account')); ?></span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="<?php echo e(urlGen()->signOut()); ?>" class="sidebar-link p-0">
									<i class="mdi mdi-adjust"></i>
									<span class="hide-menu"><?php echo e(trans('admin.logout')); ?></span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="sidebar-item">
						<a href="<?php echo e(urlGen()->adminUrl('dashboard')); ?>" class="sidebar-link waves-effect waves-dark">
							<i data-feather="home" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.dashboard')); ?></span>
						</a>
					</li>
					<?php if(
						doesUserHavePermission($authUser, 'post-list')
						|| doesUserHavePermission($authUser, 'category-list')
						|| doesUserHavePermission($authUser, 'picture-list')
						|| doesUserHavePermission($authUser, 'field-list')
						|| userHasSuperAdminPermissions()
					): ?>
						<li class="sidebar-item">
							<a href="#" class="sidebar-link has-arrow waves-effect waves-dark">
								<i data-feather="list"></i> <span class="hide-menu"><?php echo e(trans('admin.listings')); ?></span>
							</a>
							<ul aria-expanded="false" class="collapse first-level">
								<?php if(doesUserHavePermission($authUser, 'post-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(urlGen()->adminUrl('posts')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.list')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(doesUserHavePermission($authUser, 'category-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(urlGen()->adminUrl('categories')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.categories')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(doesUserHavePermission($authUser, 'picture-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(urlGen()->adminUrl('pictures')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.pictures')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(doesUserHavePermission($authUser, 'field-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(urlGen()->adminUrl('custom_fields')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.custom fields')); ?></span>
										</a>
									</li>
								<?php endif; ?>
							</ul>
						</li>
					<?php endif; ?>
					
					<?php if(
						doesUserHavePermission($authUser, 'user-list')
						|| doesUserHavePermission($authUser, 'role-list')
						|| doesUserHavePermission($authUser, 'permission-list')
						|| userHasSuperAdminPermissions()
					): ?>
						<li  class="sidebar-item">
							<a href="#" class="sidebar-link has-arrow waves-effect waves-dark">
								<i data-feather="users" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.users')); ?></span>
							</a>
							<ul aria-expanded="false" class="collapse first-level">
								<?php if(doesUserHavePermission($authUser, 'user-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(urlGen()->adminUrl('users')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.list')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(doesUserHavePermission($authUser, 'role-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(urlGen()->adminUrl('roles')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.roles')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(doesUserHavePermission($authUser, 'permission-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(urlGen()->adminUrl('permissions')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.permissions')); ?></span>
										</a>
									</li>
								<?php endif; ?>
							</ul>
						</li>
					<?php endif; ?>
					
					<?php if(
						doesUserHavePermission($authUser, 'payment-list')
						|| userHasSuperAdminPermissions()
					): ?>
						<li class="sidebar-item">
							<a href="#" class="sidebar-link has-arrow waves-effect waves-dark">
								<i data-feather="dollar-sign" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.payments')); ?></span>
							</a>
							<ul aria-expanded="false" class="collapse first-level">
								<li class="sidebar-item">
									<a href="<?php echo e(urlGen()->adminUrl('payments/promotion')); ?>" class="sidebar-link">
										<i class="mdi mdi-adjust"></i>
										<span class="hide-menu"><?php echo e(trans('admin.promotions')); ?></span>
									</a>
								</li>
								<li class="sidebar-item">
									<a href="<?php echo e(urlGen()->adminUrl('payments/subscription')); ?>" class="sidebar-link">
										<i class="mdi mdi-adjust"></i>
										<span class="hide-menu"><?php echo e(trans('admin.subscriptions')); ?></span>
									</a>
								</li>
							</ul>
						</li>
					<?php endif; ?>
					<?php if(doesUserHavePermission($authUser, 'page-list') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(urlGen()->adminUrl('pages')); ?>" class="sidebar-link">
								<i data-feather="book-open" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.pages')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					<?php echo $pluginsMenu; ?>

					
					
					<?php if(
						doesUserHavePermission($authUser, 'setting-list')
						|| doesUserHavePermission($authUser, 'language-list')
						|| doesUserHavePermission($authUser, 'section-list')
						|| doesUserHavePermission($authUser, 'meta-tag-list')
						|| doesUserHavePermission($authUser, 'package-list')
						|| doesUserHavePermission($authUser, 'payment-method-list')
						|| doesUserHavePermission($authUser, 'advertising-list')
						|| doesUserHavePermission($authUser, 'country-list')
						|| doesUserHavePermission($authUser, 'currency-list')
						|| doesUserHavePermission($authUser, 'blacklist-list')
						|| doesUserHavePermission($authUser, 'report-type-list')
						|| userHasSuperAdminPermissions()
					): ?>
						<li class="nav-small-cap">
							<i class="mdi mdi-dots-horizontal"></i>
							<span class="hide-menu"><?php echo e(trans('admin.configuration')); ?></span>
						</li>
						
						<?php if(
							doesUserHavePermission($authUser, 'setting-list')
							|| doesUserHavePermission($authUser, 'language-list')
							|| doesUserHavePermission($authUser, 'section-list')
							|| doesUserHavePermission($authUser, 'meta-tag-list')
							|| doesUserHavePermission($authUser, 'package-list')
							|| doesUserHavePermission($authUser, 'payment-method-list')
							|| doesUserHavePermission($authUser, 'advertising-list')
							|| doesUserHavePermission($authUser, 'country-list')
							|| doesUserHavePermission($authUser, 'currency-list')
							|| doesUserHavePermission($authUser, 'blacklist-list')
							|| doesUserHavePermission($authUser, 'report-type-list')
							|| userHasSuperAdminPermissions()
						): ?>
							<li class="sidebar-item">
								<a href="#" class="has-arrow sidebar-link">
									<i data-feather="settings" class="feather-icon"></i>
									<span class="hide-menu"><?php echo e(trans('admin.settings')); ?></span>
								</a>
								<ul aria-expanded="false" class="collapse first-level">
									<?php echo $__env->make('admin.layouts.partials.sidebar.general-settings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
									<?php echo $__env->make('admin.layouts.partials.sidebar.tableData-settings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
								</ul>
							</li>
						<?php endif; ?>
					<?php endif; ?>
					
					<?php if(doesUserHavePermission($authUser, 'plugin-list') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(urlGen()->adminUrl('plugins')); ?>" class="sidebar-link">
								<i data-feather="package" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.plugins')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					<?php if(doesUserHavePermission($authUser, 'clear-cache') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(urlGen()->adminUrl('actions/clear_cache')); ?>" class="sidebar-link">
								<i data-feather="refresh-cw" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.clear cache')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					<?php if(doesUserHavePermission($authUser, 'backup-list') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(urlGen()->adminUrl('backups')); ?>" class="sidebar-link">
								<i data-feather="hard-drive" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.backups')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					
					<?php if(
						doesUserHavePermission($authUser, 'maintenance') ||
						userHasSuperAdminPermissions()
					): ?>
						<?php if(app()->isDownForMaintenance()): ?>
							<?php if(doesUserHavePermission($authUser, 'maintenance') || userHasSuperAdminPermissions()): ?>
								<li class="sidebar-item">
									<a href="<?php echo e(urlGen()->adminUrl('actions/maintenance/up')); ?>"
									   data-bs-toggle="tooltip"
									   title="<?php echo e(trans('admin.Leave Maintenance Mode')); ?>"
									   class="sidebar-link confirm-simple-action"
									>
										<i data-feather="toggle-right"></i> <span class="hide-menu"><?php echo e(trans('admin.Live Mode')); ?></span>
									</a>
								</li>
							<?php endif; ?>
						<?php else: ?>
							<?php if(doesUserHavePermission($authUser, 'maintenance') || userHasSuperAdminPermissions()): ?>
								<li class="sidebar-item">
									<a href="#maintenanceMode"
									   data-bs-toggle="modal"
									   title="<?php echo e(trans('admin.Put in Maintenance Mode')); ?>"
									   class="sidebar-link"
									>
										<i data-feather="toggle-left"></i> <span class="hide-menu"><?php echo e(trans('admin.Maintenance')); ?></span>
									</a>
								</li>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
					<?php if(doesUserHavePermission($authUser, 'system-info') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(urlGen()->adminUrl('system')); ?>" class="sidebar-link">
								<i data-feather="alert-circle"></i> <span class="hide-menu"><?php echo e(trans('admin.system_info')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					
					<?php if(userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(url('docs/api')); ?>" target="_blank" class="sidebar-link">
								<i data-feather="book" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.api_docs')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					
				</ul>
			</nav>
			
		</div>
		
	</aside>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/layouts/partials/sidebar.blade.php ENDPATH**/ ?>