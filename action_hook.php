<?php
/**
 *
 */
function niche_hunter_aws_backend_api_call($url, $params) {
	$data_string = json_encode($params);
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($data_string))
	);

	$result = curl_exec($ch);
	return $result;
}

/**
 *	To hook User Register action
 */
 function niche_hunter_user_registered() {
	$email = $_POST['email'];
	$name = "{$_POST['sr_firstname']} {$_POST['sr_lastname']}";
	$password = $_POST["password"];
	
	$date = new DateTime();
	$date->add(new DateInterval("P3D"));
	// echo $date->format("m/d/Y H:i:s");

	$data = array(
		"email" => $email, 
		"name" => $name, 
		"password" => $password, 
		"expiration_date" => $date->format("m/d/Y H:i:s"),
		"membership_tier" => "e"
	);
													  
	$result = niche_hunter_aws_backend_api_call('http://34.230.77.124/api/v1/register', $data);
 }
 add_action('woocommerce_register_post', niche_hunter_user_registered);
 // add_action('woocommerce_checkout_login_form', niche_hunter_user_registered);
 
 
 /**
  *	Membership subscription created action hook
  */
 function niche_hunter_user_membership_create($subs_id, $old, $new, $subs) {
	 $date = new DateTime();
	 $date->add(new DateInterval("P1M"));
	 $user = wp_get_current_user();
	 
	 $items = $subs->get_items();
		 
	 foreach($items as $item) {
		 $product = $item->get_product();
		 $name = $product->get_name();break;
	 }
	 
	 if ($new == "active" || $new == "switched") {
		 $user_id = $subs->get_user_id();
		 $result = WC_Subscriptions_Manager::get_users_subscriptions( $user_id );
		 $count = sizeof($result) - 1;
		 foreach($result as $key => $item) {
			 $expiry_date = $item['trial_expiry_date'];
		 }
		 
		 if ($expiry_date && new DateTime($expiry_date . " GMT") > new DateTime()) {
			 $membership_tier = "t";
		 } else {
			 $membership_tier = "l";
 			 if (strpos(strtolower($name), "pro") > -1) {
				 $membership_tier = "p";
			 }
			 $expiry_date = $date->format("m/d/Y H:i:s");
		 }
		 $params = array(
			 'email' => $user->user_email,
			 'membership_tier' => $membership_tier,
			 'expiration_date' => $expiry_date
		 );
		 //echo "Active\n";
		 $result = niche_hunter_aws_backend_api_call('http://34.230.77.124/api/v1/membership/extend', $params);
	 } else if ($new == "cancelled" || $new == "expired" || $new == 'pending-cancel') {
		 $params = array(
			 'email' => $user->user_email
		 );
		 $result = niche_hunter_aws_backend_api_call('http://34.230.77.124/api/v1/membership/expire', $params);
	 }
 }
 add_action('woocommerce_subscription_status_changed', niche_hunter_user_membership_create, 10, 4);
 
 /**
  *	Membership subscription created action hook
  */
 function niche_hunter_subscription_switched($subs) {
	 $date = new DateTime();
	 $date->add(new DateInterval("P1M"));
	 $user = wp_get_current_user();
	 
	 $items = $subs->get_items();
		 
	 foreach($items as $item) {
		 $product = $item->get_product();
		 $name = $product->get_name();break;
	 }
	 
	 $user_id = $subs->get_user_id();
	 $result = WC_Subscriptions_Manager::get_users_subscriptions( $user_id );
	 $count = sizeof($result) - 1;
	 foreach($result as $key => $item) {
		 $expiry_date = $item['trial_expiry_date'];
	 }
	 
	 if ($expiry_date && new DateTime($expiry_date . " GMT") > new DateTime()) {
		 $membership_tier = "t";
	 } else {
		 $membership_tier = "l";
		 if (strpos(strtolower($name), "pro") > -1) {
			 $membership_tier = "p";
		 }
		 $expiry_date = $date->format("m/d/Y H:i:s");
	 }
	 $params = array(
		 'email' => $user->user_email,
		 'membership_tier' => $membership_tier,
		 'expiration_date' => $expiry_date
	 );
	 
	 $result = niche_hunter_aws_backend_api_call('http://34.230.77.124/api/v1/membership/extend', $params);
 }
 add_action('woocommerce_subscriptions_switch_completed', niche_hunter_subscription_switched, 10, 1);


function niche_hunter_my_profile_update( $user_id ) {
  	$user = wp_get_current_user();
    if ( ! isset( $_POST['password_1'] ) || '' == $_POST['password_1'] || $_POST['password_1'] !== $_POST['password_2'] ) {
        return;
    }

  	$params = array(
		 'email' => $user->user_email,
		 'password' => $_POST['password_2'],
	);
  	
  	$result = niche_hunter_aws_backend_api_call('http://34.230.77.124/api/v1/reset_password', $params);
}
add_action( 'profile_update', 'niche_hunter_my_profile_update' );

function niche_hunter_reset_password( $user, $new_pass ) {
  	$params = array(
		 'email' => $user->user_email,
		 'password' => $new_pass,
	);
  	
  	$result = niche_hunter_aws_backend_api_call('http://34.230.77.124/api/v1/reset_password', $params);
}
add_action( 'password_reset', 'niche_hunter_reset_password', 10, 2 );