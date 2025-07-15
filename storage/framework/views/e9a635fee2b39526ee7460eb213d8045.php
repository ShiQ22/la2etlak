<?php if(isSocialSharesEnabled()): ?>
	<?php
		$socialMedias = [
			'facebook' => [
				'name'      => 'Facebook',
				'iconClass' => 'fa-brands fa-square-facebook',
				'linkClass' => 'facebook',
			],
			'twitter' => [
				'name'      => 'X (Twitter)',
				'iconClass' => 'fa-brands fa-square-x-twitter',
				'linkClass' => 'x-twitter',
			],
			'linkedin' => [
				'name'      => 'LinkedIn',
				'iconClass' => 'fa-brands fa-linkedin',
				'linkClass' => 'linkedin',
			],
			'whatsapp' => [
				'name'      => 'WhatsApp',
				'iconClass' => 'fa-brands fa-square-whatsapp',
				'linkClass' => 'whatsapp',
			],
			'telegram' => [
				'name'      => 'Telegram',
				'iconClass' => 'fa-brands fa-telegram',
				'linkClass' => 'telegram',
			],
			'snapchat' => [
				'name'      => 'Snapchat',
				'iconClass' => 'fa-brands fa-square-snapchat',
				'linkClass' => 'snapchat',
			],
			'messenger' => [
				'name'      => 'Facebook Messenger',
				'iconClass' => 'fa-brands fa-facebook-messenger',
				'linkClass' => 'messenger',
				'data'      => [
					'fb-app-id' => config('settings.social_share.facebook_app_id'),
				],
			],
			'pinterest' => [
				'name'      => 'Pinterest',
				'iconClass' => 'fa-brands fa-square-pinterest',
				'linkClass' => 'pinterest',
			],
			'vk' => [
				'name'      => 'VK (VKontakte)',
				'iconClass' => 'fa-brands fa-vk',
				'linkClass' => 'vk',
			],
			'tumblr' => [
				'name'      => 'Tumblr',
				'iconClass' => 'fa-brands fa-square-tumblr',
				'linkClass' => 'tumblr',
			],
		];
	?>
	<div class="social-media social-share text-center my-4 mx-0">
		<span class="text-secondary text-opacity-25" data-bs-toggle="tooltip" title="<?php echo e(t('share_on_social_media')); ?>">
			<i class="fa-solid fa-share"></i>
		</span>
		<?php $__currentLoopData = $socialMedias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php
				$name = $item['name'] ?? '--';
				$iconClass = $item['iconClass'] ?? '';
				$linkClass = $item['linkClass'] ?? '';
				
				$data = $item['data'] ?? [];
				$dataAttr = '';
				if (!empty($data) && is_array($data)) {
					$dataAttr .= ' ';
					$dataAttr .= collect($data)
						->map(fn ($v, $k) => 'data-' . $k . '="' . $v . '"')
						->join(' ');
				}
			?>
			<?php if(isSocialSharesEnabled($key)): ?>
				<a class="<?php echo e($linkClass); ?> text-decoration-none" title="<?php echo e(t('share_on', ['media' => $name])); ?>"<?php echo $dataAttr; ?>>
					<i class="<?php echo e($iconClass); ?>"></i>
				</a>
			<?php endif; ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/front/layouts/partials/social/horizontal.blade.php ENDPATH**/ ?>