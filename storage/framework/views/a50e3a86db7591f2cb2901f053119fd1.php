



<?php
	use App\Helpers\Common\Files\Storage\StorageDisk;
	use Illuminate\Support\Facades\Storage;
	
	$layout ??= 'default'; // default, horizontal
	$isHorizontal = false; // force to false
	
	$viewName = 'fileinput-ajax-multiple';
	$type = 'file';
	$label ??= null;
	$labelClass ??= '';
	$id ??= null;
	$name ??= null;
	$value ??= null; // e.g. array of: [key => 1, 'path' => 'path/to/file.ext', 'url' => 'https://domain/file.ext'],
	$default ??= null; // e.g. array of: [key => 1, 'path' => 'path/to/file.ext', 'url' => 'https://domain/file.ext'],
	$placeholder ??= null;
	$required ??= false;
	$hint ??= null;
	$attributes ??= [];
	
	$wrapper ??= [];
	$diskName ??= StorageDisk::getDiskName();
	$fileLoadingMessage ??= t('loading_wd');
	$limit = $pluginOptions['limit'] ?? 5;
	$deleteUrlPattern ??= '/';
	$reorderUrl ??= '/';
	$previewFrameWidth ??= null;
	$previewFrameHeight ??= null;
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
	$dropZoneTitle = $pluginOptions['dropZoneTitle'] ?? null;
	
	$browseClass = $pluginOptions['browseClass'] ?? 'btn btn-primary';
	$showRemove = $pluginOptions['fileActionSettings']['showRemove'] ?? 'true';
	$showZoom = $pluginOptions['fileActionSettings']['showZoom'] ?? 'true';
	$removeClass = $pluginOptions['fileActionSettings']['removeClass'] ?? 'btn btn-outline-danger btn-sm';
	$zoomClass = $pluginOptions['fileActionSettings']['zoomClass'] ?? 'btn btn-outline-secondary btn-sm';
	
	$uploadUrl = $pluginOptions['uploadUrl'] ?? '/';
	$_method = (!empty($_method) && in_array($_method, ['POST', 'PUT'])) ? $_method : 'POST';
	$uploadExtraData = $pluginOptions['uploadExtraData'] ?? ['_token' => csrf_token(), '_method' => $_method];
	$elSuccessContainer = $pluginOptions['elSuccessContainer'] ?? '#uploadSuccess';
	$elErrorContainer = $pluginOptions['elErrorContainer'] ?? '#uploadError';
	$msgErrorClass = $pluginOptions['msgErrorClass'] ?? 'alert alert-block alert-danger';
	
	$defaultKey = generateRandomString(type: 'numeric');
	$defaultFilePath = config('larapen.media.picture');
	$defaultFileUrl = thumbParam($defaultFilePath)->url();
	
	// Get steps URLs & labels
	$nextStepUrl ??= '/';
	$nextStepLabel ??= t('submit');
	
	$wrapper['class'] ??= $isHorizontal ? 'mb-3 row' : 'mb-3 col-md-12';
	if ($rtl == 'true') {
		$wrapper['dir'] = 'rtl';
	}
	
	$dotSepName = arrayFieldToDotNotation($name);
	$id = !empty($id) ? $id : str_replace('.', '-', $dotSepName);
	
	$value = $value ?? ($default ?? []);
	// $value = old($dotSepName, $value);
	
	// file-preview-frame
	$defaultPreviewFrameWidth = 186; // D(228) / 5(186) / 4(241);
	$defaultPreviewFrameHeight = 216; // D(264) / 5(216) / 4(281);
	$previewFrameWidth = (!empty($previewFrameWidth) && is_integer($previewFrameWidth)) ? $previewFrameWidth : $defaultPreviewFrameWidth;
	$previewFrameHeight = (!empty($previewFrameHeight) && is_integer($previewFrameHeight)) ? $previewFrameHeight : $defaultPreviewFrameHeight;
	
	$labelClass = !empty($labelClass) ? " $labelClass" : '';
	
	$attributes = \App\Helpers\Common\Html\HtmlAttr::append($attributes, 'class', 'file');
?>
<div <?php echo $__env->make('helpers.forms.attributes.field-wrapper', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>>
	<?php if(!$isHorizontal): ?>
		<div class="row">
			<?php endif; ?>
			<div class="col-md-12 form-label<?php echo e($labelClass); ?>">
				<?php echo $label; ?>

				<?php if($required): ?>
					<span class="text-danger ms-1">*</span>
				<?php endif; ?>
			</div>
			<div class="col-md-12 text-center pt-2" style="position: relative; float: <?php echo ($rtl == 'true') ? 'left' : 'right'; ?>;">
				<div <?php echo ($rtl == 'true') ? 'dir="rtl"' : ''; ?> class="file-loading">
					<input
							type="file"
							id="dz_<?php echo e($id); ?>"
							name="<?php echo e($name); ?>[]"
							multiple
							<?php echo $__env->make('helpers.forms.attributes.field', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
					>
				</div>
				
				<?php echo $__env->make('helpers.forms.partials.hint', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			</div>
			<?php if(!$isHorizontal): ?>
		</div>
	<?php endif; ?>
</div>
<?php echo $__env->make('helpers.forms.partials.newline', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
	$viewName = str($viewName)->replace('-', '_')->toString();
	$pluginBasePath = 'assets/plugins/bootstrap-fileinput/';
	$pluginFullPath = public_path($pluginBasePath);
?>



<?php if (! $__env->hasRenderedOnce('631e37bc-be22-41aa-8035-ad2dcc810727')): $__env->markAsRenderedOnce('631e37bc-be22-41aa-8035-ad2dcc810727');
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

<?php if (! $__env->hasRenderedOnce('32d2dcc1-f3db-40cc-a7e7-991f1edbf0d3')): $__env->markAsRenderedOnce('32d2dcc1-f3db-40cc-a7e7-991f1edbf0d3');
$__env->startPush("fileinput_assets_scripts"); ?>
	<script src="<?php echo e(url($pluginBasePath . 'js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url($pluginBasePath . 'js/fileinput.min.js')); ?>" type="text/javascript"></script>
	<?php if(file_exists($pluginFullPath . 'themes/' . $theme . '/theme.js')): ?>
		<script src="<?php echo e(url($pluginBasePath . 'themes/' . $theme . '/theme.js')); ?>" type="text/javascript"></script>
	<?php endif; ?>
	<script src="<?php echo e(url('common/js/fileinput/locales/' . $language . '.js')); ?>" type="text/javascript"></script>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('c8992c25-79ca-4e56-88b6-1d4cf8014825')): $__env->markAsRenderedOnce('c8992c25-79ca-4e56-88b6-1d4cf8014825');
$__env->startPush("{$viewName}_assets_styles"); ?>
	<style>
		.file-drop-zone .krajee-default.file-preview-frame .kv-file-content,
		.file-drop-zone .krajee-default.file-preview-frame .kv-file-content img.file-preview-image {
			width: <?php echo e($previewFrameWidth); ?>px !important;
			height: auto;
			max-height: <?php echo e($previewFrameHeight); ?>px !important;
		}
		
		.file-drop-zone .kv-file-content img.file-preview-image {
			cursor: pointer;
		}
	</style>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('6259ba43-ba82-40b0-bfac-874e5da9d381')): $__env->markAsRenderedOnce('6259ba43-ba82-40b0-bfac-874e5da9d381');
$__env->startPush("{$viewName}_assets_scripts"); ?>
	<script>
		/**
		 * Reorder (Sort) pictures
		 * @param params
		 * @param reorderUrl
		 * @param {string} elSuccessContainer
		 * @param {string} elErrorContainer
		 * @returns {boolean}
		 */
		function reorderPictures(params, reorderUrl, elSuccessContainer, elErrorContainer)
		{
			if (typeof params.stack === 'undefined') {
				return false;
			}
			if (typeof reorderUrl === 'undefined') {
				return false;
			}
			
			/* Unselect any text on the page */
			window.getSelection().removeAllRanges();
			
			/* Un-focus active element */
			if (document.activeElement) {
				document.activeElement.blur();
			}
			
			showWaitingDialog();
			
			let ajax = $.ajax({
				method: 'POST',
				url: reorderUrl,
				data: {
					'params': params,
					'_token': $('input[name=_token]').val()
				}
			});
			ajax.done(function(data) {
				
				hideWaitingDialog();
				
				if (typeof data.status === 'undefined') {
					return false;
				}
				
				const status = parseInt(data.status);
				const message = data.message;
				
				/* Reorder Notification */
				if (status === 1) {
					showSuccessMessage(message, elSuccessContainer, elErrorContainer);
					setTimeout(() => completeWaitingDialog(message), 250);
				} else {
					showErrorMessage(message, elSuccessContainer, elErrorContainer);
				}
				
				return false;
			});
			ajax.fail(function (xhr, textStatus, errorThrown) {
				hideWaitingDialog();
				
				let message = getErrorMessageFromXhr(xhr);
				if (message !== null) {
					showErrorMessage(message, elSuccessContainer, elErrorContainer);
				}
			});
			
			return false;
		}
		
		/**
		 * Reorder (Sort) files
		 * @param params
		 * @param reorderUrl
		 * @param {string} elSuccessContainer
		 * @param {string} elErrorContainer
		 * @returns {Promise<boolean>}
		 */
		async function dzReorderFiles(params, reorderUrl, elSuccessContainer, elErrorContainer) {
			if (typeof params.stack === 'undefined') {
				return false;
			}
			if (typeof reorderUrl === 'undefined') {
				return false;
			}
			
			/* Unselect any text on the page */
			window.getSelection().removeAllRanges();
			
			/* Un-focus active element */
			if (document.activeElement) {
				document.activeElement.blur();
			}
			
			showWaitingDialog();
			
			/* Send the reorder request */
			const _tokenEl = document.querySelector('input[name=_token]');
			let data = {
				'params': params,
				'_token': _tokenEl?.value ?? null
			};
			
			try {
				const json = await httpRequest('POST', reorderUrl, data);
				
				hideWaitingDialog();
				
				if (typeof json.status === 'undefined') {
					return false;
				}
				
				const status = parseInt(json.status);
				const message = json.message;
				
				/* Reorder Notification */
				if (status === 1) {
					showSuccessMessage(message, elSuccessContainer, elErrorContainer);
					setTimeout(() => completeWaitingDialog(message), 250);
				} else {
					showErrorMessage(message, elSuccessContainer, elErrorContainer);
				}
			} catch (error) {
				hideWaitingDialog();
				
				const message = getErrorMessage(error);
				if (message !== null) {
					showErrorMessage(message, elSuccessContainer, elErrorContainer);
				}
			}
			return false;
		}
		
		/**
		 * Show Success Message
		 * @param {string} message
		 * @param {string} elSuccessContainer
		 * @param {string} elErrorContainer
		 */
		function showSuccessMessage(message, elSuccessContainer, elErrorContainer) {
			elSuccessContainer.replace(/^#+/, '');
			elErrorContainer.replace(/^#+/, '');
			
			const successEl = document.getElementById(elSuccessContainer);
			const errorEl = document.getElementById(elErrorContainer);
			
			if (errorEl) {
				errorEl.style.display = 'none';
				errorEl.innerHTML = '';
				errorEl.classList.remove('alert', 'alert-block', 'alert-danger');
			}
			
			if (successEl) {
				successEl.innerHTML = '<ul class="mb-0 list-unstyled"></ul>';
				successEl.style.display = 'none';
				successEl.querySelector('ul').innerHTML = message;
				fadeIn(successEl, 'fast'); 
			}
		}
		
		/**
		 * Show Errors Message
		 * @param {string} message
		 * @param {string} elSuccessContainer
		 * @param {string} elErrorContainer
		 */
		function showErrorMessage(message, elSuccessContainer, elErrorContainer) {
			jsAlert(message, 'error', false);
			
			elSuccessContainer.replace(/^#+/, '');
			elErrorContainer.replace(/^#+/, '');
			
			const successEl = document.getElementById(elSuccessContainer);
			const errorEl = document.getElementById(elErrorContainer);
			
			if (successEl) {
				successEl.innerHTML = '';
				successEl.style.display = 'none';
			}
			
			if (errorEl) {
				errorEl.innerHTML = '<ul class="mb-0 list-unstyled"></ul>';
				errorEl.style.display = 'none';
				errorEl.classList.add('alert', 'alert-block', 'alert-danger');
				errorEl.querySelector('ul').innerHTML = message;
				fadeIn(errorEl, 'fast'); 
			}
		}
		
		/**
		 * Fade in an element
		 * @param {HTMLElement} element
		 * @param {string} speed
		 */
		function fadeIn(element, speed) {
			const duration = speed === 'fast' ? 200 : (speed === 'slow' ? 600 : 200);
			element.style.opacity = '0';
			element.style.display = 'block';
			
			let last = +new Date();
			const tick = () => {
				const newOpacity = +element.style.opacity + (new Date() - last) / duration;
				element.style.opacity = newOpacity.toString();
				last = +new Date();
				
				if (newOpacity < 1) {
					(window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16);
				}
			};
			
			tick();
		}
	</script>
<?php $__env->stopPush(); endif; ?>


<?php $__env->startPush("{$viewName}_helper_scripts"); ?>
	<script>
		var elSuccessContainer = '<?php echo e($elSuccessContainer); ?>';
		var elErrorContainer = '<?php echo e($elErrorContainer); ?>';
		var reorderUrl = '<?php echo e($reorderUrl); ?>';
		
		
		var fiOptions = {};
		fiOptions.theme = '<?php echo e($theme); ?>';
		fiOptions.language = '<?php echo e($language); ?>';
		fiOptions.rtl = <?php echo e($rtl); ?>;
		fiOptions.showClose = true;
		fiOptions.showUpload = false;
		fiOptions.showRemove = false;
		fiOptions.showCancel = false;
		fiOptions.showCaption = false; 
		fiOptions.showBrowse = true;
		fiOptions.browseClass = '<?php echo e($browseClass); ?>';
		fiOptions.browseOnZoneClick = true;
		
		fiOptions.uploadUrl = '<?php echo e($uploadUrl); ?>';
		fiOptions.uploadAsync = false;
		fiOptions.uploadExtraData = <?php echo collect($uploadExtraData)->toJson(); ?>;
		fiOptions.elErrorContainer = elErrorContainer;
		fiOptions.msgErrorClass = '<?php echo e($msgErrorClass); ?>';
		
		fiOptions.showPreview = true;
		fiOptions.overwriteInitial = false;
		fiOptions.initialPreviewAsData = true;
		fiOptions.initialPreviewFileType = 'image';
		fiOptions.allowedFileExtensions = <?php echo collect($allowedFileExtensions)->toJson(); ?>;
		fiOptions.minFileSize = <?php echo e((int)$minFileSize); ?>;
		fiOptions.maxFileSize = <?php echo e((int)$maxFileSize); ?>;
		fiOptions.minFileCount = 0;
		fiOptions.maxFileCount = <?php echo e($limit); ?>;
		fiOptions.validateInitialCount = true;
		
		fiOptions.fileActionSettings = {
			showDrag: true,
			showUpload: false,
			showRotate: false,
			showRemove: <?php echo e($showRemove); ?>,
			showZoom: <?php echo e($showZoom); ?>,
			removeClass: '<?php echo e($removeClass); ?>',
			zoomClass: '<?php echo e($zoomClass); ?>',
		};
		
		fiOptions.initialPreview = [];
		fiOptions.initialPreviewConfig = [];
		
		<?php if(!empty($value)): ?>
			<?php
				$idx = 0; // Need to be started by 0 to avoid reorder issue
			?>
			<?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(!empty($file) && is_array($file)): ?>
					<?php
						$key = getAsString($file['key'] ?? $defaultKey, $defaultKey);
						$filePath = getAsStringOrNull($file['path'] ?? null);
						$fileUrl = getAsStringOrNull($file['url'] ?? null);
					?>
					<?php if(!empty($filePath) && Storage::disk($diskName)->exists($filePath)): ?>
						<?php
							if (empty($fileUrl)) {
								// $fileUrl = thumbParam($filePath)->setOption('picture-md')->url();
								// $fileUrl = hasTemporaryPath($filePath) ? rescue(fn () => Storage::disk($diskName)->url($filePath)) : $fileUrl;
								$fileUrl = thumbService($filePath)->resize('picture-md')->url();
							}
							$fileSize = rescue(fn () => Storage::disk($diskName)->size($filePath), 0);
							$fileUrl = $fileUrl ?? $defaultFileUrl;
							$deleteUrl = str_replace(['{index}', '{id}', '{key}'], $key, $deleteUrlPattern);
						?>
						fiOptions.initialPreview[<?php echo e($idx); ?>] = '<?php echo e($fileUrl); ?>';
						fiOptions.initialPreviewConfig[<?php echo e($idx); ?>] = {};
						fiOptions.initialPreviewConfig[<?php echo e($idx); ?>].key = <?php echo e((int)$key); ?>;
						fiOptions.initialPreviewConfig[<?php echo e($idx); ?>].caption = '<?php echo e(basename($filePath)); ?>';
						fiOptions.initialPreviewConfig[<?php echo e($idx); ?>].size = <?php echo e($fileSize); ?>;
						fiOptions.initialPreviewConfig[<?php echo e($idx); ?>].url = '<?php echo e($deleteUrl); ?>';
						<?php
							$idx++; // The indexes must follow each other (i.e.: must be consecutive) to avoid eventual issues
						?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
		
		onDocumentReady((event) => {
			
			const dropzoneFieldEl = $('#dz_<?php echo e($id); ?>');
			dropzoneFieldEl.fileinput(fiOptions);
			
			
			dropzoneFieldEl.on('filebatchpreupload', (event, data) => {
				
				const uploadSuccessEl = $(elSuccessContainer);
				if (uploadSuccessEl.length) {
					uploadSuccessEl.html('<ul class="mb-0 list-unstyled"></ul>').hide();
				}
			});
			
			
			dropzoneFieldEl.on('filebatchselected', (event, files) => {
				
				$(event.target).fileinput('upload');
			});
			
			
			dropzoneFieldEl.on('filebatchuploadsuccess', (event, data) => {
				if (!data.files || data.files.length <= 0) {
					return;
				}
				
				
				const successfulMessage = '<?php echo escapeStringForJs(t('fileinput_file_uploaded_successfully')); ?>';
				
				
				let message = '';
				$.each(data.files, (key, file) => {
					if (typeof file !== 'undefined') {
						let fileName = file.name;
						fileName = `<strong>${fileName}</strong>`;
						
						let fileMessage = `<li class="lh-lg"><i class="bi bi-check-lg me-1"></i>${successfulMessage}</li>`;
						fileMessage = fileMessage.replace('{fileName}', fileName);
						
						message = message + fileMessage;
					}
				});
				
				
				let uploadSuccessEl = $(elSuccessContainer);
				if (uploadSuccessEl.length) {
					uploadSuccessEl.find('ul').append(message);
					uploadSuccessEl.fadeIn('slow');
				}
				
				
				const delay = 1000;
				setTimeout(() => {
					const progressBarEl = $('.kv-upload-progress.kv-hidden');
					if (progressBarEl.length) {
						progressBarEl.hide();
					}
				}, delay);
				
				
				const nextStepActionEl = $('#nextStepAction');
				if (nextStepActionEl.length) {
					nextStepActionEl.html('<?php echo $nextStepLabel; ?>').removeClass('btn-secondary').addClass('btn-primary');
				}
			});
			
			
			dropzoneFieldEl.on('filebatchuploaderror', (event, data, errorMessage) => {
				showErrorMessage(errorMessage, elSuccessContainer, elErrorContainer);
			});
			
			
			dropzoneFieldEl.on('filepredelete', (event, key, jqXHR, data) => {
				const deleteFileConfirmQuestion = "<?php echo e(t('confirm_picture_deletion')); ?>";
				return !confirm(deleteFileConfirmQuestion);
			});
			
			
			dropzoneFieldEl.on('filedeleted', (event, key, jqXHR, data) => {
				if (typeof jqXHR.responseJSON === 'undefined') {
					return false;
				}
				
				let obj = jqXHR.responseJSON;
				if (typeof obj.status === 'undefined' || typeof obj.message === 'undefined') {
					return false;
				}
				
				
				if (parseInt(obj.status) === 1) {
					showSuccessMessage(obj.message, elSuccessContainer, elErrorContainer);
				} else {
					showErrorMessage(obj.message, elSuccessContainer, elErrorContainer);
				}
			});
			
			
			dropzoneFieldEl.on('filedeleteerror', (event, data, errorMessage) => {
				showErrorMessage(errorMessage, elSuccessContainer, elErrorContainer);
			});
			
			
			dropzoneFieldEl.on('filesorted', (event, params) => {
				dzReorderFiles(params, reorderUrl, elSuccessContainer, elErrorContainer);
			});
			
			
			
			
			const thumbnailsImgSelector = '.file-drop-zone .kv-file-content img.file-preview-image';
			$(document).on('click', thumbnailsImgSelector, function () {
				const thumbnailEl = this.closest('.file-preview-frame');
				if (thumbnailEl) {
					dropzoneFieldEl.fileinput('zoom', $(thumbnailEl).attr('id'));
				}
			});
		});
	</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/helpers/forms/fields/fileinput-ajax-multiple.blade.php ENDPATH**/ ?>