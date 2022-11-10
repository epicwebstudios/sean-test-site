<!-- Header -->
<div class="header">

	<div class="ca top">

		<div class="l logo">
			<img src="images/ep-logo.png" />
		</div>

		<div class="r tr">

			<div class="website">
				<a href="<? echo $settings['url']; ?>" target="_blank">
					<span class="fa fa-home"></span><? echo $settings['name']; ?>
				</a>
			</div>

			<div class="version">
				Currently running on epicPlatform <? echo EP_VERSION; ?>
			</div>

		</div>

	</div>

	<div class="ca bottom">

		<div class="l">
			<? require_once BASE_DIR.'/admin/sources/php/menu.php'; ?>
		</div>

		<div class="r user">
			
			<?

				// Dark mode toggle.
			
				$class = 'off';
				$label = 'Turn on dark mode';

				if( $_COOKIE['ews_dark_mode'] == '1' ){
					$class = 'on';
					$label = 'Turn off dark mode';
				}

				echo '<div';
					echo ' class="dark_mode_toggle '.$class.'"';
					echo ' data-url="?'.http_build_query($dm_params).'"';
					echo ' title="'.$label.'"';
				echo '>';

					echo '<div class="light"><i class="fa fa-fw fa-sun-o"></i></div>';
					echo '<div class="dark"><i class="fa fa-fw fa-moon-o"></i></div>';
					echo '<div class="toggle"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i></div>';

				echo '</div>';
			
			?>
			
			<a href="?a=41">Logged in as <b><? echo $user['first']." ".$user['last']; ?></b></a> (<a href="?a=logout">Logout</a>)
			
		</div>

	</div>

</div>