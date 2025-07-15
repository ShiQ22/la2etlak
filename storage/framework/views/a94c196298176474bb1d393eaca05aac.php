



<?php
	use App\Helpers\Common\Files\Storage\StorageDisk;
	use Illuminate\Support\Facades\Storage;
	use Illuminate\Support\ViewErrorBag;
	
	$layout ??= 'default'; // default, horizontal
	$isHorizontal = $layout === 'horizontal';
	$colLabel ??= 'col-md-3';
    $colField ??= 'col-md-9';
	
	$wrapper ??= [];
	$viewName = 'fileinput-multiple';
	$type = 'file';
	$label ??= null;
	$id ??= null;
	$name ??= null;
	$value ??= null; // e.g. array of: [key => 1, 'path' => 'path/to/file.ext', 'url' => 'https://domain/file.ext'],
	$default ??= null; // e.g. array of: [key => 1, 'path' => 'path/to/file.ext', 'url' => 'https://domain/file.ext'],
	$placeholder ??= null;
	$required ??= false;
	$hint ??= null;
	$attributes ??= [];
	
	$diskName ??= StorageDisk::getDiskName();
	$fileLoadingMessage ??= t('loading_wd');
	$limit ??= 5;
	$deleteUrlPattern ??= '/';
	$deleteConfirmQuestion ??= t('confirm_picture_deletion');
	$pluginOptions ??= [];
	
	$theme = $pluginOptions['theme'] ?? config('larapen.core.fileinput.theme', 'bs5');
	$language = $pluginOptions['language'] ?? app()->getLocale();
	$rtl = $pluginOptions['rtl'] ?? ((config('lang.direction') == 'rtl') ? 'true' : 'false');
	
	$previewFileType = $pluginOptions['previewFileType'] ?? null;
	$defaultAllowedFileFormats = ($previewFileType == 'image') ? getServerAllowedImageFormats() : getAllowedFileFormats();
	$allowedFileExtensions = $pluginOptions['allowedFileExtensions'] ?? $defaultAllowedFileFormats;
	$defaultMinFileSize = ($previewFileType == 'image')
		? config('settings.upload.min_image_size', 0)
		: config('settings.upload.min_file_size', 0);
	$defaultMaxFileSize = ($previewFileType == 'image')
		? config('settings.upload.max_image_size', 1000)
		: config('settings.upload.max_file_size', 1000);
	$minFileSize = $pluginOptions['minFileSize'] ?? $defaultMinFileSize;
	$maxFileSize = $pluginOptions['maxFileSize'] ?? $defaultMaxFileSize;
	$fileTypes = ($previewFileType == 'image') ? 'image' : 'file';
	$hint = !empty($hint) ? $hint : t('file_types', ['file_types' => getAllowedFileFormatsHint($fileTypes)]);
	$showPreview = $pluginOptions['showPreview'] ?? 'false';
	
	$showClose = $pluginOptions['showClose'] ?? 'false';
	$dropZoneEnabled = $pluginOptions['dropZoneEnabled'] ?? 'false';
	$browseOnZoneClick = $pluginOptions['browseOnZoneClick'] ?? 'false';
	$dropZoneTitle = $pluginOptions['dropZoneTitle'] ?? null;
	
	$showCaption = $pluginOptions['showCaption'] ?? 'true'; // input field
	$showBrowse = $pluginOptions['showBrowse'] ?? 'true'; // input field browse button
	$browseClass = $pluginOptions['browseClass'] ?? 'btn btn-primary';
	$showRemove = $pluginOptions['fileActionSettings']['showRemove'] ?? 'true';
	$showZoom = $pluginOptions['fileActionSettings']['showZoom'] ?? 'true';
	$removeClass = $pluginOptions['fileActionSettings']['removeClass'] ?? 'btn btn-outline-danger btn-sm';
	$zoomClass = $pluginOptions['fileActionSettings']['zoomClass'] ?? 'btn btn-outline-secondary btn-sm';
	
	$defaultFilePath = config('larapen.media.picture');
	$defaultFileUrl = thumbParam($defaultFilePath)->url();
	
	$dotSepName = arrayFieldToDotNotation($name);
	$id = !empty($id) ? $id : str_replace('.', '-', $dotSepName);
	
	$value = $value ?? ($default ?? null);
	// $value = old($dotSepName, $value);
	
	// error
	$errorBag ??= new ViewErrorBag;
	
	$fiMultipleClass = $isHorizontal ? 'mb-3 row' : 'mb-3 col-md-12';
	$wrapper = \App\Helpers\Common\Html\HtmlAttr::append($wrapper, 'class', $fiMultipleClass);
	if ($rtl == 'true') {
		$wrapper['dir'] ??= 'rtl';
	}
	
	$attributes = \App\Helpers\Common\Html\HtmlAttr::append($attributes, 'class', 'file fileinput-multiple');
?>
<div <?php echo $__env->make('helpers.forms.attributes.field-wrapper', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>>
	<?php echo $__env->make('helpers.forms.partials.label', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	<?php if($isHorizontal): ?>
		<div class="<?php echo e($colField); ?>">
			<?php endif; ?>
			
			<?php if(!empty($value)): ?>
				<?php for($i = 1; $i <= $limit; $i++): ?>
					<?php
						$fileError = $errorBag->has("$name.$i") ? ' is-invalid' : '';
						$fileId = $value[$i]['id'] ?? $i;
						$placeholderUpdated = str_replace(['{index}', '{id}', '{key}'], $i, $placeholder);
						$phStr = !empty($placeholder) ? ' data-msg-placeholder="' . $placeholderUpdated . '"' : '';
					?>
					<div class="mb-2<?php echo e($fileError); ?>">
						<div class="file-loading">
							<input
									type="file"
									id="file_<?php echo e("{$name}_$i"); ?>"
									name="<?php echo e($name); ?>[<?php echo e($fileId); ?>]"<?php echo $phStr; ?>

									<?php echo $__env->make('helpers.forms.attributes.field', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							>
						</div>
					</div>
				<?php endfor; ?>
			<?php else: ?>
				<?php for($i = 1; $i <= $limit; $i++): ?>
					<?php
						$fileError = $errorBag->has("$name.$i") ? ' is-invalid' : '';
						$placeholderUpdated = str_replace(['{index}', '{id}', '{key}'], $i, $placeholder);
						$phStr = !empty($placeholder) ? ' data-msg-placeholder="' . $placeholderUpdated . '"' : '';
					?>
					<div class="mb-2<?php echo e($fileError); ?>">
						<div class="file-loading">
							<input
									type="file"
									id="file_<?php echo e("{$name}_$i"); ?>"
									name="<?php echo e($name); ?>[]"<?php echo $phStr; ?>

									<?php echo $__env->make('helpers.forms.attributes.field', ['defaultClass' => 'file fileinput-multiple'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							>
						</div>
					</div>
				<?php endfor; ?>
			<?php endif; ?>
			
			<?php echo $__env->make('helpers.forms.partials.hint', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<?php echo $__env->make('helpers.forms.partials.validation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			
			<?php if($isHorizontal): ?>
		</div>
	<?php endif; ?>
</div>
<?php echo $__env->make('helpers.forms.partials.newline', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
	$viewName = str($viewName)->replace('-', '_')->toString();
	$pluginBasePath = 'assets/plugins/bootstrap-fileinput/';
	$pluginFullPath = public_path($pluginBasePath);
?>



<?php if (! $__env->hasRenderedOnce('6ec99a49-c83b-441d-b3b2-82f3fb3b9ece')): $__env->markAsRenderedOnce('6ec99a49-c83b-441d-b3b2-82f3fb3b9ece');
$__env->startPush("fileinput_assets_styles"); ?>
	<link href="<?php echo e(url($pluginBasePath . 'css/fileinput.min.css')); ?>" rel="stylesheet">
	<?php if($rtl == 'true'): ?>
		<link href="<?php echo e(url($pluginBasePath . 'css/fileinput-rtl.min.css')); ?>" rel="stylesheet">
	<?php endif; ?>
	<?php if(str_starts_with($theme, 'explorer')): ?>
		<link href="<?php echo e(url($pluginBasePath . 'themes/' . $theme . '/theme.min.css')); ?>" rel="stylesheet">
	<?php endif; ?>
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
		.file-loading:before {
			content: " <?php echo e($fileLoadingMessage); ?>";
		}
	</style>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('17092788-f8ff-4a00-8983-07046656dc68')): $__env->markAsRenderedOnce('17092788-f8ff-4a00-8983-07046656dc68');
$__env->startPush("fileinput_assets_scripts"); ?>
	<script src="<?php echo e(url($pluginBasePath . 'js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url($pluginBasePath . 'js/fileinput.min.js')); ?>" type="text/javascript"></script>
	<?php if(file_exists($pluginFullPath . 'themes/' . $theme . '/theme.js')): ?>
		<script src="<?php echo e(url($pluginBasePath . 'themes/' . $theme . '/theme.js')); ?>" type="text/javascript"></script>
	<?php endif; ?>
	<script src="<?php echo e(url('common/js/fileinput/locales/' . $language . '.js')); ?>" type="text/javascript"></script>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('84ae37be-de3e-47a6-b34c-597f6908833e')): $__env->markAsRenderedOnce('84ae37be-de3e-47a6-b34c-597f6908833e');
$__env->startPush("fileinput_preview_frame_assets_styles"); ?>
	<style>
		
		.krajee-default.file-preview-frame .kv-file-content {
			height: auto;
		}
		.krajee-default.file-preview-frame .file-thumbnail-footer {
			height: 30px;
		}
	</style>
<?php $__env->stopPush(); endif; ?>


<?php $__env->startPush("{$viewName}_helper_scripts"); ?>
	<script>
		
		var fiOptions = {};
		fiOptions.theme = '<?php echo e($theme); ?>';
		fiOptions.language = '<?php echo e($language); ?>';
		fiOptions.rtl = <?php echo e($rtl); ?>;
		fiOptions.showClose = <?php echo e($showClose); ?>;
		fiOptions.showUpload = false;
		fiOptions.showRemove = false;
		fiOptions.showCaption = <?php echo e($showCaption); ?>; 
		fiOptions.showBrowse = <?php echo e($showBrowse); ?>; 
		fiOptions.browseClass = '<?php echo e($browseClass); ?>';
		
		fiOptions.showPreview = <?php echo e($showPreview); ?>;
		fiOptions.dropZoneEnabled = <?php echo e($dropZoneEnabled); ?>;
		fiOptions.browseOnZoneClick = <?php echo e($browseOnZoneClick); ?>;
		fiOptions.overwriteInitial = true;
		fiOptions.previewFileType = 'image';
		fiOptions.allowedFileExtensions = <?php echo collect($allowedFileExtensions)->toJson(); ?>;
		fiOptions.minFileSize = <?php echo e((int)$minFileSize); ?>;
		fiOptions.maxFileSize = <?php echo e((int)$maxFileSize); ?>;
		fiOptions.minFileCount = 0;
		fiOptions.maxFileCount = 1;
		fiOptions.validateInitialCount = true;
		
		<?php if($showPreview == 'true'): ?>
			fiOptions.fileActionSettings = {
				showDrag: false,
				showUpload: false,
				showRotate: false,
				showRemove: <?php echo e($showRemove); ?>,
				showZoom: <?php echo e($showZoom); ?>,
				removeClass: '<?php echo e($removeClass); ?>',
				zoomClass: '<?php echo e($zoomClass); ?>',
			};
		<?php endif; ?>
		
		onDocumentReady((event) => {
			<?php if(!empty($dropZoneTitle)): ?>
				$.fn.fileinputLocales['<?php echo e($language); ?>'].dropZoneTitle = '<?php echo $dropZoneTitle; ?>';
			<?php endif; ?>
			
			<?php if(!empty($value) && $limit > 0): ?>
				<?php for($i = 1; $i <= $limit; $i++): ?>
					
					fiOptions.initialPreview = [];
					fiOptions.initialPreviewConfig = [];
					
					<?php
						$file = $value[$i] ?? null;
					?>
					<?php if(!empty($file) && is_array($file)): ?>
						<?php
							$key = getAsString($file['key'] ?? $i, $i);
							$filePath = getAsStringOrNull($file['path'] ?? null);
							$fileUrl = getAsStringOrNull($file['url'] ?? null);
						?>
						<?php if(!empty($filePath) && Storage::disk($diskName)->exists($filePath)): ?>
							<?php
								if (empty($fileUrl)) {
									$fileUrl = rescue(fn () => Storage::disk($diskName)->url($filePath));
								}
								$fileSize = rescue(fn () => Storage::disk($diskName)->size($filePath), 0);
								$fileUrl = $fileUrl ?? $defaultFileUrl;
								$deleteUrl = str_replace(['{index}', '{id}', '{key}'], $key, $deleteUrlPattern);
							?>
							fiOptions.initialPreview[0] = '<img src="<?php echo e($fileUrl); ?>" class="file-preview-image">';
							fiOptions.initialPreviewConfig[0] = {};
							fiOptions.initialPreviewConfig[0].key = <?php echo e((int)$key); ?>;
							fiOptions.initialPreviewConfig[0].caption = '<?php echo e(basename($filePath)); ?>';
							fiOptions.initialPreviewConfig[0].size = <?php echo e($fileSize); ?>;
							fiOptions.initialPreviewConfig[0].url = '<?php echo e($deleteUrl); ?>';
						<?php endif; ?>
					<?php endif; ?>
					
					var fileinputElSelector = 'input[name="<?php echo e($name); ?>[<?php echo e($i); ?>]"]';
					var fileinputEl = $(fileinputElSelector);
					
					if (fileinputEl.length) {
						
						fileinputEl.fileinput(fiOptions);
						
						
						fileinputEl.on('filepredelete', (event, key, jqXHR, data) => {
							const deleteFileConfirmQuestion = "<?php echo e($deleteConfirmQuestion); ?>";
							return !confirm(deleteFileConfirmQuestion);
						});
					}
				<?php endfor; ?>
			<?php else: ?>
				
				$('input[name^="<?php echo e($name); ?>["]').fileinput(fiOptions);
			<?php endif; ?>
		});
	</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/fields/fileinput-multiple.blade.php ENDPATH**/ ?>