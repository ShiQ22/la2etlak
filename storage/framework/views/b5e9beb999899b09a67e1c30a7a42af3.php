



<?php
	$layout ??= 'default'; // default, horizontal
	$isHorizontal = $layout === 'horizontal';
	$colLabel ??= 'col-md-3';
    $colField ??= 'col-md-9';
	
	$viewName = 'tinymce';
	$type = 'textarea';
	$label ??= null;
	$id ??= null;
	$name ??= null;
	$value ??= null;
	$default ??= null;
	$placeholder ??= null;
	$required ??= false;
	$hint ??= null;
	$attributes ??= [];
	
	$allowsLinks ??= (
		isFromAdminPanel()
		|| (
			config('settings.listing_form.remove_url_before') != '1' &&
			config('settings.listing_form.remove_url_after') != '1'
		)
	);
	$height ??= 400;
	$pluginOptions ??= [];
	
	$language = $pluginOptions['language'] ?? app()->getLocale();
	$directionality = $pluginOptions['directionality'] ?? ((config('lang.direction') == 'rtl') ?  'rtl' : 'ltr');
	$menubar = $pluginOptions['menubar'] ?? 'false';
	$statusbar = $pluginOptions['statusbar'] ?? 'false';
	
	$dotSepName = arrayFieldToDotNotation($name);
	$id = !empty($id) ? $id : str_replace('.', '-', $dotSepName);
	
	$value = $value ?? ($default ?? null);
	$value = old($dotSepName, $value);
	
	$attributes = \App\Helpers\Common\Html\HtmlAttr::append($attributes, 'class', 'tinymce');
?>
<div <?php echo $__env->make('helpers.forms.attributes.field-wrapper', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>>
	<?php echo $__env->make('helpers.forms.partials.label', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<?php if($isHorizontal): ?>
		<div class="<?php echo e($colField); ?>">
			<?php endif; ?>
			
			<textarea
					id="tinymce_<?php echo e($id); ?>"
					name="<?php echo e($name); ?>"
					<?php if(!empty($placeholder)): ?>placeholder="<?php echo e($placeholder); ?>"<?php endif; ?>
		            <?php echo $__env->make('helpers.forms.attributes.field', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			><?php echo e($value); ?></textarea>
			
			<?php echo $__env->make('helpers.forms.partials.hint', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php echo $__env->make('helpers.forms.partials.validation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
			<?php if($isHorizontal): ?>
		</div>
	<?php endif; ?>
</div>
<?php echo $__env->make('helpers.forms.partials.newline', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
	$viewName = str($viewName)->replace('-', '_')->toString();
?>



<?php if (! $__env->hasRenderedOnce('246c8648-bc0a-4f7d-b163-32bb7f8d6468')): $__env->markAsRenderedOnce('246c8648-bc0a-4f7d-b163-32bb7f8d6468');
$__env->startPush("{$viewName}_assets_scripts"); ?>
	<script src="<?php echo e(asset('assets/plugins/tinymce/tinymce.min.js')); ?>"></script>
	<?php
		$editorI18n = trans('tinymce', [], $language);
		$editorI18nJson = '';
		if (!empty($editorI18n)) {
			$editorI18nJson = collect($editorI18n)->toJson();
			$editorI18nJson = convertUTF8HtmlToAnsi($editorI18nJson);
		}
	?>
	<script>
		
		var tinymceSelector = 'textarea.tinymce';
		var tinymcePlugins = '<?php echo e($allowsLinks ? 'lists link table code' : 'lists table code'); ?>';
		var tinymceLanguage = '<?php echo e(!empty($editorI18nJson) ? $language : 'en'); ?>';
		var editorI18nJson = <?php echo !empty($editorI18nJson) ? $editorI18nJson : 'null'; ?>;
		
		
		var tinymceToolbar = '';
		tinymceToolbar += 'undo redo';
		tinymceToolbar += ' | ';
		tinymceToolbar += 'bold italic underline';
		tinymceToolbar += ' | ';
		tinymceToolbar += 'forecolor backcolor';
		tinymceToolbar += ' | ';
		tinymceToolbar += 'bullist numlist blockquote table';
		<?php if($allowsLinks): ?>
			tinymceToolbar += ' | ';
			tinymceToolbar += 'link unlink';
		<?php endif; ?>
		tinymceToolbar += ' | ';
		tinymceToolbar += 'alignleft aligncenter alignright';
		tinymceToolbar += ' | ';
		tinymceToolbar += 'outdent indent';
		tinymceToolbar += ' | ';
		tinymceToolbar += 'fontsizeselect';
		<?php if(isFromAdminPanel()): ?>
			tinymceToolbar += ' | ';
			tinymceToolbar += 'code';
		<?php endif; ?>
		
		
		const tinymceOptions = {
			selector: tinymceSelector,
			language: tinymceLanguage,
			directionality: '<?php echo e($directionality); ?>',
			height: <?php echo e((int)$height); ?>,
			menubar: <?php echo e($menubar); ?>,
			statusbar: <?php echo e($statusbar); ?>,
			plugins: tinymcePlugins,
			toolbar: tinymceToolbar,
			setup: (editor) => {
				/* Indicate that the value of this field has changed */
				editor.on('change', (e) => {
					const targetEl = editor.targetElm || null;
					if (targetEl) {
						targetEl.dispatchEvent(new Event('input', {bubbles: true}));
					}
				});
			},
		};
		
		onDocumentReady((event) => {
			applyTinyMCE(tinymceOptions, tinymceLanguage, editorI18nJson)
			
			// Listen for system theme changes
			const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
			mediaQuery.addEventListener('change', () => {
				removeTinyMCE(tinymceSelector);
				applyTinyMCE(tinymceOptions, tinymceLanguage, editorI18nJson)
			});
		});
		
		/**
		 * Apply the TinyMCE to the textarea
		 *
		 * @param options
		 * @param language
		 * @param i18n
		 */
		function applyTinyMCE(options, language, i18n) {
			if (isDarkThemeEnabled()) {
				options.content_css = 'dark';
				options.skin = 'oxide-dark';
			} else {
				if (options.content_css) {
					delete options.content_css;
				}
				if (options.skin) {
					delete options.skin;
				}
			}
			
			
			tinymce.init(options);
			
			
			if (i18n) {
				tinymce.addI18n(language, i18n);
			}
		}
		
		/**
		 * Remove the TinyMCE from the textarea
		 *
		 * @param domSelector
		 */
		function removeTinyMCE(domSelector) {
			tinymce.activeEditor.destroy();
			/* tinymce.remove(domSelector); */
			
			const textAreaEl = document.querySelector(domSelector);
			if (textAreaEl) {
				if (textAreaEl.style.visibility === 'hidden') {
					textAreaEl.style.visibility = 'visible';
				}
			}
		}
	</script>
<?php $__env->stopPush(); endif; ?>


<?php $__env->startPush("{$viewName}_helper_styles"); ?>
<?php $__env->stopPush(); ?>


<?php $__env->startPush("{$viewName}_helper_scripts"); ?>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/fields/tinymce.blade.php ENDPATH**/ ?>