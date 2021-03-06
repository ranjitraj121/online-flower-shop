<?php 
if($customers){
  foreach ($customers as $customer): ?>
    <tr>
      <td class="text-center os-column-faded"><?php echo $customer->id; ?></td>
      <td>
        <a class="os-with-avatar" href="<?php echo OsRouterHelper::build_link(OsRouterHelper::build_route_name('customers', 'edit_form'), array('id' => $customer->id) ) ?>">
          <span class="os-avatar" style="background-image: url(<?php echo $customer->get_avatar_url(); ?>)"></span>
          <span class="os-name"><?php echo (isset($customer_name_query)) ? preg_replace("/($customer_name_query)/i", "<strong class='os-search-query-match'>$1</strong>", $customer->full_name) : $customer->full_name; ?></span>
        </a>
      </td>
      <td><?php echo (isset($phone_query)) ? preg_replace("/($phone_query)/i", "<strong class='os-search-query-match'>$1</strong>", $customer->phone) : $customer->phone; ?></td>
      <td style="max-width: 220px; overflow: scroll;"><?php echo (isset($email_query)) ? preg_replace("/($email_query)/i", "<strong class='os-search-query-match'>$1</strong>", $customer->email) : $customer->email; ?></td>
      <?php if(OsSettingsHelper::is_using_social_login()){
        $social_google = $customer->google_user_id ? '<i class="latepoint-customer-google latepoint-icon latepoint-icon-google"></i>' : '';
        $social_facebook = $customer->facebook_user_id ? '<i class="latepoint-customer-facebook latepoint-icon latepoint-icon-facebook"></i>' : '';
          echo '<td>'.$social_facebook.$social_google.'</td>'; 
        }
      ?>
      <td><?php echo $customer->total_bookings; ?></td>
      <td><?php echo ($customer->upcoming_booking) ? $customer->upcoming_booking->nice_start_date_time : __('n/a', 'latepoint'); ?></td>
      <td><?php echo ($customer->upcoming_booking) ? $customer->upcoming_booking->time_left : '<span class="time-left is-past">'.__('Past', 'latepoint').'</span>'; ?></td>
      <?php if(OsAuthHelper::wp_users_as_customers()) echo ($customer->wordpress_user_id) ? '<td><a target="_blank" href="'.esc_attr(get_edit_user_link($customer->wordpress_user_id)).'">'.$customer->wordpress_user_id.'</a></td>' : '<td><div class="not-connected-pill"></div></td>'; ?>
      <td><?php echo $customer->formatted_created_date(); ?></td>
      <td><a href="<?php echo OsRouterHelper::build_link(OsRouterHelper::build_route_name('customers', 'edit_form'), array('id' => $customer->id) ); ?>"><i class="latepoint-icon latepoint-icon-edit-2"></i><span><?php _e('Edit', 'latepoint'); ?></span></a></td>
    </tr>
    <?php 
  endforeach;
}?>