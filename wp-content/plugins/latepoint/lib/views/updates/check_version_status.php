<?php if($version_info['extra_html']){ ?>
	<?php echo '<div>'. $version_info['extra_html']. '</div>'; ?>
<?php } ?>
<?php if(version_compare($version_info['version'] ,LATEPOINT_VERSION) > 0){ ?>
	<div class="new-version-message">
		<h3><?php _e('New Update is Available', 'latepoint') ?></h3>
		<div class="version-warn-icon"></div>
		<div class="new-version-info">
			<span><?php _e('New Version: ', 'latepoint') ?></span><strong><?php echo $version_info['version']; ?></strong>, 
			<span><?php _e('Released on: ', 'latepoint') ?></span><strong><?php echo $version_info['last_update_date']; ?></strong>
		</div>
		<div class="current-version-info">
			<span><?php _e('Installed Version: ', 'latepoint') ?></span><strong><?php echo LATEPOINT_VERSION; ?></strong>
		</div>
		<div class="new-version-update-prompt">
			<?php if(OsLicenseHelper::is_license_active()){ ?>
			<a href="#" data-os-success-action="reload" data-os-action="<?php echo OsRouterHelper::build_route_name('updates', 'update_plugin'); ?>" class="latepoint-btn latepoint-btn-white">
				<i class="latepoint-icon latepoint-icon-grid-18"></i>
				<span><?php _e('Update Now', 'latepoint'); ?></span>
			</a>
		<?php }else{
			echo '<div class="key-prompt">Enter your purchase key below to enable updates</div>';
		} ?>
		</div>
	</div>
<?php }else{ ?>
	<div class="new-version-message is-latest">
		<h3><?php _e('You are using the latest version', 'latepoint') ?></h3>
		<div class="version-check-icon"></div>
		<div class="current-version-info">
			<span><?php _e('Installed Version: ', 'latepoint') ?></span><strong><?php echo LATEPOINT_VERSION; ?></strong>
		</div>
		<div class="new-version-update-prompt">
			<a href="<?php echo $version_info['link']; ?>" target="_blank" class="latepoint-btn latepoint-btn-white">
				<span><?php _e('Learn More About LatePoint Plugin', 'latepoint'); ?></span>
				<i class="latepoint-icon latepoint-icon-arrow-right"></i>
			</a>
		</div>
	</div>
<?php } ?>