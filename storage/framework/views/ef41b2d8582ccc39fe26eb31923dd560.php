<?php if(data_get($post, 'lost_or_found') === 'lost'): ?>
  <span class="badge badge-lost ms-2"><?php echo e(t('Lost')); ?></span>
<?php elseif(data_get($post, 'lost_or_found') === 'found'): ?>
  <span class="badge badge-found ms-2"><?php echo e(t('Found')); ?></span>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\resources\views/front/layouts/partials/lost-found-badge.blade.php ENDPATH**/ ?>