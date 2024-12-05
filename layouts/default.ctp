<!DOCTYPE html>
<html lang="<?php echo getCurrentLanguageField('language') ?>" class="no-js">
	<head>
		<?php
			/* Meta tagi */
			echo $this->element(TEMPLATE_NAME.DS.'head')
		?>
	</head>
	
	<?php $cart = (isCartView() || isOrderAddView()) ? true : false ?>
	
	<body class="<?php echo userIsSalesrep() && isCartView() ? 'edit-offer' : '' ?> <?php echo $cart? 'hide-cart-xs' : ''?>">
		<div class="wrap-header">
			<?php
				/* Nagłówek strony */
				echo $this->element(TEMPLATE_NAME.DS.'header')
			?>
		</div>
		
		<?php if (isMobile()): ?>
			<div class="header-mobile visible-xs on-up <?php echo userIsSalesrep() ? 'header-mobile-salesrep' : '' ?>">
				<?php //if (userIsSalesrep()): ?>
					<?php
						// echo $this->element(TEMPLATE_NAME.DS.'header_top_salesrep',
						// 	array(
						// 		'mobile' => true
						// 	)
						// )
					?>
				<?php //else: ?>
					<?php if (userIsSalesrep()) : ?>
						<?php
							echo $this->element(TEMPLATE_NAME.DS.'menu_user_account', 
								array(
									'top_menu' => true,
									'mobile'   => true
								)
							)
						?>
					<?php endif; ?>
					
					<ul class="nav-justified">
						<?php if ($bannerpath = getTemplatePath('thumb')):?>
							<li>
								<?php
									echo $this->Html->image(
										$bannerpath,
										array(
											'url'    => '/',
											'title'  => setting('GLOBAL_STORE_NAME'),
											'alt'    => setting('GLOBAL_STORE_NAME'),
											'width'  => '48',
											'height' => '48'
										)
									)
								?>
							</li>
						<?php endif ?>
						
						<li>
							<?php if (!checkIsSidebarBoxActive('categories')): ?>
								<?php if ($categories = getCategoryTree('all')): ?>
									<span class="mobile-top-icons" data-type="show-menu-mobile">
										<i class="fa fa-bars"></i>
									</span>
								<?php endif ?>
							<?php endif ?>
						</li>
						<li>
							<a class="mobile-top-icons" data-type="toggle" aria-label="<?php echo h(__('Wyszukiwarka', true))?>" href="#MainSearchElement2" data-toggle-extended="top-navigation">
								<i class="fa fa-search"></i>
							</a>
						</li>
						<li class="user">
							<?php if (userIsSalesrep()) : ?>
								<a href="#" data-type="slidemenu" data-target="UserAccountMenu1">
									<i class="fa fa-user-o" aria-hidden="true"></i>
								</a>
							<?php else : ?>
								<a href="<?php echo $this->Html->url(getOrdersUrl()) ?>" aria-label="<?php echo h(__('Zamówienia', true)) ?>" title="<?php echo h(__('Zamówienia', true)) ?>">
									<i class="fa fa-user-o" aria-hidden="true"></i>
								</a>
							<?php endif; ?>
						</li>	
						<li class="cart">
							<a href="<?php echo $this->Html->url(getCartUrl()) ?>" title="<?php echo h(__('Koszyk', true)) ?>">
								<i class="fa fa-shopping-cart"></i> <span data-type="cart-sum-quantity"><?php echo showQuantityValue(getRealProductsCountInCart()) ?></span>
							</a>
						</li>
						
						<?php if (!empty($user_reminders)): ?>
							<li class="user-reminders">
								<a href="<?php echo $this->Html->url(getUserReminderIndexUrl()) ?>" title="<?php echo h(__('Powiadomienia', true)) ?>">
									<i class="fa fa-envelope-o"></i> <span><?php echo count($user_reminders) ?></span>
								</a>
							</li>
						<?php endif ?>
						
						<li>
							<span class="go-to">
								<i class="fa fa-arrow-up"></i>
							</span>
						</li>
						
					</ul>
				<?php //endif ?>
			</div>
		<?php endif ?>
		
		<?php if (!(userIsSalesrep() && isCartView()) && !checkIsSidebarBoxActive('categories')): ?>
			<div class="wrap-navbar">
				<div class="container">
					<?php
						/* Nawigacja - kategorie */
						echo $this->element(
							TEMPLATE_NAME.DS.'main_nav',
							array(
								'cache' => array(
									'time' => Configure::read('Cache.short_time'),
									'key'  => getStandardCacheKey()
								)
							)
						)
					?>
				</div>
			</div>
		<?php endif ?>
		
		<?php //if (!isMobile()): ?>
			<?php echo $this->element(TEMPLATE_NAME.DS.'header_search') ?>
		<?php //endif ?>
		
		<div class="wrap-content">
			<?php if (isHomePageView()): ?>
				<div class="container-message container">
					<?php
						/* Komunikaty systemowe */
						echo $this->element(TEMPLATE_NAME.DS.'message')
					?>
				</div>
				
				<?php
					/* Główny baner */
					echo $this->element(
						TEMPLATE_NAME.DS.'banners',
						array(
							'container_class' => 'mainpage-banners',
							'section'         => 1,
							'interval'		  => 5000,
							'show_3'		  => false,
							'version'		  => 2
						)
					)
				?>
			<?php endif ?>
			
			<?php $landing_page_grid = isset($landing_page) && !empty($grid) ?>
			
			<div class="main-container container <?php echo $landing_page_grid ? 'container-full-width' : '' ?>">
				<?php if ($landing_page_grid): ?>
					<div class="container">
						<?php
							/* Ścieżka okruchów */
							echo $this->element(TEMPLATE_NAME.DS.'breadcrumbs')
						?>
					</div>
				<?php else: ?>
					<?php if (!$cart): ?>
						<?php
							/* Ścieżka okruchów */
							echo $this->element(TEMPLATE_NAME.DS.'breadcrumbs')
						?>
					<?php endif ?>
				<?php endif ?>
				
				<div class="row">
					<?php
						$left_boxes = getSidebarContent('left_column');
						$blog_page  = getCurrentController() == 'blog';
					?>
					
					<?php if ($left_boxes || $blog_page): ?>
						<aside class="sidebar sidebar-left <?php echo $blog_page ? 'blog-page-sidebar' : '' ?>">
							<?php
								/* Wyświetlenie lewego sidebar'a */
								echo $this->element(
									TEMPLATE_NAME.DS.'sidebar',
									array(
										'boxes'     => isset($left_boxes) ? $left_boxes : '',
										'blog_page' => $blog_page
									)
								)
							?>
						</aside>
					<?php endif ?>
					
					<section class="main-content <?php echo $left_boxes || $blog_page ? 'sidebar-left-true' : 'sidebar-left-false' ?>">
						<?php
							if (!isHomePageView()):
								/* Komunikaty systemowe */
								echo $this->element(TEMPLATE_NAME.DS.'message'); // Na głównej umieszczone nad banerem
							endif;
						?>
						
						<?php
							/* Treść strony */
							echo $content_for_layout
						?>
						
						<?php
							/* Skrypty które mają być na dole stron */
							echo $this->element('_default'.DS.'bottom_page_scripts')
						?>
					</section>
				</div>
			</div>
		</div>
		
		<?php
			/* Linki społecznościowe  */
			echo $this->element(TEMPLATE_NAME.DS.'social_links')
		?>
		
		<div class="wrap-footer">
			<?php
				/* Stopka */
				echo $this->element(TEMPLATE_NAME.DS.'footer')
			?>
		</div>
		
		<span class="go-to-top btn btn-primary"></span>
		
		<?php
			/* Informacja o ciasteczkach */
			echo $this->element('_default'.DS.'cookies')
		?>
		
		<?php
			/* Informacja o PWA dla Safari */
			echo $this->element(TEMPLATE_NAME.DS.'safari_pwa')
		?>
		
		<?php
			/* JavaScript i Szablony */
			echo $this->element(TEMPLATE_NAME.DS.'scripts')
		?>
	</body>
</html>