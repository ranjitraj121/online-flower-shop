<div class="os-row">
	<div class="os-col-lg-6">
		<div class="version-status-info" data-route="<?php echo OsRouterHelper::build_route_name('updates', 'check_version_status') ?>">
			<span class="loading"><?php _e('Checking Version Status', 'latepoint'); ?></span>
		</div>
		<?php if($is_license_active){ ?>
			<div class="active-license-info is-active">
				<div class="version-check-icon"></div>
				<h4>Your license is activated</h4>
				<p>Thank you for using LatePoint</p>
				<div class="license-form-w" style="display: none;">
					<?php include('_license_form.php'); ?>
				</div>
				<a href="#" class="latepoint-btn latepoint-btn-outline latepoint-btn-sm latepoint-show-license-details">
					<span>Show License Details</span>
				</a>
				<a href="#" data-os-action="<?php echo OsRouterHelper::build_route_name('updates', 'remove_license'); ?>" data-os-success-action="reload" class="latepoint-btn latepoint-btn-outline latepoint-btn-danger latepoint-btn-sm">
					<span>Deactivate</span>
				</a>
			</div>
		<?php }else{ ?>
			<div class="active-license-info">
				<div class="version-warn-icon"></div>
				<h4>Activate Your LatePoint License</h4>
				<p>Register your license to install plugin updates and addons.</p>
				<div class="license-form-w">
					<?php include('_license_form.php'); ?>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="os-col-lg-6">
		<div class="version-log-w" data-route="<?php echo OsRouterHelper::build_route_name('updates', 'get_updates_log') ?>">
			<span class="loading"><?php _e('Loading Update Log', 'latepoint'); ?></span>
		</div>
	</div>
</div>