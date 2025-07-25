<?php
    $apiResult ??= [];
	$threads = (array)data_get($apiResult, 'data');
	$totalThreads = (int)data_get($apiResult, 'meta.total', 0);
?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('front.common.spacer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="main-container">
        <div class="container">
            <div class="row">
                
                <div class="col-md-3">
                    <?php echo $__env->make('front.account.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
                
                <div class="col-md-9">
                    <div class="container border rounded bg-body-tertiary p-4 p-lg-3 p-md-2">
                        <h3 class="fw-bold border-bottom pb-3 mb-4">
                            <i class="bi bi-chat-text"></i> <?php echo e(t('inbox')); ?>

                        </h3>
                        
                        <?php if(session()->has('flash_notification')): ?>
                            <div class="row">
                                <div class="col-12">
                                    <?php echo $__env->make('flash::message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div id="successMsg" class="alert alert-success d-none" role="alert"></div>
                        <div id="errorMsg" class="alert alert-danger d-none" role="alert"></div>
                        
                        <div class="">
                            <div class="row mb-3">
                                <?php echo csrf_field(); ?>
                                
                                <div class="col-md-3 col-lg-2">
                                    <div class="btn-group d-md-inline-block d-sm-none d-none"></div>
                                </div>
                                
                                <div class="col-md-9 col-lg-10 d-flex justify-content-between">
                                    <div class="btn-group d-md-none d-sm-inline-block">
                                        <a href="#" class="btn btn-primary text-uppercase">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </div>
                                    
                                    <div class="d-md-inline-block d-sm-none d-none">
                                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                            <button type="button" class="btn btn-outline-primary">
                                                <input type="checkbox" id="form-check-all">
                                            </button>
                                            
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="dropdown-menu-sort-selected"><?php echo e(t('action')); ?></span>
                                                </button>
                                                <ul id="groupedAction" class="dropdown-menu dropdown-menu-sort">
                                                    <li>
                                                        <a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/messages/actions?type=markAsRead')); ?>"
                                                           class="dropdown-item"
                                                        >
                                                            <?php echo e(t('Mark as read')); ?>

                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/messages/actions?type=markAsUnread')); ?>"
                                                           class="dropdown-item"
                                                        >
                                                            <?php echo e(t('Mark as unread')); ?>

                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/messages/actions?type=markAsImportant')); ?>"
                                                           class="dropdown-item"
                                                        >
                                                            <?php echo e(t('Mark as important')); ?>

                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/messages/actions?type=markAsNotImportant')); ?>"
                                                           class="dropdown-item"
                                                        >
                                                            <?php echo e(t('Mark as not important')); ?>

                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/messages/delete')); ?>"
                                                           class="dropdown-item"
                                                        >
                                                            <?php echo e(t('Delete')); ?>

                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <button type="button"
                                                    id="btnRefresh"
                                                    class="btn btn-outline-primary"
                                                    data-bs-toggle="tooltip"
                                                    title="<?php echo e(t('refresh')); ?>"
                                            >
                                                <span class="fa-solid fa-rotate"></span>
                                            </button>
                                            
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <?php echo e(t('more')); ?>

                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="" class="dropdown-item markAllAsRead"><?php echo e(t('Mark all as read')); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="message-tool-bar-right d-flex align-items-center" id="linksThreads">
                                        <?php echo $__env->make('front.account.messenger.threads.links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <?php echo $__env->make('front.account.messenger.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                
                                <div class="col-md-9 col-lg-10 message-list">
                                    <div class="container border rounded bg-body py-2" id="listThreads">
                                        <?php echo $__env->make('front.account.messenger.threads.threads', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script>
        var loadingImage = '<?php echo e(url('images/spinners/fading-line.gif')); ?>';
        var loadingErrorMessage = '<?php echo e(t('Threads could not be loaded')); ?>';
        var actionText = '<?php echo e(t('action')); ?>';
        var actionErrorMessage = '<?php echo e(t('This action could not be done')); ?>';
        var title = {
            'seen': '<?php echo e(t('Mark as read')); ?>',
            'notSeen': '<?php echo e(t('Mark as unread')); ?>',
            'important': '<?php echo e(t('Mark as important')); ?>',
            'notImportant': '<?php echo e(t('Mark as not important')); ?>',
        };
	</script>
    <script src="<?php echo e(url('assets/js/app/messenger.js')); ?>" type="text/javascript"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/front/account/messenger/index.blade.php ENDPATH**/ ?>