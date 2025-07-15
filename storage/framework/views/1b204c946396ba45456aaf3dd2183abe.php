
<style>
<?php if(!empty($primaryBgColor)): ?>
/* === Skin === */
	
	
	html[theme="dark"] .skin .btn-primary {
		color: <?php echo e($primaryColor); ?>;
		background-color: <?php echo e($primaryBgColor); ?>;
		border-color: <?php echo e($primaryBgColor); ?>;
	}
	html[theme="dark"] .skin .btn-primary:hover,
	html[theme="dark"] .skin .btn-primary:focus,
	html[theme="dark"] .skin .btn-primary:active,
	html[theme="dark"] .skin .btn-primary:active:focus,
	html[theme="dark"] .skin .btn-primary.active,
	html[theme="dark"] .skin .btn-primary.active:focus,
	html[theme="dark"] .skin .show > .btn-primary.dropdown-toggle,
	html[theme="dark"] .skin .open .dropdown-toggle.btn-primary {
		color: <?php echo e($primaryColor); ?>;
		background-color: <?php echo e($primaryBgColor10); ?>;
		border-color: <?php echo e($primaryBgColor10); ?>;
		background-image: none;
	}
	
	
	html[theme="dark"] .skin .btn-primary-dark {
		color: <?php echo e($primaryDarkColor); ?>;
		background-color: <?php echo e($primaryDarkBgColor); ?>;
		border-color: <?php echo e($primaryDarkBgColor); ?>;
	}
	html[theme="dark"] .skin .btn-primary-dark:hover,
	html[theme="dark"] .skin .btn-primary-dark:focus,
	html[theme="dark"] .skin .btn-primary-dark:active,
	html[theme="dark"] .skin .btn-primary-dark:active:focus,
	html[theme="dark"] .skin .btn-primary-dark.active,
	html[theme="dark"] .skin .btn-primary-dark.active:focus,
	html[theme="dark"] .skin .show > .btn-primary-dark.dropdown-toggle,
	html[theme="dark"] .skin .open .dropdown-toggle.btn-primary-dark {
		color: <?php echo e($primaryDarkColor); ?>;
		background-color: <?php echo e($primaryDarkBgColor10); ?>;
		border-color: <?php echo e($primaryDarkBgColor10); ?>;
		background-image: none;
	}
	
	
	html[theme="dark"] .skin .btn-outline-primary {
		color: <?php echo e($primaryBgColor); ?> !important;
		background-color: var(--bs-secondary-bg); /* ; */
		border-color: <?php echo e($primaryBgColor); ?>;
	}
	html[theme="dark"] .skin .btn-outline-primary:hover,
	html[theme="dark"] .skin .btn-outline-primary:focus,
	html[theme="dark"] .skin .btn-outline-primary:active,
	html[theme="dark"] .skin .btn-outline-primary:active:focus,
	html[theme="dark"] .skin .btn-outline-primary.active,
	html[theme="dark"] .skin .btn-outline-primary.active:focus,
	html[theme="dark"] .skin .show > .btn-outline-primary.dropdown-toggle,
	html[theme="dark"] .skin .open .dropdown-toggle.btn-outline-primary {
		color: <?php echo e($primaryColor); ?> !important;
		background-color: <?php echo e($primaryBgColor); ?>;
		border-color: <?php echo e($primaryBgColor); ?>;
		background-image: none;
	}
	
	
	html[theme="dark"] .skin .btn-primary.btn-gradient {
		color: <?php echo e($primaryColor); ?>;
		background: -webkit-linear-gradient(292deg, <?php echo e($primaryBgColor20d); ?> 44%, <?php echo e($primaryBgColor); ?> 85%);
		background: -moz-linear-gradient(292deg, <?php echo e($primaryBgColor20d); ?> 44%, <?php echo e($primaryBgColor); ?> 85%);
		background: -o-linear-gradient(292deg, <?php echo e($primaryBgColor20d); ?> 44%, <?php echo e($primaryBgColor); ?> 85%);
		background: linear-gradient(158deg, <?php echo e($primaryBgColor20d); ?> 44%, <?php echo e($primaryBgColor); ?> 85%);
		border-color: <?php echo e($primaryBgColor20d); ?>;
		-webkit-transition: all 0.25s linear;
		-moz-transition: all 0.25s linear;
		-o-transition: all 0.25s linear;
		transition: all 0.25s linear;
	}
	html[theme="dark"] .skin .btn-primary.btn-gradient:hover,
	html[theme="dark"] .skin .btn-primary.btn-gradient:focus,
	html[theme="dark"] .skin .btn-primary.btn-gradient:active,
	html[theme="dark"] .skin .btn-primary.btn-gradient:active:focus,
	html[theme="dark"] .skin .btn-primary.btn-gradient.active,
	html[theme="dark"] .skin .btn-primary.btn-gradient.active:focus,
	html[theme="dark"] .skin .show > .btn-primary.btn-gradient.dropdown-toggle,
	html[theme="dark"] .skin .open .dropdown-toggle.btn-primary.btn-gradient {
		color: <?php echo e($primaryColor); ?>;
		background-color: <?php echo e($primaryBgColor); ?>;
		border-color: <?php echo e($primaryBgColor); ?>;
		background-image: none;
	}
	html[theme="dark"] .skin .btn-check:focus+.btn-primary.btn-gradient,
	html[theme="dark"] .skin .btn-primary.btn-gradient:focus,
	html[theme="dark"] .skin .btn-primary.btn-gradient.focus {
		box-shadow: 0 0 0 2px <?php echo e($primaryBgColor50); ?>;
	}
<?php endif; ?>
</style>
<?php /**PATH C:\xampp\htdocs\resources\views/front/common/css/dark.blade.php ENDPATH**/ ?>