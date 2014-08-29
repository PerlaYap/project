		
			function TabInfo(){
		        document.getElementById("info").style.backgroundColor = '#a7321a';
		        document.getElementById("info").style.color = '#ede8ea';
		        document.getElementById("divprofile").style.display="";
		        
		        document.getElementById("loan").style.backgroundColor = '#f0f0f0';
		        document.getElementById("loan").style.color = '#2a2527';
		        document.getElementById("divloan").style.display="none";

		        document.getElementById("savings").style.backgroundColor = '#f0f0f0';
		        document.getElementById("savings").style.color = '#2a2527';
		        document.getElementById("divsavings").style.display="none";

		        document.getElementById("performance").style.backgroundColor = '#f0f0f0';
		        document.getElementById("performance").style.color = '#2a2527';
		        document.getElementById("divperformance").style.display="none";
	        }

	        function TabLoan(){
		        document.getElementById("loan").style.backgroundColor = '#a7321a';
		        document.getElementById("loan").style.color = '#ede8ea';
		        document.getElementById("divloan").style.display="";
				document.getElementById("TransactionLog").style.display="none";



		        document.getElementById("info").style.backgroundColor = '#f0f0f0';
		        document.getElementById("info").style.color = '#2a2527';
		        document.getElementById("divprofile").style.display="none";

		        document.getElementById("savings").style.backgroundColor = '#f0f0f0';
		        document.getElementById("savings").style.color = '#2a2527';
		        document.getElementById("divsavings").style.display="none";

		        document.getElementById("performance").style.backgroundColor = '#f0f0f0';
		        document.getElementById("performance").style.color = '#2a2527';
		        document.getElementById("divperformance").style.display="none";

	        }

	        function TabSavings(){
		        document.getElementById("savings").style.backgroundColor = '#a7321a';
		        document.getElementById("savings").style.color = '#ede8ea';
		        document.getElementById("divsavings").style.display="";

		        document.getElementById("info").style.backgroundColor = '#f0f0f0';
		        document.getElementById("info").style.color = '#2a2527';
		        document.getElementById("divprofile").style.display="none";

		        document.getElementById("loan").style.backgroundColor = '#f0f0f0';
		        document.getElementById("loan").style.color = '#2a2527';
		        document.getElementById("divloan").style.display="none";

		        document.getElementById("performance").style.backgroundColor = '#f0f0f0';
		        document.getElementById("performance").style.color = '#2a2527';
		        document.getElementById("divperformance").style.display="none";

	        }

	        function TabPerf(){
		        document.getElementById("performance").style.backgroundColor = '#a7321a';
		        document.getElementById("performance").style.color = '#ede8ea';
		        document.getElementById("divperformance").style.display="";

		        document.getElementById("info").style.backgroundColor = '#f0f0f0';
		        document.getElementById("info").style.color = '#2a2527';
		        document.getElementById("divprofile").style.display="none";

		        document.getElementById("loan").style.backgroundColor = '#f0f0f0';
		        document.getElementById("loan").style.color = '#2a2527';
		        document.getElementById("divloan").style.display="none";

		        document.getElementById("savings").style.backgroundColor = '#f0f0f0';
		        document.getElementById("savings").style.color = '#2a2527';
		        document.getElementById("divsavings").style.display="none";
	        }

	      

function showTransactionLog(){
	document.getElementById("TransactionLog").style.display="";
}

function changeSearch(chosen){
	if (chosen=="location" || chosen=="center" || chosen=="name" || chosen=="year"){
		document.getElementById("normalsearch").style.display="";
		document.getElementById("searchrange").style.display="none";
	}else{
		document.getElementById("normalsearch").style.display="none";
		document.getElementById("searchrange").style.display="";
	}

}


function TabLoanApprov(){
	document.getElementById("loanapp").style.backgroundColor = '#a7321a';
	document.getElementById("loanapp").style.color = '#ede8ea';
	document.getElementById("ApplicationContent").style.display="";
      	
    document.getElementById("loanperf").style.backgroundColor = '#f0f0f0';
	document.getElementById("loanperf").style.color = '#2a2527';
	document.getElementById("MemberPerformance").style.display="none";

}

function TabLoanPerf(){

	document.getElementById("loanperf").style.backgroundColor = '#a7321a';
	document.getElementById("loanperf").style.color = '#ede8ea';
	document.getElementById("MemberPerformance").style.display="";
      	
    document.getElementById("loanapp").style.backgroundColor = '#f0f0f0';
	document.getElementById("loanapp").style.color = '#2a2527';
	document.getElementById("ApplicationContent").style.display="none";

}
