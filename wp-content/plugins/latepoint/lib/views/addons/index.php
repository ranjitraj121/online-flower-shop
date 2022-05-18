<div class="addons-filter" style="display: none;">
	<div class="filter-label"><?php _e('Filter:', 'latepoint'); ?></div>
	<div class="filter-field-group addon-search-field-w">
		<input class="addon-search-field" type="text" value="" placeholder="<?php _e('Type to search...', 'latepoint'); ?>">
	</div>
	<div class="filter-field-group">
		<label for=""><?php _e('Category:', 'latepoint'); ?></label>
		<select name="" id="">
			<option value="">Show All</option>
			<option value="">Payments</option>
			<option value="">Enchancements</option>
			<option value="">Integrations</option>
			<option value="">Other</option>
		</select>
	</div>
</div>
<div class="addons-info-holder" data-route="<?php echo OsRouterHelper::build_route_name('addons', 'load_addons_list') ?>">
	<span class="loading"><?php _e('Loading Addons Information', 'latepoint'); ?></span>
</div>