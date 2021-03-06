<?php
	include('controller.php');
	
	class Colleges extends Controller
	{
		public $headerMsg;
		public $result;
		private $model;
		
		private $validParameters = array("collegecode","collegename");									
		
		public function __construct()
		{
			parent::__construct();
			
			include('models/colleges.php');
			$this->model= new CollegesModel($this->page,$this->size);
			
			if ($this->headerCode == 200)			
			{
				$this->headerMsg = 'HTTP/1.1 200 OK';				
				$this->route();
			}
			else
			{
				$this->headerMsg = 'HTTP/1.1 405 Method Not Allowed';
				$this->result['Failed'] = "Only GET requests are honored";
			}
				
		}
		
		private function route()
		{
			if (isset($this->parameters))
			{
				if (in_array($this->parameters[0],$this->validParameters) && count($this->parameters) == 1)
				{

					if ($this->parameters[0] == $this->validParameters[0])
						$this->getByCollegeCode($this->values[0]);
					else 
						$this->getByCollegeName($this->values[0]);
				}
				else	//bad request
				{
					$this->headerMsg = 'HTTP/1.1 400 Bad Request';
					$this->result['Failed'] = "Invalid parameter(s) passed";
				}
			}
			else	//no parameters. Return all
			{
				$this->getAll();
			}
		}
		
		private function getAll()
		{			
			$this->model->getAll();
			$this->result['campuses']['campus'] = $this->model->output;
			$this->result['count'] = (int)$this->model->count;
			$this->result['status'] = "ok";
		}
		
		private function getByCollegeCode($collegecode)
		{			
			$this->model->getByCollegeCode($collegecode); 			
			$this->result['colleges']['college'] =  $this->model->output;
			$this->result['count'] = (int)$this->model->count;
			$this->result['status'] = "ok";
		}
		
		private function getByCollegeName($collegename)
		{
			$this->model->getByCollegeName($collegename); 			
			$this->result['colleges']['college'] =  $this->model->output;
			$this->result['count'] = (int)$this->model->count;
			$this->result['status'] = "ok";			
		}
	}
?>