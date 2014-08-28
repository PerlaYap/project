<?php if ( !  defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function reportList(){
		$this->load->view('header');
		$this->load->view('navigation');
        $this->load->view("reports/list");
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
		$month = $this->input->post('dcmonth');
		$day = $this->input->post('dcday');
		$year = $this->input->post('dcyear');
		$dcDate = $year."-".$month."-".$day;
		$extra=strtotime($dcDate);
		$day = date('l', $extra);
		

		$data=array('branchControl'=>$this->input->post('dcbranchControl'), 
					'centerControl'=>$this->input->post('dccenterControl'),
					'reportDate'=>$dcDate, 'day'=>$day );
		
		/*$this->load->view("header");
		$this->load->view("navigation");*/
		$this->load->view("reports/dcsummary",$data);
		/*$this->load->view("footer");*/
		}

        public function getYearlyTrend(){
        $type=1;
        $data=array('years'=>$this->input->post('yearlyyear'),'type'=>$type);
        
        /*$this->load->view("header");
        $this->load->view("navigation");*/
        $this->load->view("reports/trend",$data);
        /*$this->load->view("footer");*/
        }

        public function getYearlyComparisonTrend(){
        $type=2;
        $data=array('years'=>$this->input->post('yearlyyear1'),
            'years1'=>$this->input->post('yearlyyear2'),'type'=>$type);
        
        /*$this->load->view("header");
        $this->load->view("navigation");*/
        $this->load->view("reports/trend",$data);
        /*$this->load->view("footer");*/
        }

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
    	$this->load->view('reports/dailycollectionsheet'); 
    }
    public function centerperformance(){

        $this->load->model("centerperformance_model");
        $data['pastdues'] =$this->centerperformance_model->getperformance();

        $this->load->view('reports/centerperformance', $data);    
    }
    public function borrowerandsaver(){
        $this->load->view('reports/borrowerandsaver'); 
    }

  


    public function branchpastdue(){
        $this->load->model("branchpastdue_model");
       $data['pastduesbranch'] = $this->branchpastdue_model->getbranchpastdue();

        $this->load->view('reports/branchperformance', $data);
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

        if ($result) {
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