<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Contact_queries extends CI_Controller {
	function __construct() {
		Parent::__construct();
		$this->common_model->checkAdminLogin();
		$this->load->model('admin/contact_queries_model', 'contact_queries');
		$this->load->model('Mailsending_model', 'mailsend');
	}
	function index()
	{
		$output['page_title'] = 'List of Contact Queries';
		$output['left_menu'] = 'inquiry_management';
		$output['left_submenu'] = 'contact_queries';
		$records = $this->contact_queries->getAllContactQueries();

		foreach ($records as $key => $value) {
	        $value->add_date = $this->common_model->getGMTDateToLocalDate($value->add_date);
		}

		$output['allContact'] = $records;

		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/contact_queries/contact_list');
		$this->load->view('admin/includes/footer');
	}
    

	function reply($id)
	{
		$output['page_title'] = 'Reply Contact Queries';
		$output['left_menu'] = 'inquiry_management';
		$output['left_submenu'] = 'contact_queries';

		$input['is_viewed'] = 'Yes';
		$this->contact_queries->updateContactQuery($id,$input);
		
		$contactQueries = $this->contact_queries->getSignleRecordById($id);
		if(isset($_POST) && !empty($_POST))
		{
			//pr($_POST); die;
			$this->form_validation->set_rules('reply_message', 'Reply Message', 'trim|required');
			if($this->form_validation->run())
			{
				if($contactQueries->reply_message){
					$message = 'Your message has sent successfully';
					$success = true;
				} else {
					$input = array();
					$input['is_replied'] = 'Yes';
					$this->contact_queries->updateContactQuery($id,$input);
	                
	                $query_reply =  array();
	                $query_reply['contact_us_id '] = $id;
	                $query_reply['reply_message'] = $this->input->post('reply_message');
	                $query_reply['add_date'] = $this->common_model->getDefaultToGMTDate(time());

	                $this->contact_queries->replyContactQuery($query_reply, $id);

	                $this->mailsend->replyContactQuery($this->input->post('reply_message'), $id);

					$message = 'Reply Message Successfully Sent';
					$success = true;
					$output['redirectURL'] = site_url('admin/contact_queries');
				}
			}
			else
			{
				$success = false;
				$message = validation_errors();
			}
			$output['message'] = $message;
			$output['success'] = $success;
			echo json_encode($output);die;
		}
		$output['contactQueries'] = $contactQueries;		
		$this->load->view('admin/includes/header',$output);
		$this->load->view('admin/contact_queries/view_contact');
		$this->load->view('admin/includes/footer');
	}	

	function delete()
	{
		$id = $this->input->post('record_id');
		$this->contact_queries->deleteContactById($id);
		$this->contact_queries->deleteContactReplyByContactId($id);
		$data['success'] = true;
		$data['message'] = 'Record Deleted Successfully';
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}

	function multiTaskOperation()
	{
		$task = $this->input->post('task');
		$ids = $this->input->post('ids');
		$dataIds = explode(',',$ids);
		foreach ($dataIds as $key => $value) 
		{
			if($task == 'Delete')
			{
				$this->contact_queries->deleteContactById($value);
				$this->contact_queries->deleteContactReplyByContactId($value);
				$message = 'Selected record deleted successfully.';
			}
			
		}		
		$data['ids'] = $ids;
		$data['success'] = true;
		$data['message'] = $message;
		$data['callBackFunction'] = 'callBackCommonDelete';
		echo json_encode($data); die;
	}
}