<?php
('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller']   = 'welcome';
$route['404_override']         = '';
$route['translate_uri_dashes'] = FALSE;

$route['assets/uploads/(:any)/(:any)/(:any)'] 	= "image/resize/";
$route['assets/uploads/(:any)/(:any)'] 			= "image/resize/";


//Routing for Admin Panel
$route['admin']        							= 'admin/admin/index';
$route['admin/login']  							= 'admin/registration/login';
$route['admin/logout'] 							= 'admin/registration/logout';
$route['admin/forgot-password'] 				= 'admin/registration/forgotPassword';
$route['admin/reset-password/(:any)'] 			= 'admin/registration/resetPassword/$1';

// $route['admin/static-page']  					= 'admin/conten/index';
$route['admin/mail-templates']  				= 'admin/mail_templates/index';
$route['admin/update-profile']  				= 'admin/user/updateProfile';
$route['admin/change-password']  				= 'admin/user/changePasswordForAdmin';
$route['admin/add']  							= 'admin/admin/admin_add';
$route['admin/admin-list']  					= 'admin/admin/admin_list';
$route['admin/update/(:any)']  					= 'admin/admin/update/$1';
$route['admin/views/(:any)']  					= 'admin/admin/views/$1';

//Routing For FrontEnd
$route['default_controller'] = 'home';

//Static Pages
$route['privacy-policy'] = 'static_pages/privacy_policy';
$route['about-us'] = 'static_pages/about_us';
$route['terms-conditions'] = 'static_pages/terms_conditions';
$route['cookie-policy'] = 'static_pages/cookie_policy';
$route['faq'] = 'static_pages/faq';
$route['contact-us'] = 'static_pages/contact_us';

//Login-SignUp
$route['login'] = 'users/login';
$route['logout'] = 'users/logout';
$route['sign-up'] = 'register/sign_up';
$route['business-sign-up'] = 'register/business_sign_up';

//E-mail verify and password reset
$route['verify-account/(:any)'] = 'registration/verify_account/$1';
$route['forgot-password'] = 'users/forgot_password';
$route['reset-password/(:any)'] = 'users/reset_password/$1';

$route['business'] = 'business/business_type';
$route['business/business-detail/(:any)'] = 'business/business_detail/$1';

//Profile
$route['add-service'] = 'dashboard/add_service';
$route['edit-service/(:any)'] = 'dashboard/edit_service/$1';
$route['my-profile'] = 'dashboard/my_profile';
$route['update-profile'] = 'dashboard/update_profile';
$route['fees-and-availiability'] = 'fees_availiability';
$route['trading-timming/(:any)'] = 'fees_availiability/trading_timming/$1';
$route['view-quote'] = 'quotes';
$route['view-quote-detail/(:any)'] = 'quotes/view_quote_detail/$1';
$route['membership-and-payment'] = 'membership_payment';

//Payment
$route['purchase-plan'] = 'plan/purchase_plan';
$route['change-plan'] = 'plan/change_plan';

$route['my-membership'] = 'membership_payment/my_membership';
$route['cancel-plan'] = 'membership_payment/cancel_plan';
$route['billing-history'] = 'membership_payment/billing_history';

//Fees and availibility
$route['base-room-groups/(:any)'] = 'fees_availiability/base_rooms/$1';
$route['non-funded-children'] = 'fees_availiability/non_funded_age_group';
//$route['non-funded-children/session/(:any)'] = 'fees_availiability/non_funded_session/$1';
$route['non-funded-children/session'] = 'fees_availiability/non_funded_session';

$route['non-funded-children/set-monthly-fees'] = 'fees_availiability/non_funded_monthly_fees';
$route['non-funded-children/set-room-availiability'] = 'fees_availiability/business_room_availiability';

//Funded fees and availibility
$route['funded-children/session'] = 'funded_fees_availiability/funded_session';
$route['funded-children/set-monthly-fees'] = 'funded_fees_availiability/funded_monthly_fees';
$route['funded-children/set-room-availiability'] = 'funded_fees_availiability/business_room_availiability';


//User quote
$route['start-quote'] = 'user_quote/start_quote';
$route['non-funded-age-group-0-2/(:any)'] = 'user_quote/start_quote_one/$1';
$route['funded-age-group-2-3/(:any)'] = 'user_quote/funded_start_quote_one/$1';
$route['funded_15/age-group-3-5/(:any)'] = 'user_quote/funded_start_quote_two/$1';
$route['funded_30/age-group-3-5/(:any)'] = 'user_quote/funded_start_quote_three/$1';
$route['non-funded-age-group-above-5/(:any)'] = 'user_quote/non_funded_quote_above_5/$1';
$route['non-funded-age-group-above-5/(:any)'] = 'user_quote/non_funded_quote_above_5/$1';
$route['user-quote/(:any)'] = 'user_quote/quoted/$1';
$route['user-quote-detail'] = 'user_quote/detail';
$route['saved-quote-detail'] = 'user_quote/save_quote_detail';
$route['user-save-quote/(:any)'] = 'user_quote/view_save_quote/$1';

//Booking 
$route['book-now'] = 'booking/book_now';
$route['booking-history'] = 'booking/booking_list';
$route['bookings'] = 'booking/business_booking_list';
