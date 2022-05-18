<?php if($agents){ ?>
	<div class="index-agent-boxes">
		<?php
			$today_date = new OsWpDateTime('today');
			foreach($agents as $agent){ ?>
				<a href="<?php echo OsRouterHelper::build_link(OsRouterHelper::build_route_name('agents', 'edit_form'), array('id' => $agent->id) ); ?>" class="agent-box-w agent-status-<?php echo $agent->status; ?>">
					<div class="agent-edit-icon"><i class="latepoint-icon latepoint-icon-edit-3"></i></div>
					<div class="agent-info-w">
						<div class="agent-avatar" style="background-image: url(<?php echo $agent->avatar_url; ?>)"></div>
						<div class="agent-info">
							<div class="agent-name"><?php echo $agent->full_name; ?></div>
							<div class="agent-phone"><?php echo $agent->phone; ?></div>
							<?php if($agent->wp_user_id) echo '<span class="agent-connection-icon"><img title="'.__('Connected to WordPress User', 'latepoint').'" src="'.esc_attr(LatePoint::images_url().'wordpress-logo.png').'"/></span>'; ?>
							<?php do_action('latepoint_after_agent_info_on_index', $agent); ?>
						</div>
					</div>
					<div class="agent-schedule">
						<?php 
						$custom_work_periods = OsWorkPeriodsHelper::load_work_periods(array('agent_id' => $agent->id, 'flexible_search' => false));
						if(!$custom_work_periods){
							$work_periods = OsWorkPeriodsHelper::load_work_periods();
						}else{
							$work_periods = $custom_work_periods;
						}
						$working_periods_with_weekdays = array();
				    if($work_periods){
				      foreach($work_periods as $work_period){
				        $working_periods_with_weekdays['day_'.$work_period->week_day][] = $work_period;
				      }
				    }

						for($i=1;$i<=7;$i++){
				      $is_day_off = true;
				      $period_forms_html = '';
				      if(isset($working_periods_with_weekdays['day_'.$i])){
				        $is_day_off = false;
				        // EXISTING WORK PERIOD
				        foreach($working_periods_with_weekdays['day_'.$i] as $work_period){
				          if($work_period->start_time === $work_period->end_time){
				            $is_day_off = true;
				          }
				        }
				      }
				      $status_class = $is_day_off ? 'is-off' : 'is-on';
							echo '<div class="schedule-day '.$status_class.'">'.OsBookingHelper::get_weekday_name_by_number($i).'</div>';
						} ?>
					</div>
					<div class="agent-schedule-info">
						<div class="agent-today-info">
							<?php _e('Today', 'latepoint'); ?>
							<?php 
							$today_work_periods = OsWorkPeriodsHelper::load_work_periods(['agent_id' => $agent->id, 'custom_date' => $today_date->format('Y-m-d')]);
							$is_working_today = ($today_work_periods && count($today_work_periods) > 0 && $today_work_periods[0]->start_time != $today_work_periods[0]->end_time);
							 ?>
							<span class="today-status <?php echo ($is_working_today) ? 'is-on-duty' : 'is-off-duty'; ?>"><?php echo ($is_working_today) ? __('On Duty', 'latepoint') : __('Off Duty', 'latepoint'); ?></span>
							<div class="today-schedule">
								<?php if($is_working_today){ ?>
									<?php foreach($today_work_periods as $period){
										echo '<span>' . OsTimeHelper::minutes_to_hours_and_minutes($period->start_time).' - '.OsTimeHelper::minutes_to_hours_and_minutes($period->end_time) . '</span>';
									} ?>
								<?php }else{
									_e('Not Available', 'latepoint');
								} ?>
							</div>
						</div>
						<div class="today-bookings">
							<?php _e('Bookings', 'latepoint'); ?>
							<div class="today-bookings-count"><?php echo OsBookingHelper::count_bookings_for_date($today_date->format('Y-m-d'), ['agent_id' => $agent->id]); ?></div>
						</div>
					</div>
				</a>
				<?php
			}
		?>
		<?php if($this->logged_in_admin_user_id){ ?>
			<a href="<?php echo OsRouterHelper::build_link(OsRouterHelper::build_route_name('agents', 'new_form') ) ?>" class="create-agent-link-w">
        <div class="create-agent-link-i">
          <div class="add-agent-graphic-w">
            <div class="add-agent-plus"><i class="latepoint-icon latepoint-icon-plus4"></i></div>
          </div>
          <div class="add-agent-label"><?php _e('Add Agent', 'latepoint'); ?></div>
        </div>
			</a>
		<?php } ?>
	</div>
<?php }else{ ?>
  <div class="no-results-w">
    <div class="icon-w"><i class="latepoint-icon latepoint-icon-users"></i></div>
    <h2><?php _e('No Existing Agents Found', 'latepoint'); ?></h2>
    <a href="<?php echo OsRouterHelper::build_link(OsRouterHelper::build_route_name('agents', 'new_form') ) ?>" class="latepoint-btn"><i class="latepoint-icon latepoint-icon-plus"></i><span><?php _e('Add First Agent', 'latepoint'); ?></span></a>
  </div>
<?php } ?>