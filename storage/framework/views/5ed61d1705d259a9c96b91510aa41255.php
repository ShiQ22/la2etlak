<?php $__env->startSection('wizard'); ?>
    <?php echo $__env->make('front.post.createOrEdit.multiSteps.partials.wizard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php
	$picturesLimit ??= 0;
	$picturesLimit = is_numeric($picturesLimit) ? $picturesLimit : 0;
	$picturesLimit = ($picturesLimit > 0) ? $picturesLimit : 1;
	
	// Get the listing pictures (by applying the picture limit)
	$pictures = $picturesInput ?? [];
	$pictures = collect($pictures)->slice(0, $picturesLimit)->all();
	
	// Get steps URLs & labels
	$previousStepUrl ??= null;
	$previousStepLabel ??= null;
	$formActionUrl ??= request()->fullUrl();
	$nextStepUrl ??= '/';
	$nextStepLabel ??= t('submit');
?>
<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('front.common.spacer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="main-container">
        <div class="container">
            <div class="row">
    
                <?php echo $__env->make('front.post.partials.notification', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                
                <div class="col-md-12">
                    <div class="container border rounded bg-body-tertiary p-4 p-lg-3 p-md-2 mb-sm-3">
						
                        <h3 class="fw-bold border-bottom pb-3 mb-4">
							<i class="fa-solid fa-camera"></i> <?php echo e(t('Photos')); ?>

						</h3>
						
                        <div class="row">
                            <div class="col-md-12">
                                <form id="payableForm"
                                      action="<?php echo e($formActionUrl); ?>"
                                      method="POST"
                                      enctype="multipart/form-data"
                                      onsubmit="actionButton.disabled = true; return true;"
                                >
	                                <?php echo csrf_field(); ?>
                                    <fieldset>
                                        <?php if($picturesLimit > 0): ?>
											
	                                        <?php
		                                        $picturesRequired = (config('settings.listing_form.picture_mandatory') == '1');
												
												$savedPictures = collect($pictures)->map(function ($filePath, $key) {
													// $url = thumbParam($filePath)->setOption('picture-md')->url();
													// $url = hasTemporaryPath($filePath) ? $disk->url($filePath) : $url;
													$url = thumbService($filePath)->resize('picture-md')->url();
													
													return [
														'key'  => $key,
														'path' => $filePath,
														'url'  => $url,
													];
												})->toArray();
												
												$uploadUrl = url('posts/create/photos');
												$uploadUrl = urlQuery($uploadUrl)->setParameters(request()->only(['packageId']))->toString();
												$deleteUrlPattern = url('posts/create/photos/{id}/delete');
												$reorderUrl = url('posts/create/photos/reorder');
												
												$picturesHint = t('add_up_to_x_pictures_text', ['pictures_number' => $picturesLimit]);
												$picturesHint .= '<br>' . t('file_types', ['file_types' => getAllowedFileFormatsHint('image')]);
	                                        ?>
		                                    <?php echo $__env->make('helpers.forms.fields.fileinput-ajax-multiple', [
												'name'       => 'pictures',
												'label'      => t('pictures'),
												'labelClass' => 'fw-bold',
												'required'   => $picturesRequired,
												'attributes' => ['accept' => 'image/*'],
												'value'      => $savedPictures,
												'hint'       => $picturesHint,
												'limit'      => $picturesLimit,
												'pluginOptions'    => [
													'uploadUrl' => $uploadUrl,
												],
												'reorderUrl'       => $reorderUrl,
												'deleteUrlPattern' => $deleteUrlPattern,
												'nextStepLabel'    => $nextStepLabel,
											], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                        <?php endif; ?>
	                                    
                                        <div id="uploadError" class="mt-2" style="display: none;"></div>
                                        <div id="uploadSuccess" class="alert alert-success fade show mt-2" style="display: none;"></div>
	
                                        
                                        <div class="row mt-4">
                                            <div class="col-md-6 mb-md-0 mb-2 text-start d-grid">
												<a href="<?php echo e($previousStepUrl); ?>" class="btn btn-secondary btn-lg">
													<?php echo $previousStepLabel; ?>

												</a>
                                            </div>
	                                        <div class="col-md-6 mb-md-0 mb-2 text-end d-grid">
												<button id="nextStepBtn" name="actionButton" class="btn btn-primary btn-lg">
													<?php echo $nextStepLabel; ?>

												</button>
                                            </div>
                                        </div>
                                    	
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
	
	<?php echo $__env->renderWhen(!auth()->check(), 'auth.login.partials.modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/front/post/createOrEdit/multiSteps/create/photos.blade.php ENDPATH**/ ?>