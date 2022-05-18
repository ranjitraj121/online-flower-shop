<?php 
if($addons){ ?>
	<div class="addons-boxes-w">
		<?php foreach($addons as $addon){ 
			$is_activated = is_plugin_active($addon->wp_plugin_path);
			$is_installed = OsAddonsHelper::is_addon_installed($addon->wp_plugin_path);
			$addon_css_class = '';
			$is_featured = false;
			if($is_activated) $addon_css_class.= ' status-activated';
			if($is_installed){
				$addon_css_class.= ' status-installed';
				$addon_data = get_plugin_data(OsAddonsHelper::get_addon_plugin_path($addon->wp_plugin_path));
				$installed_version = (isset($addon_data['Version'])) ? $addon_data['Version'] : '1.0.0';
				if(version_compare($addon->version, $installed_version) > 0){
					$addon_css_class.= ' status-update-available';
				}
			}else{
				if($addon->is_featured == 'yes'){
					$addon_css_class.= ' status-is-featured';
					$is_featured = true;
				}
			}
			$addon_data_html = ' data-addon-path="'.$addon->wp_plugin_path.'" data-addon-name="'.$addon->wp_plugin_name.'" '; ?>
			<div class="addon-box <?php echo $addon_css_class; ?>">
				<?php if($is_featured) echo '<div class="addon-label"><i class="latepoint-icon latepoint-icon-star"></i><span>'.__('Featured', 'latepoint').'</span></div>'; ?>
				<div class="addon-media" style="background-image: url(<?php echo $addon->media_url; ?>);"></div>
				<div class="addon-header">
					<h3 class="addon-name"><?php echo $addon->name; ?></h3>
				</div>
				<div class="addon-body">
					<div class="addon-desc"><?php echo $addon->description; ?></div>
					<div class="addon-meta">
						<?php 
						if($is_installed){
								if(version_compare($addon->version, $installed_version) > 0){
									echo '<div>'.__('Latest:', 'latepoint').' '.$addon->version.'</div>';
									echo '<div>'.__('Installed:', 'latepoint').' '.$installed_version.'</div>';
								}else{
									echo '<div>'.__('Installed:', 'latepoint').' '.$installed_version.'</div>';
								}
						}else{
							echo '<div>'.__('Latest:', 'latepoint').' '.$addon->version.'</div>';
						} ?>
					</div>
				</div>
				<div class="addon-footer">
						<?php 
							if(version_compare($addon->required_version, LATEPOINT_VERSION) > 0){
								echo '<a class="os-update-plugin-link" href="'. OsRouterHelper::build_link(['updates', 'status']).'"><span><i class="latepoint-icon latepoint-icon-refresh-cw"></i></span><span>'.__('Requires LatePoint', 'latepoint').' v'.$addon->required_version.'</span></a>';
							}else{
								if($is_activated){
									// is activated
									if(version_compare($addon->version, $installed_version) > 0){
										if(!OsSettingsHelper::is_env_demo()){
											echo '<a href="#" class="os-install-addon-btn os-addon-action-btn" data-route-name="'.OsRouterHelper::build_route_name('addons', 'install_addon').'" '.$addon_data_html.'>';
												echo '<span><i class="latepoint-icon latepoint-icon-grid-18"></i></span><span>'.__('Update Now', 'latepoint').'</span>';
											echo '</a>';
										}
									}else{
										if(!OsSettingsHelper::is_env_demo()){
											echo '<a href="#" class="os-subtle-addon-action-btn os-addon-action-btn" data-route-name="'.OsRouterHelper::build_route_name('addons', 'deactivate_addon').'" '.$addon_data_html.'>';
												echo __('Deactivate', 'latepoint');
											echo '</a>';
										}
										echo '<div class="os-addon-activated-label"><span><i class="latepoint-icon latepoint-icon-checkmark"></i></span><span>'.__('Active', 'latepoint').'</span></div>';
									}
								}else{
									if(!OsSettingsHelper::is_env_demo()){
										// check if its installed 
										if($is_installed){
											// installed but outdated
											if(version_compare($addon->version, $installed_version) > 0){
												echo '<a href="#" class="os-install-addon-btn os-addon-action-btn" data-route-name="'.OsRouterHelper::build_route_name('addons', 'install_addon').'" '.$addon_data_html.'>';
													echo '<span><i class="latepoint-icon latepoint-icon-grid-18"></i></span><span>'.__('Update Now', 'latepoint').'</span>';
												echo '</a>';
											}else{
												echo '<a href="#" class="os-subtle-addon-action-btn os-addon-action-btn" data-route-name="'.OsRouterHelper::build_route_name('addons', 'delete_addon').'" '.$addon_data_html.'>';
													echo __('Delete', 'latepoint');
												echo '</a>';
												// installed but not activated
												echo '<a href="#" class="os-install-addon-btn os-addon-action-btn" data-route-name="'.OsRouterHelper::build_route_name('addons', 'activate_addon').'" '.$addon_data_html.'>';
													echo '<span><i class="latepoint-icon latepoint-icon-box"></i></span><span>'.__('Activate', 'latepoint').'</span>';
												echo '</a>';
											}
										}else{
											// not installed 
											if($addon->price > 0){
												if($addon->purchased){
													echo '<a href="#" class="os-install-addon-btn os-addon-action-btn" data-route-name="'.OsRouterHelper::build_route_name('addons', 'install_addon').'" '.$addon_data_html.'>';
														echo '<span>'.__('Install Now', 'latepoint').'</span>';
													echo '</a>';
												}else{
													echo '<a target="_blank" href="'.$addon->purchase_url.'" class="os-purchase-addon-btn">';
														echo '<span>'.'$'.number_format($addon->price).'</span>';
														echo '<span>'.__('Learn More', 'latepoint').'</span>';
													echo '</a>';
												}
											}else{
												echo '<a href="#" class="os-install-addon-btn os-addon-action-btn" data-route-name="'.OsRouterHelper::build_route_name('addons', 'install_addon').'" '.$addon_data_html.'>';
													echo '<span>'.__('Install Now', 'latepoint').'</span>';
												echo '</a>';
											}
										}
									}
								}
							}?>
					</a>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>
