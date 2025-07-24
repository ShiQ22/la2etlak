
<td data-order="<?php echo e($entry->{$column['name']}); ?>">
	<?php
	try {
		$dateColumnValue = (new \Illuminate\Support\Carbon($entry->{$column['name']}))->timezone(\App\Helpers\Common\Date::getAppTimeZone());
	} catch (\Throwable $e) {
		$dateColumnValue = new \Illuminate\Support\Carbon($entry->{$column['name']});
	}
	?>
	<?php echo e(\App\Helpers\Common\Date::format($dateColumnValue, 'datetime')); ?>

</td>
<?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/columns/datetime.blade.php ENDPATH**/ ?>