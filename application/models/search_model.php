<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}

	public function getsearchname(){
		//get input from user
		$searchvalue = $this->security->xss_clean($this->input->post('searchvalue'));
	 	$searchvalue2 = $this->security->xss_clean($this->input->post('searchvalue2'));
	 	$searchvalue3 = $this->security->xss_clean($this->input->post('searchvalue3'));
		$option = $this->security->xss_clean($this->input->post('keyword'));

		if($option=='range'){

			$sqlresult = $this->db->query("SELECT c.CenterNo, mn.FirstName, mn.MiddleName, mn.LastName, b.BranchName, bc.CaritasBranch_ControlNo, cm.CaritasCenters_ControlNo, m.ControlNo, Date(bc.Date) AS Date, l.AmountRequested AS AmountRequested
			FROM   caritasbranch b, caritasbranch_has_caritascenters bc, caritascenters c, caritascenters_has_members cm, members m, membersname mn, loanapplication_has_members lm, loanapplication l
			WHERE b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = c.ControlNo AND c.ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = mn.ControlNo AND mn.ControlNo = lm.Members_ControlNo AND lm.LoanApplication_ControlNo = l.ControlNo AND l.AmountRequested BETWEEN 
			'$searchvalue2' AND '$searchvalue3' AND m.Approved ='YES' Order by mn.LastName");

			return $sqlresult->result();
		
	}else if ($option=='center'){

	
	$sqlresult = $this->db->query("SELECT c.CenterNo, mn.FirstName, mn.MiddleName, mn.LastName, b.BranchName, bc.CaritasBranch_ControlNo, cm.CaritasCenters_ControlNo, m.ControlNo AS ControlNo
			FROM   caritasbranch b, caritasbranch_has_caritascenters bc, caritascenters c, caritascenters_has_members cm, members m, membersname mn
			WHERE b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = c.ControlNo AND c.ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = mn.ControlNo AND ( CONVERT(`CenterNo` USING utf8) LIKE '$searchvalue') AND m.Approved ='YES' Order by mn.LastName");

			return $sqlresult->result();



		} else if ($option=='year'){

		$sqlresult = $this->db->query("SELECT c.CenterNo, mn.FirstName, mn.MiddleName, mn.LastName, b.BranchName, bc.CaritasBranch_ControlNo, cm.CaritasCenters_ControlNo, m.ControlNo, Date(cm.DateEntered) AS Date
			FROM   caritasbranch b, caritasbranch_has_caritascenters bc, caritascenters c, caritascenters_has_members cm, members m, membersname mn
			WHERE b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = c.ControlNo AND c.ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = mn.ControlNo AND ( CONVERT(`DateEntered` USING utf8) LIKE '$searchvalue%') AND m.Approved ='YES' Order by mn.LastName");

			return $sqlresult->result();


		} else if ($option=='location'){

			$sqlresult = $this->db->query("SELECT * FROM `microfinance2`.`membersaddress` 
				join members on members.ControlNo = membersaddress.ControlNo 
				join (SELECT`Members_ControlNo` ,cm.`CaritasCenters_ControlNo`, cc.`CenterNo`, cbc.`CaritasBranch_ControlNo`, b.`BranchName`, a.`FirstName`, a.`MiddleName`, a.`LastName` FROM `caritascenters_has_members` cm, `caritascenters` cc, `caritasbranch_has_caritascenters` cbc, `caritasbranch` b, `membersname` a where cm.`CaritasCenters_ControlNo` = cc.`ControlNo` and cbc.`CaritasCenters_ControlNo` = cc.`ControlNo` and b.`ControlNo` = cbc.`CaritasBranch_ControlNo` AND `Members_ControlNo` = a.`ControlNo`) sel on sel.`Members_ControlNo` = membersaddress.ControlNo 
				WHERE ( CONVERT(`Address` USING utf8) LIKE '%$searchvalue%') AND members.Approved ='YES' ");

			return $sqlresult->result();

		} else {

		
		$sqlresult = $this->db->query("SELECT *  FROM `microfinance2`.`membersname`
		join members on members.ControlNo = membersname.ControlNo
        join (SELECT`Members_ControlNo` ,cm.`CaritasCenters_ControlNo`, cc.`CenterNo`, cbc.`CaritasBranch_ControlNo`, b.`BranchName` FROM `caritascenters_has_members` cm, `caritascenters` cc, `caritasbranch_has_caritascenters` cbc, `caritasbranch` b where  cm.`CaritasCenters_ControlNo` = cc.`ControlNo` and cbc.`CaritasCenters_ControlNo` = cc.`ControlNo` and b.`ControlNo` = cbc.`CaritasBranch_ControlNo`) sel on sel.`Members_ControlNo` = membersname.ControlNo		
        WHERE ( CONVERT(`FirstName` USING utf8) LIKE '%$searchvalue%' OR CONVERT(`LastName` USING utf8) LIKE '%$searchvalue%' OR CONVERT(`MiddleName` USING utf8) LIKE '%$searchvalue%') AND members.Approved ='YES' 		ORDER BY `membersname`.`LastName` ASC");

			return $sqlresult->result();

	


		}		
	}

}



?>