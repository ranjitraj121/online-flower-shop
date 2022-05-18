<?php 
if($bookings){
  foreach ($bookings as $booking): ?>
    <tr>
      <td class="os-column-faded text-center"><?php echo $booking->id; ?></td>
      <?php if(count($services_list) > 1){ ?>
      <td>
        <span class="os-column-service-color" style="background-color: <?php echo $booking->service->bg_color; ?>"></span> 
        <a href="#" <?php echo OsBookingHelper::quick_booking_btn_html($booking->id); ?>><?php echo $booking->service->name; ?></a>
      </td>
      <?php } ?>
      <td><?php echo $booking->nice_start_date; ?></td>
      <td><?php echo $booking->nice_start_time; ?></td>
      <?php if(!$show_single_agent){ ?>
        <td>
          <a class="os-with-avatar" href="<?php echo OsRouterHelper::build_link(OsRouterHelper::build_route_name('agents', 'edit_form'), array('id' => $booking->agent_id) ); ?>" target="_blank">
            <span class="os-avatar" style="background-image: url(<?php echo $booking->agent->get_avatar_url(); ?>)"></span>
            <span class="os-name"><?php echo $booking->agent->full_name; ?></span>
          </a>
        </td>
      <?php } ?>
      <?php if(count($locations_list) > 1){ ?>
        <td><?php echo $booking->location->name; ?></td>
      <?php } ?>
      <td>
        <a class="os-with-avatar" href="<?php echo OsRouterHelper::build_link(OsRouterHelper::build_route_name('customers', 'edit_form'), array('id' => $booking->customer_id) ); ?>" target="_blank">
          <span class="os-avatar" style="background-image: url(<?php echo $booking->customer->get_avatar_url(); ?>)"></span>
          <span class="os-name"><?php echo (isset($customer_name_query)) ? preg_replace("/($customer_name_query)/i", '<strong class="os-search-query-match">$1</strong>', $booking->customer->full_name) : $booking->customer->full_name; ?></span>
        </a>
      </td>
      <td><span class="os-column-status os-column-status-<?php echo $booking->status; ?>"><?php echo $booking->nice_status; ?></span></td>
      <td><?php echo $booking->nice_created_at; ?></td>
      <?php 
      $customer = $booking->customer;
      foreach($selected_columns as $column_type => $columns){ 
        foreach($columns as $column_key){ 
          if(isset($available_columns[$column_type][$column_key])){
            if(property_exists($$column_type, $column_key)){
              echo '<td>'.$$column_type->$column_key.'</td>';
            }else{
              echo '<td>'.$$column_type->get_meta_by_key($column_key).'</td>';
            }
          }
        }
      } ?>
      <td><button class="latepoint-btn latepoint-btn-link latepoint-btn-primary" <?php echo OsBookingHelper::quick_booking_btn_html($booking->id); ?>><i class="latepoint-icon latepoint-icon-edit-2"></i><span><?php _e('Edit', 'latepoint'); ?></span></button></td>
    </tr>
    <?php 
  endforeach; 
}?>