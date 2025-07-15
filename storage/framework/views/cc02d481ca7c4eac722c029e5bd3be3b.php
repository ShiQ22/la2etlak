
<script>
	<?php
		$translations = [
	        'hide_password' => trans('auth.hide_password'),
	        'show_password' => trans('auth.show_password'),
	        'hide'          => trans('auth.hide'),
	        'show'          => trans('auth.show'),
	        'verify'        => trans('auth.verify'),
	        'submitting'    => trans('auth.submitting'),
	    ];
	?>
	window.authTranslations = <?php echo json_encode($translations); ?>;
</script>
<?php /**PATH C:\xampp\htdocs\resources\views/auth/layouts/js/translations.blade.php ENDPATH**/ ?>