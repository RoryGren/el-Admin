<?php

/**
 *	Read only user for db;<br>
 *	Checks login validity and sets relevant session variables;<br>
 * 
 * @author rory
 */
class classLogin extends MYSQLi {

	protected $UserHashMatch;
	protected $UserNameMatch;
	protected $UserName;
	protected $iiUserId;
	protected $isValidUser;
	protected $Message;
	protected $Today;

	public function __construct($UserName, $userPassword) {
		$this->Today = gmdate("Y-m-d H:i:s", strtotime(" + 2 hours"));
		include INC;
		$this->connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
		if ($this->checkExists('iiUser', $UserName)) {
			$this->UserNameMatch = TRUE;
// ==> TODO > classLogin ==> User Login ==> Check valid password
// ================= Development only.... ======================================
			$this->UserHashMatch = TRUE;
			
		}
		elseif (($UserName === 'RoryGren') && ($userPassword === '620325')) {
			$this->UserNameMatch = TRUE;
			$this->UserHashMatch = TRUE;
		}
// =============================================================================
		else {
			$this->isValidUser   = FALSE;
			$this->UserHashMatch = FALSE;
		}

	}

	private function safeString($UserName) {
		if (strpos($UserName, ";") > 0) {
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
	
	public function userExists() {
/*	
 *	Check for valid login Using pre-populated userName and userHashMatch
 *	comparing to those received on construct()
 *	TODO =====> Check validity between CreateDate and ExpiryDate
 *	TODO =====> Generate hashed 'token' for 'logged in' wrapper - changes each login
 */	
		if ($this->UserNameMatch && $this->UserHashMatch) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	private function checkUserExists($UserName, $userPassword) {
		if ($this->checkExists('User', $UserName)) {
			
			
//			$this->UserName      = TRUE;
//			$this->UserHashMatch = TRUE;
		}
	}
	
	private function checkUserHash() {
		
	}

	private function execSQL($SQL, $Task) {
		echo "classLogin<br>";
		echo "INC: " . INC . "<br>";
		$ResultSet = '';
//		=====> Removed to switch to inherited 2018-01-10 <=====
//		include INC;
//		$conn = new mysqli($DB_HOST, $DB_LOGGER, $DB_LOG_PASS, $DB_NAME);
//		if (mysqli_connect_errno()) {
//			printf("Connect failed: %s\n", mysqli_connect_error());
//		exit();
//		}
//		if ($result=mysqli_query($conn,$SQL)) {
//		=======================================================
		if ($result = $this->query($SQL)) {
			if ($Task === 'S') {
				while ($row = mysqli_fetch_array($result)) {
					$ResultSet[] = $row;
				}
				mysqli_free_result($result);
			}
			elseif ($Task === 'O') {
				while ($obj = mysqli_fetch_object($result)) {
					$ResultSet[] = $obj;
				}
				mysqli_free_result($result);
			}
		}
		else {
			$ResultSet = $conn->errno . " : " . $conn->error;
			if ($conn->errno == 1062) {
				$ResultSet = "Error: The username / email address you have selected is already in use in the database.<br>Please select a different one or request a password reset.";
			}
			if ($conn->errno == 1142) {
				$ResultSet = "Error: You have insufficient privileges on this database.";
			}
		}
		$conn->close();
		return $ResultSet;
	}
	
	private function checkExists($Task, $UserName) {
		if ($Task === 'User') {
			$SQL = "SELECT count(`UserName`) as 'Recs' FROM `LEARNER` WHERE UPPER(`UserName`) = UPPER('$UserName')";
		}
		elseif ($Task === 'iiUser') {
			$SQL = "SELECT count(`iiUserLogin`) as 'Recs' FROM `iiUser` WHERE UPPER(`iiUserLogin`) = UPPER('$UserName')";
		}
		echo $SQL . "<br>";
		$result = $this->query($SQL);
		$Count = mysqli_fetch_assoc($result);
		if ($Count['Recs'] == 0) {
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
}

?>
