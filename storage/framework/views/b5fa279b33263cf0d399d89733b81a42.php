<?php
    use App\Http\Controllers\Web\Admin\Panel\Library\Panel;
	use Illuminate\Database\Eloquent\Model;
	
    /** @var Panel $xPanel */
    $xPanel ??= null;
	
	/** @var Model $entry */
	$entry ??= null;
	
    $editUri = $xPanel->route . '/' . $entry->getKey() . '/edit';
    
    $modelTable = $xPanel->getModel()->getTable();
    $settingsTables = ['settings', 'sections', 'domain_settings', 'domain_sections'];
    $isSettingsModel = in_array($modelTable, $settingsTables);
    $isNotSettingsModel = !$isSettingsModel;
?>
<?php $__env->startSection('header'); ?>
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h2 class="mb-0">
                <span class="text-capitalize"><?php echo $xPanel->entityNamePlural; ?></span>
                <small><?php echo e(trans('admin.edit')); ?> <?php echo $xPanel->entityName; ?></small>
            </h2>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="<?php echo e(urlGen()->adminUrl()); ?>"><?php echo e(trans('admin.dashboard')); ?></a></li>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(url($xPanel->route)); ?>" class="text-capitalize"><?php echo $xPanel->entityNamePlural; ?></a>
                </li>
                <li class="breadcrumb-item active d-flex align-items-center"><?php echo e(trans('admin.edit')); ?></li>
            </ol>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="flex-row d-flex justify-content-center">
        <?php
            $colMd = config('settings.style.admin_boxed_layout') == '1' ? ' col-md-12' : ' col-md-9';
			$settingsClass = $isSettingsModel ? ' settings-edition' : '';
        ?>
        <div class="col-sm-12<?php echo e($colMd); ?>">
            <div class="row">
                <div class="col-lg-6">
                    <?php if($xPanel->hasAccess('list')): ?>
                        <a href="<?php echo e(url($xPanel->route)); ?>" class="btn btn-primary shadow">
                            <i class="fa-solid fa-angles-left"></i> <?php echo e(trans('admin.back_to_all')); ?>

                            <span class="text-lowercase"></span>
                        </a>
                        <br><br>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6 text-end">
                    <?php if($xPanel->model->translationEnabled()): ?>
                        <?php
                            $availableLocales = $xPanel->model->getAvailableLocales();
                            $appLocale = app()->getLocale();
                            $selectedLocale = $availableLocales[request()->input('locale', $appLocale)] ?? $appLocale;
                        ?>
                        <div class="btn-group">
                            <button type="button"
                                    class="btn btn-primary shadow dropdown-toggle"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                            >
                                <?php echo e(trans('admin.Language')); ?>: <?php echo e($selectedLocale); ?> &nbsp;<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <?php $__currentLoopData = $availableLocales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item ps-3 pe-3 pt-1 pb-1" href="<?php echo e(url($editUri)); ?>?locale=<?php echo e($key); ?>">
                                        <?php echo e($locale); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php
                $updateUrl = url($xPanel->route . '/' . $entry->getKey());
            ?>
            <?php if($xPanel->hasUploadFields('update', $entry->getKey())): ?>
                <?php echo e(html()->form('PUT', $updateUrl)->acceptsFiles()->attribute('novalidate', true)->open()); ?>

            <?php else: ?>
                <?php echo e(html()->form('PUT', $updateUrl)->attribute('novalidate', true)->open()); ?>

            <?php endif; ?>
            <div class="card border-top border-primary<?php echo e($settingsClass); ?>">
                
                <?php if($isNotSettingsModel): ?>
                    <div class="card-header">
                        <h3 class="mb-0"><?php echo e(trans('admin.edit')); ?></h3>
                    </div>
				<?php endif; ?>
                <div class="card-body">
                    
                    <?php
                        $form = 'update';
                    ?>
                    <?php if(view()->exists('vendor.admin.panel.' . $xPanel->entityName . '.form_content')): ?>
                        <?php echo $__env->make('vendor.admin.panel.' . $xPanel->entityName . '.form_content', [
							'form'   => $form,
			                'fields' => $xPanel->getFields($form, $entry->getKey())
                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php elseif(view()->exists('vendor.admin.panel.form_content')): ?>
                        <?php echo $__env->make('vendor.admin.panel.form_content', [
							'form'   => $form,
							'fields' => $xPanel->getFields($form, $entry->getKey())
                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php else: ?>
                        <?php echo $__env->make('admin.panel.form_content', [
							'form'   => $form,
							'fields' => $xPanel->getFields($form, $entry->getKey())
                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
					<?php echo $__env->make('admin.panel.inc.form_save_buttons', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
                
            </div>
            <?php echo e(html()->form()->close()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/admin/panel/edit.blade.php ENDPATH**/ ?>