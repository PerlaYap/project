<?php if ( !  defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function reportList(){
		$this->load->view('header');
		$this->load->view('navigation');
        $this->load->view("reports/list");
        $this->load->view("footer");
	}

    public function reportListMIS(){
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view("reports/mislist");
        $this->load->view("footer");
    }

    public function mismonthly(){   
        $this->load->view("reports/misMonthly");
    }

    public function loanportfolio(){   
        $this->load->view("reports/loanportfolio");
    }

    public function sbushares(){   
        $this->load->view("reports/sbushares");
    }

    public function pdmmonthly(){   
        $this->load->view("reports/pdmmonthly");
    }
    
	public function getSpecifiedReport(){
		$reportType=$this->input->post('reporttype');

		if($reportType=="daily"){
			$this->getDCSummary();
		}
        else if($reportType=="dailySO"){
            $this->getDCSO();
        }
        else if($reportType=="dailyManager"){
            $this->getDCManager();
        }
        else if($reportType=='yearly'){
            $this->getYearlyTrend();
        }
        else if($reportType=='yearlyCompare'){
            $this->getYearlyComparisonTrend();
        }
	}

		public function getOtherDC(){

		$dcDate = $this->input->post('reportDate');
		$extra=strtotime($dcDate);
		$day = date('l', $extra);
		

		$data=array('branchControl'=>$this->input->post('dcbranchControl'), 
					'centerControl'=>$this->input->post('dccenterControl'),
					'reportDate'=>$dcDate, 'day'=>$day );

		$this->load->view("reports/dcsummary",$data);
		}

        public function getDCSummary(){
		$dcday = $this->input->post('dcday');
		$extra=strtotime($dcday);
		$day = date('l', $extra);
		

		$data=array('branchControl'=>$this->input->post('dcbranchControl'), 
					'centerControl'=>$this->input->post('dccenterControl'),
					'reportDate'=>$dcday, 'day'=>$day );
	
		$this->load->view("reports/dcsummary",$data);
		}

        public function getDCSO(){
            $dcday = $this->input->post('dcday');
            $extra=strtotime($dcday);
            $day = date('l', $extra);
        

            $data=array('branchno'=>$this->input->post('dcbranchControl'),
                    'date'=>$dcday, 'day'=>$day );
    
            $this->load->view("reports/dailycollectionsheetSO",$data);
        }

        public function getDCManager(){
            $dcday = $this->input->post('dcday');
            $extra=strtotime($dcday);
            $day = date('l', $extra);
        

            $data=array('branchno'=>$this->input->post('dcbranchControl'),
                    'date'=>$dcday, 'day'=>$day );
    
            $this->load->view("reports/dailycollectionsheetManager",$data);
        }

        public function getYearlyTrend(){
        $type=1;
        $data=array('years'=>$this->input->post('yearlyyear'),'type'=>$type);
        
        $this->load->view("reports/trend",$data);
        }

        public function getYearlyComparisonTrend(){
        $type=2;
        $data=array('years'=>$this->input->post('yearlyyear1'),
            'years1'=>$this->input->post('yearlyyear2'),'type'=>$type);
        
        $this->load->view("reports/trend",$data);
        }

        public function getSpecifiedReportMIS(){
        $reportType=$this->input->post('reporttype');

        if($reportType=="collection"){
            $this->getCollectionReport();
        }
        else if($reportType=='account'){
            $this->getAccountReport();
        }
        else if($reportType=='loanport'){
            $this->getLoanPortfolio();
        }
        else if($reportType=='saving'){
            $this->getSavings();
        }
    }

    public function getCollectionReport(){
        $this->load->model("branchpastdue_model");
        $data=$this->input->post('monthyear');
        $dateTime=strtotime($data);

        $data1['pastduesbranch'] = $this->branchpastdue_model->getbranchpastdue($dateTime);
        $data1['month']=date('F',$dateTime);
        $data1['year']=date('Y',$dateTime);

        $this->load->view("reports/branchperformance",$data1);
        }

        public function getAccountReport(){
        $data=$this->input->post('monthyear');
        $dateTime=strtotime($data);
        $data1=array('datetoday'=>date('Y-m-d',$dateTime),
            'month'=>date('m',$dateTime),
            'monthWord'=>date('F',$dateTime),
            'year'=>date('Y',$dateTime));


        $this->load->view("reports/misMonthly",$data1);
        }

        public function getLoanPortfolio(){
        $data=$this->input->post('monthyear');
        $dateTime=strtotime($data);
        $data1=array('date'=>date('Y-m-d',$dateTime),
            'month'=>date('m',$dateTime),
            'monthWord'=>date('F',$dateTime),
            'year'=>date('Y',$dateTime));


        $this->load->view("reports/loanportfolio",$data1);
        }

        public function getSavings(){
        $data=$this->input->post('monthyear');
        $dateTime=strtotime($data);
        $data1=array('date'=>date('Y-m-d',$dateTime),
            'month'=>date('m',$dateTime),
            'monthWord'=>date('F',$dateTime),
            'year'=>date('Y',$dateTime));


        $this->load->view("reports/sbushares",$data1);
        }

    /*
        <option value="collection">Collection Performance of Branches</option>
                    <option value="account">Monthly Account Report</option>
                    <option value="loanport">Monthly Loan Portfolio Report</option>
                    <option value="saving">Monthly Savings Build-Up and Capital Shares Report</option>
    */

        //Search
		public function search(){
    
        //load model
        $this->load->model('search_model');
        $data['searchval'] = $this->search_model->getsearchname();
        
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('general/search', $data);
        $this->load->view('footer');

        }
    public function profiles(){

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view("general/profile");
        $this->load->view("footer");
       
        }

     
    public function editprofile(){
    
      $this->load->model('editprofile_model');
      $data['number'] = $this->editprofile_model->getcontrolno();
   	
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('salveofficer/SOeditmember',$data);
        $this->load->view("footer");
    	}
    public function editmember(){

        $this->load->model('editprofiledetails_model');
       $result = $this->editprofiledetails_model->setdetails();

       if ($result) {
           echo "<script type='text/javascript'>alert('Successfully Updated Profile!')</script>";
       }else{
            echo "<script type='text/javascript'>alert('Failed to update profile!')</script>";
       }

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('salveofficer/homepage'); 
        $this->load->view('footer');
       
    	}

    /*REPORTS   VIEW*/

    public function monthlycollection(){
    	$this->load->view('reports/monthlycollection'); 
    }
    public function portfolioatrisk(){
    	$this->load->view('reports/portfolioatrisk'); 
    }
    public function revenueandcost(){
    	$this->load->view('reports/revenueandfinancialcosts'); 
    }
    public function sbuandloan(){
    	$this->load->view('reports/sbuandloanreport'); 
    }
    public function dailycollectionsheet(){
    	$this->load->view('reports/dailycollectionsheetSO'); 
    }
    public function centerperformance(){

        $this->load->model("centerperformance_model");
        $data['pastdues'] =$this->centerperformance_model->getperformance();

        $this->load->view('reports/centerperformance', $data);    
    }
    public function borrowerandsaver(){
        $this->load->view('reports/borrowerandsaver'); 
    }

    public function editcollection(){
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view("salveofficer/editcollection");
        $this->load->view('footer');
        }

    public function edittransaction(){
        $this->load->model('editcollection_model');
        $result = $this->editcollection_model->gettransaction();

        if ($result['result'] = true) {

            /*$activity = "Added new member named ".$result." .";*/

            if ($result['prev_ttype'] == $result['transaction_type']) {
                    $activity = "Changed ".$result['transaction_type']." transaction (".$result['transactno'].") of ".$result['membername'].".  [PREVIOUS AMOUNT: ".$result['prev_amount'] ." | NEW AMOUNT: ".$result['amount'] ." ]" ;       
                }else{
                    $activity = "Changed transaction (".$result['transactno'] .") of ".$result['membername']."  [PREVIOUS TRASACTION TYPE: ".$result['prev_ttype']."  |  AMOUNT: ".$result['prev_amount']."] ---> [NEW TRANSACTION TYPE: ".$result['transaction_type']."  |  AMOUNT: ".$result['amount']."]" ;
                }            

            $this->load->model("audittrail_model");
            $this->audittrail_model->setlog($activity);

           echo "<script type='text/javascript'>alert('Successfully Changed Transaction!')</script>";
       }else{
            echo "<script type='text/javascript'>alert('Failed to Change Transaction!')</script>";
       }

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('reports/list'); 
        $this->load->view('footer');
  }



    /*TRYING*/

    public function savetopdf(){
        require 'pdfcrowd.php';
            try
{   
    // create an API client instance
    $client = new Pdfcrowd("pearl", "b188b1bec1d71d770535a39811a59fa1");

    // convert a web page and store the generated PDF into a $pdf variable
    
     $pdf = $client->convertURI(site_url('reports/sbuandloan'));

    // set HTTP response headers
    header("Content-Type: application/pdf");
    header("Cache-Control: max-age=0");
    header("Accept-Ranges: none");
    header("Content-Disposition: attachment; filename=\"google_com.pdf\"");

    // send the generated PDF 
    echo $pdf;
}
catch(PdfcrowdException $why)
{
    echo "Pdfcrowd Error: " . $why;
}
    }

}

?>