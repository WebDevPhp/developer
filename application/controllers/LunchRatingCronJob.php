<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LunchRatingCronJob extends MY_Controller {

	public function index()
	{
		$this->load->model('Cron/Cron_lunch_rating_model');
		$this->Cron_lunch_rating_model->LunchRatingCronJobModel();
	}
	
}
