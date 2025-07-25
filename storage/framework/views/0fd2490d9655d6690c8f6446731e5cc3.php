<?php
	$footerLinksAreEnabled = (config('settings.footer.hide_links') != '1');
	
	$socialLinksAreEnabled = (
		config('settings.social_link.facebook_page_url')
		|| config('settings.social_link.twitter_url')
		|| config('settings.social_link.tiktok_url')
		|| config('settings.social_link.linkedin_url')
		|| config('settings.social_link.pinterest_url')
		|| config('settings.social_link.instagram_url')
		|| config('settings.social_link.youtube_url')
		|| config('settings.social_link.vimeo_url')
		|| config('settings.social_link.vk_url')
		|| config('settings.social_link.tumblr_url')
		|| config('settings.social_link.flickr_url')
	);
	$appsLinksAreEnabled = (
		config('settings.other.ios_app_url')
		|| config('settings.other.android_app_url')
	);
	$socialAndAppsLinksAreEnabled = ($socialLinksAreEnabled || $appsLinksAreEnabled);
	
	$paymentLogosAreEnabled = (config('settings.footer.hide_payment_plugins_logos') != '1');
	
	// Links CSS Class
	$linkClass = linkClass('body-emphasis');
	
	$isFullWidthFooter = (config('settings.style.footer_full_width') == '1');
	$containerClass = $isFullWidthFooter ? 'container-fluid' : 'container';
	$containerPxClass = $isFullWidthFooter ? ' px-lg-4 px-0 py-0' : ' p-0';
?>
<footer>
	<?php
		$rowColsLg = $socialAndAppsLinksAreEnabled ? 'row-cols-lg-4' : 'row-cols-lg-3';
		$rowColsMd = 'row-cols-md-3';
		
		$borderTopCopy = ' border-top pt-4';
		$mbCopy = ' mb-4';
		if (!$footerLinksAreEnabled) {
			$borderTopCopy = '';
			$mbCopy = ' mb-5';
		}
	?>
	<div class="container-fluid border-top bg-body-tertiary pt-5 pb-0 mt-4">
		<div class="<?php echo e($containerClass . $containerPxClass); ?> my-0">
			
			<div class="row <?php echo e($rowColsLg); ?> <?php echo e($rowColsMd); ?> row-cols-sm-2 row-cols-2 g-3">
				<?php if($footerLinksAreEnabled): ?>
					<div class="col">
						<h4 class="fs-6 fw-bold text-uppercase mb-4">
							<?php echo e(t('about_us')); ?>

						</h4>
						<ul class="list-unstyled">
							<?php if(isset($pages) && $pages->count() > 0): ?>
								<?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li class="lh-lg">
										<?php
											$linkTarget = '';
											if ($page->target_blank == 1) {
												$linkTarget = 'target="_blank"';
											}
										?>
										<?php if(!empty($page->external_link)): ?>
											<a href="<?php echo $page->external_link; ?>"
											   rel="nofollow" <?php echo $linkTarget; ?>

											   class="<?php echo e($linkClass); ?>"
											>
												<?php echo e($page->name); ?>

											</a>
										<?php else: ?>
											<a href="<?php echo e(urlGen()->page($page)); ?>" <?php echo $linkTarget; ?> class="<?php echo e($linkClass); ?>">
												<?php echo e($page->name); ?>

											</a>
										<?php endif; ?>
									</li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</ul>
					</div>
					
					<div class="col">
						<h4 class="fs-6 fw-bold text-uppercase mb-4">
							<?php echo e(t('Contact and Sitemap')); ?>

						</h4>
						<ul class="list-unstyled">
							<li class="lh-lg">
								<a href="<?php echo e(urlGen()->contact()); ?>"
								   class="<?php echo e($linkClass); ?>"
								><?php echo e(t('Contact')); ?></a>
							</li>
							<li class="lh-lg">
								<a href="<?php echo e(urlGen()->sitemap()); ?>"
								   class="<?php echo e($linkClass); ?>"
								><?php echo e(t('sitemap')); ?></a>
							</li>
							<?php if(isset($countries) && $countries->count() > 1): ?>
								<li class="lh-lg">
									<a href="<?php echo e(urlGen()->countries()); ?>"
									   class="<?php echo e($linkClass); ?>"
									><?php echo e(t('countries')); ?></a>
								</li>
							<?php endif; ?>
						</ul>
					</div>
					
					<div class="col">
						<h4 class="fs-6 fw-bold text-uppercase mb-4">
							<?php echo e(t('my_account')); ?>

						</h4>
						<ul class="list-unstyled">
							<?php if(!auth()->user()): ?>
								<li class="lh-lg">
									<a href="<?php echo urlGen()->signInModal(); ?>"
									   class="<?php echo e($linkClass); ?>"
									><?php echo e(trans('auth.log_in')); ?></a>
								</li>
								<li class="lh-lg">
									<a href="<?php echo e(urlGen()->signUp()); ?>"
									   class="<?php echo e($linkClass); ?>"
									><?php echo e(trans('auth.register')); ?></a>
								</li>
							<?php else: ?>
								<li class="lh-lg">
									<a href="<?php echo e(urlGen()->accountOverview()); ?>"
									   class="<?php echo e($linkClass); ?>"
									><?php echo e(t('my_account')); ?></a>
								</li>
								<li class="lh-lg">
									<a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/posts/list')); ?>"
									   class="<?php echo e($linkClass); ?>"
									><?php echo e(t('my_listings')); ?></a>
								</li>
								<li class="lh-lg">
									<a href="<?php echo e(url(urlGen()->getAccountBasePath() . '/saved-posts')); ?>"
									   class="<?php echo e($linkClass); ?>"
									><?php echo e(t('favourite_listings')); ?></a>
								</li>
							<?php endif; ?>
						</ul>
					</div>
					
					<?php if($socialAndAppsLinksAreEnabled): ?>
						<div class="col">
							<div class="row">
								<?php
									$mbAppsLinks = $socialLinksAreEnabled ? ' mb-3' : '';
									$styleAppsLinks = 'style="max-width: 135px; max-height: 40px; width: auto; height: auto;"';
									$mbSocialLinksTitle = 'mb-4';
								?>
								<?php if($appsLinksAreEnabled): ?>
									<div class="col-sm-12 col-12 p-lg-0<?php echo e($mbAppsLinks); ?>">
										<h4 class="fs-6 fw-bold text-uppercase mb-4">
											<?php echo e(t('Mobile Apps')); ?>

										</h4>
										<div class="row">
											<?php if(config('settings.other.ios_app_url')): ?>
												<div class="col-12 col-sm-6">
													<a class="" target="_blank" href="<?php echo e(config('settings.other.ios_app_url')); ?>">
														<span class="visually-hidden"><?php echo e(t('iOS app')); ?></span>
														<img
																src="<?php echo e(url('images/site/app-store-badge.svg')); ?>"
																alt="<?php echo e(t('Available on the App Store')); ?>" <?php echo $styleAppsLinks; ?>

														>
													</a>
												</div>
											<?php endif; ?>
											<?php if(config('settings.other.android_app_url')): ?>
												<div class="col-12 col-sm-6">
													<a class="app-icon" target="_blank" href="<?php echo e(config('settings.other.android_app_url')); ?>">
														<span class="visually-hidden"><?php echo e(t('Android App')); ?></span>
														<img
																src="<?php echo e(url('images/site/google-play-badge.svg')); ?>"
																alt="<?php echo e(t('Available on Google Play')); ?>" <?php echo $styleAppsLinks; ?>

														>
													</a>
												</div>
											<?php endif; ?>
										</div>
									</div>
									<?php
										$mbSocialLinksTitle = 'my-0';
									?>
								<?php endif; ?>
								
								<?php if($socialLinksAreEnabled): ?>
									<div class="col-sm-12 col-12 p-lg-0">
										<h4 class="fs-6 fw-bold text-uppercase <?php echo $mbSocialLinksTitle; ?>">
											<?php echo e(t('Follow us on')); ?>

										</h4>
										<ul class="list-unstyled list-inline mx-0 social-media social-links">
											<?php if(config('settings.social_link.facebook_page_url')): ?>
												<li class="list-inline-item me-0 px-0">
													<a class="facebook"
													   href="<?php echo e(config('settings.social_link.facebook_page_url')); ?>"
													   title="Facebook"
													>
														<i class="fa-brands fa-square-facebook"></i>
													</a>
												</li>
											<?php endif; ?>
											<?php if(config('settings.social_link.twitter_url')): ?>
												<li class="list-inline-item me-0 px-0">
													<a class="x-twitter"
													   href="<?php echo e(config('settings.social_link.twitter_url')); ?>"
													   title="X (Twitter)"
													>
														<i class="fa-brands fa-square-x-twitter"></i>
													</a>
												</li>
											<?php endif; ?>
											<?php if(config('settings.social_link.instagram_url')): ?>
												<li class="list-inline-item me-0 px-0">
													<a class="instagram"
													   href="<?php echo e(config('settings.social_link.instagram_url')); ?>"
													   title="Instagram"
													>
														<i class="fa-brands fa-square-instagram"></i>
													</a>
												</li>
											<?php endif; ?>
											<?php if(config('settings.social_link.linkedin_url')): ?>
												<li class="list-inline-item me-0 px-0">
													<a class="linkedin"
													   href="<?php echo e(config('settings.social_link.linkedin_url')); ?>"
													   title="LinkedIn"
													>
														<i class="fa-brands fa-linkedin"></i>
													</a>
												</li>
											<?php endif; ?>
											<?php if(config('settings.social_link.pinterest_url')): ?>
												<li class="list-inline-item me-0 px-0">
													<a class="pinterest"
													   href="<?php echo e(config('settings.social_link.pinterest_url')); ?>"
													   title="Pinterest"
													>
														<i class="fa-brands fa-square-pinterest"></i>
													</a>
												</li>
											<?php endif; ?>
											<?php if(config('settings.social_link.tiktok_url')): ?>
												<li class="list-inline-item me-0 px-0">
													<a class="tiktok"
													   href="<?php echo e(config('settings.social_link.tiktok_url')); ?>"
													   title="Tiktok"
													>
														<i class="fa-brands fa-tiktok"></i>
													</a>
												</li>
											<?php endif; ?>
											<?php if(config('settings.social_link.youtube_url')): ?>
												<li class="list-inline-item me-0 px-0">
													<a class="youtube"
													   href="<?php echo e(config('settings.social_link.youtube_url')); ?>"
													   title="YouTube"
													>
														<i class="fa-brands fa-youtube"></i>
													</a>
												</li>
											<?php endif; ?>
											<?php if(config('settings.social_link.vimeo_url')): ?>
												<li class="list-inline-item me-0 px-0">
													<a class="vimeo"
													   href="<?php echo e(config('settings.social_link.vimeo_url')); ?>"
													   title="Vimeo"
													>
														<i class="fa-brands fa-vimeo"></i>
													</a>
												</li>
											<?php endif; ?>
											<?php if(config('settings.social_link.vk_url')): ?>
												<li class="list-inline-item me-0 px-0">
													<a class="vk"
													   href="<?php echo e(config('settings.social_link.vk_url')); ?>"
													   title="VK (VKontakte)"
													>
														<i class="fa-brands fa-vk"></i>
													</a>
												</li>
											<?php endif; ?>
											<?php if(config('settings.social_link.tumblr_url')): ?>
												<li class="list-inline-item me-0 px-0">
													<a class="tumblr"
													   href="<?php echo e(config('settings.social_link.tumblr_url')); ?>"
													   title="Tumblr"
													>
														<i class="fa-brands fa-square-tumblr"></i>
													</a>
												</li>
											<?php endif; ?>
											<?php if(config('settings.social_link.flickr_url')): ?>
												<li class="list-inline-item me-0 px-0">
													<a class="flickr"
													   href="<?php echo e(config('settings.social_link.flickr_url')); ?>"
													   title="Flickr"
													>
														<i class="fa-brands fa-flickr"></i>
													</a>
												</li>
											<?php endif; ?>
										</ul>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			
			<?php
				$mtCopy = ' mt-md-4 mt-4 pt-2';
			?>
			<?php if($paymentLogosAreEnabled && isset($paymentMethods) && $paymentMethods->count() > 0): ?>
				<?php
					$mtPay = '';
					$borderTopPay = ' border-top pt-md-4 pt-3';
					if (!$footerLinksAreEnabled) {
						$mtPay = ' mt-0';
						$borderTopPay = '';
					}
					$borderTopCopy = ' border-top pt-4';
				?>
			<?php else: ?>
				<?php
					$mtCopy = ' mt-0';
				?>
				<?php if($footerLinksAreEnabled): ?>
					<?php
						$mtCopy = ' mt-md-4 mt-4 pt-2';
					?>
				<?php endif; ?>
			<?php endif; ?>
			
			
			<?php if($paymentLogosAreEnabled && isset($paymentMethods) && $paymentMethods->count() > 0): ?>
				<div class="row">
					<div class="col-12 text-center<?php echo e($borderTopPay . $mtPay); ?>">
						<?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(file_exists(plugin_path($paymentMethod->name, 'public/images/payment.png'))): ?>
								<img src="<?php echo e(url('plugins/' . $paymentMethod->name . '/images/payment.png')); ?>"
								     alt="<?php echo e($paymentMethod->display_name); ?>"
								     title="<?php echo e($paymentMethod->display_name); ?>"
								     class="img-thumbnail m-1 bg-light-subtle"
								     style="width: auto; height: 44px;"
								>
							<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				</div>
			<?php endif; ?>
			
			
			<div class="row">
				<div class="col-12 small text-center<?php echo e($borderTopCopy . $mbCopy . $mtCopy); ?>">
					&copy; <?php echo e(date('Y')); ?> <?php echo e(config('settings.app.name')); ?>. <?php echo e(t('all_rights_reserved')); ?>.
					<?php if(!config('settings.footer.hide_powered_by')): ?>
						<?php if(config('settings.footer.powered_by_info')): ?>
							<?php echo e(t('Powered by')); ?> <?php echo config('settings.footer.powered_by_info'); ?>

						<?php else: ?>
							<?php echo e(t('Powered by')); ?> <a href="https://la2etlak.com"
							                         title="La2etlak"
							                         class="<?php echo e(linkClass()); ?>"
							>la2etlak</a>.
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
			
		</div>
	</div>
</footer>
<?php /**PATH C:\xampp\htdocs\resources\views/front/layouts/partials/footer.blade.php ENDPATH**/ ?>