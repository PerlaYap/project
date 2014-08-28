<?php date_default_timezone_set('Asia/Manila');
	

 ?>
<div class="content">
	<br><br>

	<form action="" method="post" class="basic-grey">

		<h1> 
			<br>Edit Collection 
			<span><br></span>
		</h1>
		
		<br>

		<label>
			<span>Transaction No. :</span>
			<?php if (empty($_GET['name'])) { ?>
				<input type="number" style="width: 100px" name="transcontrolno" min='0' required>	
			<?php }else{ ?>
				<input type="number" style="width: 100px" name="transcontrolno" min='0' value='<?php echo $_GET['name'] ?>' readOnly>	
			<?php } ?>
		 	
		</label>

		<br><br>
		
	</form>
	

	<?php if (!empty($_POST)) { ?>

	<?php $transaction_no = $_POST['transcontrolno']; 

		$tran_type = $this->db->query("SELECT * FROM `transactiontype`;");

		$query = $this->db->query("SELECT t.`ControlNo` as transactionno, t.`Amount`, t.`Members_ControlNo`,t.`TransactionType`, concat(n.Firstname,' ',n.MiddleName,' ',n.LastName)as Name, t.datetime FROM `transaction` t join membersname n on t.Members_controlNo = n.ControlNo WHERE t.`ControlNo` = $transaction_no");
		$query_result = $query->result();
		foreach ($query_result as $q) {
			$name = $q->Name;
			$amount = $q->Amount;
			$t_type = $q->TransactionType;
			$t_no = $q->transactionno;
			$date = $q->datetime;
			$memberno = $q->Members_ControlNo;
			$tranno = $q->transactionno;
		}
	?>

	<br>
	<?php if (!empty($query_result)) { ?>
		
	<form action="edittransaction" method="post" class="basic-grey">
		<input type='hidden' value='<?php echo $tranno; ?>' name='transactionno'>
		<!-- <input type='hidden' value='<?php // echo $memberno; ?>' name='memberid'> -->
		<!-- <input type='hidden' value='' name=''> -->
	
		<label>
			<span>Name:</span>
			<input type="text" disabled value="<?php echo $name; ?>"/>
		</label>

		<label>
			<span>Date:</span>
			<input type="text" disabled value="<?php echo $date; ?>"/>
		</label>

		<label>
			<span>Amount:</span>
			<input type="text" name='amounttochange' value="<?php echo $amount; ?>"/>
		</label>

		<label>
			<span>Transaction Type: </span>
			<select name="transacttype">
			<?php foreach ($tran_type->result() as $type) { $tt = $type->TransactionType; 

				if ($t_type == $tt) { ?>
				<option value="<?php echo $tt ?>" selected><?php echo $tt ?></option>	
				<?php } else { ?>
				<option value="<?php echo $tt ?>"><?php echo $tt ?></option>	
				<?php } ?>	

			<?php } ?>
			</select>
		</label>

		<br><br>
		<label>
			<span></span>
			<input type="submit" class="button" value="Submit" />
		</label
	</form>
	<?php } else{ ?>
		<script type="text/javascript">
			window.alert("No transaction found! Please try again.")
		</script>
	<?php } ?>
	<?php } ?>

</div>