<?php
	$authUserIsAdmin ??= false;
	$providers ??= [];
?>
<div class="col-12">
	<div class="card">
		<div class="card-header">
			<h5 class="card-title mb-0">
				<?php echo e(trans('auth.connected_accounts')); ?>

			</h5>
		</div>
		<div class="card-body">
			<?php if(!empty($providers)): ?>
				<form action="<?php echo e(urlGen()->accountLinkedAccounts()); ?>" method="POST">
					<?php echo csrf_field(); ?>

					<input name="_method" type="hidden" value="DELETE">
					<table class="table">
						<thead>
						<tr>
							<th scope="col" style="width: 10%">#</th>
							<th scope="col" style="width: 40%"><?php echo e(trans('auth.service')); ?></th>
							<th scope="col" style="width: 40%"><?php echo e(t('Date')); ?></th>
							<th scope="col" style="width: 10%"><?php echo e(t('action')); ?></th>
						</tr>
						</thead>
						<tbody>
						<?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider => $providerData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
								$btnClass = data_get($providerData, 'btnClass');
								$iconClass = data_get($providerData, 'iconClass');
								$url = data_get($providerData, 'url');
								$name = data_get($providerData, 'name');
								$label = data_get($providerData, 'label');
								$title = strip_tags($label);
								$isConnected = data_get($providerData, 'isConnected');
								$connectedAt = data_get($providerData, 'connectedAt');
								
								$name = $isConnected ? $label : '<strong>' . $name . '</strong>';
								// $actionBtnLabel = $isConnected ? trans('auth.disconnect') : trans('auth.connect');
								$actionBtnLabel = trans('auth.disconnect');
								$disableClass = !$isConnected ? ' disabled' : '';
							?>
							<tr>
								<th scope="row">
									<i class="<?php echo e($iconClass); ?>"></i>
								</th>
								<td><?php echo $name; ?></td>
								<td><?php echo $connectedAt; ?></td>
								<td>
									<a href="<?php echo e(urlGen()->accountDisconnectLinkedAccount($provider)); ?>"
									   class="btn btn-sm btn-secondary<?php echo e($disableClass); ?>"
									>
										<?php echo e($actionBtnLabel); ?>

									</a>
								</td>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>
					</table>
				</form>
			<?php else: ?>
				<idv class="row m-5">
					<div class="col-12 text-muted fs-6 d-flex justify-content-center">
						<?php echo e(trans('auth.no_connected_accounts')); ?>

					</div>
				</idv>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php /**PATH C:\xampp\htdocs\resources\views/front/account/partials/linked-accounts.blade.php ENDPATH**/ ?>