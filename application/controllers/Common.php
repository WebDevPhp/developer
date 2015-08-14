<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends MY_Controller {

	public $datetime;
	
	public function __construct()
	{
		parent::__construct();
		$this->datetime = date("Y-m-d H:i:s");
	}

	public function friendrequest(){
		$userdata = json_decode($this->session->userdata('UserData'),true);
		$this->load->model('Common/Common_model');
		$ids = array(
					'ceo1_id'=>$userdata[0]['id'], 
					'ceo2_id'=>$this->input->post('receiverid'),
					'created_on'=>$this->datetime,
					'accepted'=>2,
					'is_viewed'=>true,
					'is_active'=>true,
				);
		$this->Common_model->friendrequestModel($ids);
	}
	
	public function responseLunchRequest(){
		$this->load->model('Common/Common_model');
		$this->Common_model->responseLunchRequestModel($this->input->post());
	}
	
	public function updateFriendRequest(){
		$this->load->model('Common/Common_model');
		$this->Common_model->updateFriendRequestModel($this->input->post());
	}
	
	public function changeFriendNotificationStatus(){
		$this->load->model('Common/Common_model');
		$this->Common_model->changeFriendNotificationStatusModel($this->input->post());
	}
	
	public function changeRequestsNotificationStatus(){
		$this->load->model('Common/Common_model');
		$this->Common_model->changeRequestsNotificationStatusModel($this->input->post());
	}
	
	public function changeMessageNotificationStatus(){
		$this->load->model('Common/Common_model');
		$this->Common_model->changeMessageNotificationStatusModel($this->input->post());
	}
	
	public function changeGeneralNotificationStatus(){
		$this->load->model('Common/Common_model');
		$data = array('notification_id' => $this->input->post('notification_id'));
		$notify = $this->Common_model->changeGeneralNotificationStatusModel($data);
		return $notify;
	}
	
	public function changeNotificationReadUnread(){
		$log_id = $this->input->post('log_id');
		$this->load->model('Common/Common_model');
		$this->Common_model->changeNotificationReadUnreadModel($log_id);
	}
	
	
	public function searchTopHeader(){
		$keyword = $this->input->post('keyword');
		$this->load->model('Common/Common_model');
		$this->Common_model->searchTopHeaderModel($keyword);
	}
	
	public function getNotificationJquery(){
		$userdata = json_decode($this->session->userdata('UserData'),true);
		$this->load->model('Notifications/Notifications_model');
		$this->Notifications_model->getNotificationJqueryModel($userdata[0]['id']);
	}
	
}
