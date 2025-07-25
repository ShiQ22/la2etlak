<?php
    $authUser = auth()->check() ? auth()->user() : null;
	$authUserId = !empty($authUser) ? $authUser->getAuthIdentifier() : 0;
	
	$thread ??= [];
	$threadId = data_get($thread, 'id', 0);
	
    $fiTheme = config('larapen.core.fileinput.theme', 'bs5');
	$allowedFileFormatsJson = collect(getAllowedFileFormats())->toJson();
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
                        <h2 class="fw-bold border-bottom pb-3 mb-4">
                            <i class="bi bi-chat-text"></i> <?php echo e(t('inbox')); ?>

                        </h2>
    
                        <?php if(session()->has('flash_notification')): ?>
                            <div class="row">
                                <div class="col-12">
                                    <?php echo $__env->make('flash::message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(isset($errors) && $errors->any()): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="mb-0"><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <div id="successMsg" class="alert alert-success d-none" role="alert"></div>
                        <div id="errorMsg" class="alert alert-danger d-none" role="alert"></div>
                        
                        <div class="container px-0">
                            <div class="row mb-2">
                                <div class="col-md-12 col-lg-12">
                                    <div class="d-flex justify-content-between user-bar-top">
                                        <div class="fs-5">
                                            <p>
                                                <a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/messages')); ?>" class="<?php echo e(linkClass()); ?>">
                                                    <i class="fa-solid fa-inbox"></i>
                                                </a>&nbsp;
                                                <?php if($authUserId != data_get($thread, 'p_creator.id')): ?>
                                                    <a href="<?php echo e(urlGen()->user(data_get($thread, 'p_creator'))); ?>" class="<?php echo e(linkClass()); ?>">
                                                        <?php if(isUserOnline(data_get($thread, 'p_creator'))): ?>
                                                            <i class="fa-solid fa-circle text-success"></i>&nbsp;
                                                        <?php endif; ?>
                                                        <span>
                                                            <?php echo e(data_get($thread, 'p_creator.name')); ?>

                                                        </span>
                                                    </a>
                                                <?php endif; ?>
                                                <span><?php echo e(t('Contact request about')); ?></span>
                                                <a href="<?php echo e(urlGen()->post(data_get($thread, 'post'))); ?>" class="<?php echo e(linkClass()); ?>">
                                                    <?php echo e(data_get($thread, 'post.title')); ?>

                                                </a>
                                            </p>
                                        </div>
                                        
                                        <div class="call-xhr-action">
                                            <div class="btn-group btn-group-sm">
                                                <?php if(data_get($thread, 'p_is_important')): ?>
                                                    <a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/messages/' . $threadId . '/actions?type=markAsNotImportant')); ?>"
                                                       class="btn btn-outline-primary markAsNotImportant"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-placement="top"
                                                       title="<?php echo e(t('Mark as not important')); ?>"
                                                    >
                                                        <i class="fa-solid fa-star"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/messages/' . $threadId . '/actions?type=markAsImportant')); ?>"
                                                       class="btn btn-outline-primary markAsImportant"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-placement="top"
                                                       title="<?php echo e(t('Mark as important')); ?>"
                                                    >
                                                        <i class="fa-regular fa-star"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/messages/' . $threadId . '/delete')); ?>"
                                                   class="btn btn-outline-primary"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   title="<?php echo e(t('Delete')); ?>"
                                                >
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                                <?php if(data_get($thread, 'p_is_unread')): ?>
                                                    <a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/messages/' . $threadId . '/actions?type=markAsRead')); ?>"
                                                       class="btn btn-outline-primary markAsRead"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-placement="top"
                                                       title="<?php echo e(t('Mark as read')); ?>"
                                                    >
                                                        <i class="fa-solid fa-envelope"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/messages/' . $threadId . '/actions?type=markAsUnread')); ?>"
                                                       class="btn btn-outline-primary markAsRead"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-placement="top"
                                                       title="<?php echo e(t('Mark as unread')); ?>"
                                                    >
                                                        <i class="fa-solid fa-envelope-open"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <?php echo $__env->make('front.account.messenger.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                
                                <div class="col-md-9 col-lg-10">
                                    <div class="p-0 m-0 message-chat">
                                        <div class="container mx-0 border rounded bg-body pb-3 mb-3">
                                            <div id="messageChatHistory" class="container mt-3 overflow-y-auto" id="listMessages" style="max-height: 550px;">
                                                <div id="linksMessages" class="text-center">
                                                    <?php echo $linksRender; ?>

                                                </div>
                                                
                                                <?php echo $__env->make('front.account.messenger.messages.messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="container px-0 mx-0 type-message">
                                            <?php
                                                $updateUrl = url(urlGen()->getAccountBasePath() . '/messages/' . $threadId);
                                            ?>
                                            <form id="chatForm" role="form" method="POST" action="<?php echo e($updateUrl); ?>" enctype="multipart/form-data">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <?php echo view('honeypot::honeypot'); ?>
                                                <div class="hstack gap-3 type-form">
                                                    <textarea id="body" name="body"
                                                              maxlength="500"
                                                              rows="5"
                                                              class="form-control me-auto input-write"
                                                              placeholder="<?php echo e(t('Type a message')); ?>"
                                                              style="height: 60px;"
                                                    ></textarea>
                                                    <div class="p-0 m-0 text-nowrap d-flex align-items-center button-wrap">
                                                        <input id="addFile" name="file_path" type="file">
                                                    </div>
                                                    <div class="vr"></div>
                                                    <button id="sendChat" class="btn btn-primary" type="submit">
                                                        <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

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

<?php $__env->startSection('after_styles'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('after_styles'); ?>
    <link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css')); ?>" rel="stylesheet">
    <?php if(config('lang.direction') == 'rtl'): ?>
        <link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css')); ?>" rel="stylesheet">
    <?php endif; ?>
    <?php if(str_starts_with($fiTheme, 'explorer')): ?>
        <link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/' . $fiTheme . '/theme.min.css')); ?>" rel="stylesheet">
    <?php endif; ?>
    <style>
        .file-input {
            display: inline-block;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>

    <script>
        var loadingImage = '<?php echo e(url('images/spinners/fading-line.gif')); ?>';
        var loadingErrorMessage = '<?php echo e(t('Threads could not be loaded')); ?>';
        var actionErrorMessage = '<?php echo e(t('This action could not be done')); ?>';
        var title = {
            'seen': '<?php echo e(t('Mark as read')); ?>',
            'notSeen': '<?php echo e(t('Mark as unread')); ?>',
            'important': '<?php echo e(t('Mark as important')); ?>',
            'notImportant': '<?php echo e(t('Mark as not important')); ?>',
        };
    </script>
    <script src="<?php echo e(url('assets/js/app/messenger.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/app/messenger-chat.js')); ?>" type="text/javascript"></script>
    
    <script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/' . $fiTheme . '/theme.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('common/js/fileinput/locales/' . config('app.locale') . '.js')); ?>" type="text/javascript"></script>
    
    <script>
        let options = {};
        options.theme = '<?php echo e($fiTheme); ?>';
        options.language = '<?php echo e(config('app.locale')); ?>';
        options.rtl = <?php echo e((config('lang.direction') == 'rtl') ? 'true' : 'false'); ?>;
        options.allowedFileExtensions = <?php echo $allowedFileFormatsJson; ?>;
        options.minFileSize = <?php echo e((int)config('settings.upload.min_file_size', 0)); ?>;
        options.maxFileSize = <?php echo e((int)config('settings.upload.max_file_size', 1000)); ?>;
        options.browseClass = 'btn btn-primary';
        options.browseIcon = '<i class="fa-solid fa-paperclip" aria-hidden="true"></i>';
        options.layoutTemplates = {
            main1: '{browse}',
            main2: '{browse}',
            btnBrowse: '<div tabindex="500" class="{css}"{status}>{icon}</div>',
        };
        
        onDocumentReady((event) => {
            
            $('#addFile').fileinput(options);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/front/account/messenger/show.blade.php ENDPATH**/ ?>