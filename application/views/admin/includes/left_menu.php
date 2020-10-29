	<div class="page-sidebar-wrapper">
		<div class="page-sidebar md-shadow-z-2-i  navbar-collapse collapse">
			<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				 <li class="start <?php echo ($left_menu == 'Dashboard')?'active':''; ?>">
					<a href="<?php echo site_url('admin'); ?>">
					<i class="icon-home"></i>
					<span class="title">Dashboard</span>
					</a>
				</li>

				
				<li class="<?php echo ($left_menu == 'user_module')?'active open':''; ?>">
					<a href="javascript:;">
						<i class="fa fa-users"></i>
						<span class="title">User Module</span>
						<span class="arrow <?php echo ($left_menu == 'user_module')?'open':''; ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'user_list')?'active':''; ?>">
							<a href="<?php echo base_url('admin/users'); ?>">		
							<i class="fa fa-list"></i>
							<span class="title">Users</span>	
							</a>
						</li>

						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'business_users')?'active':''; ?>">
							<a href="<?php echo base_url('admin/business_users'); ?>">		
							<i class="fa fa-list"></i>
							<span class="title">Business Users</span>	
							</a>
						</li>
					</ul>
				</li>

				<li class="<?php echo ($left_menu == 'service_module')?'active open':''; ?>">
					<a href="javascript:;">
						<i class="fa fa-list-alt"></i>
						<span class="title">Services</span>
						<span class="arrow <?php echo ($left_menu == 'service_module')?'open':''; ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'service_list')?'active':''; ?>">
							<a href="<?php echo base_url('admin/services'); ?>">		
							<i class="fa fa-list"></i>
							<span class="title">List</span>	
							</a>
						</li>
					</ul>
				</li>

				<!-- <li class="<?php echo ($left_menu == 'membership_plan_module')?'active open':''; ?>">
					<a href="javascript:;">
						<i class="fa fa-credit-card"></i>
						<span class="title">Membership Plan</span>
						<span class="arrow <?php echo ($left_menu == 'membership_plan_module')?'open':''; ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'membership_plan_list')?'active':''; ?>">
							<a href="<?php echo base_url('admin/membership_plan'); ?>">		
							<i class="fa fa-list"></i>
							<span class="title">List</span>	
							</a>
						</li>
					</ul>
				</li> -->

				<li class="<?php echo ($left_menu == 'business_module')?'active open':''; ?>">
					<a href="javascript:;">
						<i class="fa fa-briefcase"></i>
						<span class="title">Business Type Module</span>
						<span class="arrow <?php echo ($left_menu == 'business_module')?'open':''; ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'business_type_list')?'active':''; ?>">
							<a href="<?php echo base_url('admin/business_types'); ?>">		
							<i class="fa fa-list"></i>
							<span class="title">List</span>	
							</a>
						</li>
					</ul>
				</li>

				<li class="<?php echo ($left_menu == 'feedback_module')?'active open':''; ?>">
					<a href="javascript:;">
						<i class="fa fa-calendar"></i>
						<span class="title">Client Module</span>
						<span class="arrow <?php echo ($left_menu == 'feedback_module')?'open':''; ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'feedback_list')?'active':''; ?>">
							<a href="<?php echo base_url('admin/client_feedback'); ?>">		
							<i class="fa fa-list"></i>
							<span class="title">Feedback List</span>	
							</a>
						</li>
					</ul>
				</li>

				<li class="<?php echo ($left_menu == 'service_category_module')?'active open':''; ?>">
					<a href="javascript:;">
						<i class="fa fa-list-alt"></i>
						<span class="title">Service Categories</span>
						<span class="arrow <?php echo ($left_menu == 'service_category_module')?'open':''; ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'service_category_list')?'active':''; ?>">
							<a href="<?php echo base_url('admin/service_category'); ?>">		
							<i class="fa fa-list"></i>
							<span class="title">List</span>	
							</a>
						</li>
					</ul>
				</li>

				<li class="<?php echo ($left_menu == 'inquiry_management')?'active open':''; ?>">
					<a href="javascript:;">
						<i class="fa fa-phone"></i>
						<span class="title">Contact Us</span>
						<span class="arrow <?php echo ($left_menu == 'inquiry_management')?'open':''; ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'contact_queries')?'active':''; ?>">
							<a href="<?php echo base_url('admin/contact_queries'); ?>">		
							<i class="fa fa-list"></i>
							<span class="title">List</span>	
							</a>
						</li>
					</ul>
				</li>

				<li class="<?php echo ($left_menu == 'Content_management')?'active open':''; ?>">
					<a href="javascript:;">
						<i class="fa fa-language"></i>
						<span class="title">Static Content</span>
						<span class="arrow <?php echo ($left_menu == 'Content_management')?'open':''; ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'content')?'active':''; ?>">
							<a href="<?php echo base_url('admin/content'); ?>">		
								<i class="fa fa-list"></i>
								<span class="title">List</span>	
							</a>
						</li>

						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'home_page')?'active':''; ?>">
							<a href="<?php echo base_url('admin/content/home_page'); ?>">		
								<i class="fa fa-list"></i>
								<span class="title">Home Page</span>	
							</a>
						</li>

						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'about_us')?'active':''; ?>">
							<a href="<?php echo base_url('admin/content/about_us_team'); ?>">		
								<i class="fa fa-list"></i>
								<span class="title">Team Member</span>	
							</a>
						</li>

						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'faq_list')?'active':''; ?>">
							<a href="<?php echo base_url('admin/faq'); ?>">		
								<i class="fa fa-list"></i>
								<span class="title">FAQ'S</span>	
							</a>
						</li>
					</ul>
				</li>

				<!-- <li class="<?php echo ($left_menu == 'send_email_module')?'active open':''; ?>">
					<a href="javascript:;">
						<i class="fa fa-envelope-o"></i>
						<span class="title">Send Email Module</span>
						<span class="arrow <?php echo ($left_menu == 'send_email_module')?'open':''; ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'templates_list')?'active':''; ?>">
							<a href="<?php echo base_url('admin/send_email'); ?>">		
							<i class="fa fa-list"></i>
							<span class="title">Templates</span>	
							</a>
						</li>

						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'email_sent_list')?'active':''; ?>">
							<a href="<?php echo base_url('admin/send_email/email_sent_list'); ?>">
							<i class="fa fa-list"></i>
							<span class="title">Email Sent List</span>	
							</a>
						</li>
					</ul>
				</li> -->
				
				<!-- <li class="<?php echo ($left_menu == 'fees_availiability')?'active open':''; ?>">
					<a href="javascript:;">
					<i class="fa fa-money"></i>
					<span class="title">Fees Availiability</span>
					<span class="arrow <?php echo ($left_menu == 'fees_availiability')?'open':''; ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'fees_availiability_list')?'active':''; ?>">
							<a href="<?php echo base_url('admin/fees_availiability'); ?>">		
							<i class="fa fa-list"></i>
							<span class="title">List</span>	
							</a>
						</li>
					</ul>
				</li>

				<li class="<?php echo ($left_menu == 'request_quote')?'active open':''; ?>">
					<a href="javascript:;">
					<i class="fa fa-leaf"></i>
					<span class="title">Request quote</span>
					<span class="arrow <?php echo ($left_menu == 'request_quote')?'open':''; ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'request_quote_list')?'active':''; ?>">
							<a href="<?php echo base_url('admin/request_quote'); ?>">		
							<i class="fa fa-list"></i>
							<span class="title">List</span>	
							</a>
						</li>
					</ul>
				</li> -->

				<!-- <li class="<?php echo ($left_menu == 'payment_history')?'active open':''; ?>">
					<a href="javascript:;">
					<i class="fa fa-envelope"></i>
					<span class="title">Payment history</span>
					<span class="arrow <?php echo ($left_menu == 'payment_history')?'open':''; ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'payment_history_list')?'active':''; ?>">
							<a href="<?php echo base_url('admin/payment_history'); ?>">		
							<i class="fa fa-list"></i>
							<span class="title">List</span>	
							</a>
						</li>
					</ul>
				</li> -->

				<li class="<?php echo ($left_menu == 'Mail_templates')?'active open':''; ?>">
					<a href="javascript:;">
					<i class="fa fa-envelope"></i>
					<span class="title">Email Templates</span>
					<span class="arrow <?php echo ($left_menu == 'Mail_templates')?'open':''; ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'List_templates')?'active':''; ?>">
							<a href="<?php echo base_url('admin/mail_templates'); ?>">		
							<i class="fa fa-list"></i>
							<span class="title">List</span>	
							</a>
						</li>
					</ul>
				</li>

				
				<li class="<?php echo ($left_menu == 'Site_options')?'active open':''; ?>">
					<a href="javascript:;">
					<i class="fa fa-wrench"></i>
					<span class="title">Site Options</span>
					<span class="arrow <?php echo ($left_menu == 'Site_options')?'open':''; ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo (isset($left_submenu) && $left_submenu == 'Website_setting')?'active':''; ?>">
							<a href="<?php echo base_url('admin/website'); ?>">		
							<i class="icon-settings"></i>
							<span class="title">Website Setting</span>	
							</a>
						</li>
					</ul>
				</li>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
<!-- END SIDEBAR