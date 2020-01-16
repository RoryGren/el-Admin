<?php
//include_once 'classes/classLogin.php';

/**
 * Extends classLogin;<br>
 * Learner details after login;<br>
 * Looks at individual learner record details only;<br>
 * Has read, insert and update rights on the database;<br>
 *
 * @author rory
 */
class classLearner extends MYSQLi {

	protected $LastInsertedId;
	protected $UserName;
	protected $Hash;
	protected $Salt;
	protected $FName;
	protected $SName;
	protected $Email;
	protected $IDNumber;
	protected $LearnerDetail; // array
	protected $LearnerCourses; // array
	protected $CompanyId;
	protected $Company;
	protected $CoyList;
	protected $CourseList; // array
	protected $CompanyJSON;
	protected $PrettyHeaderMap; //array
	
	private   $LastLogin; // ===> TODO <===== Retrieve last login for display
	
	protected $ActiveCourse;
	protected  $Today;

	public function __construct() {
		include INC;
		$this->connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
//		parent::__construct('', '');
		$this->Today = gmdate("Y-m-d H:i:s", strtotime(" + 2 hours"));
		$this->fetchCourseList();
		$this->fetchCompanyList();
		$this->prettyHeaderMap();
	}

	public function getPrettyHeaders() {
		
		return $this->PrettyHeaderMap;
	}
	
	public function getUserName() {
		// TODO <===== public function getUserName <=== For displaying on navbar among other things...
		return '####Fred Bloggs####';
	}
	
	public function getLearnerDetail($learnerId) {
		if (is_numeric($learnerId)) {
			$this->fetchLearnerDetail($learnerId);
			return $this->LearnerDetail;
		}
		else {
			return "Invalid Learner";
		}
	}
	
	public function getLearnerCourses() {
		return $this->LearnerCourses;
	}

	protected function fetchLearnerDetail($learnerId) {
		// ===== Learner =====
		$SQL = "SELECT `LearnerId`, `UserName`, `Email`, `FName`, `SName`, `SAIDNo`, `CompanyId`, `LearnerStatus`, `LastLogin`, `CreateUser`, `CreateDate`, `ModUser`, `ModDate` 
				FROM `Learner`
				WHERE `LearnerId` = $learnerId";
		$result = $this->query($SQL);
		$this->LearnerDetail = mysqli_fetch_assoc($result);
		// ===== Learner Courses =====
		$SQL = "SELECT l.`LearnerId`, l.`CourseId`, c.`Description`, l.`RegDate`, l.`StartDate`
				FROM `LearnerCourse` l 
				JOIN `Course` c ON (l.`CourseId` = c.`CourseId`)
				WHERE l.`LearnerId` = $learnerId";
		$result = $this->query($SQL);
		while ($row = mysqli_fetch_assoc($result)) {
			$this->LearnerCourses[$row['CourseId']] = $row;
		}
		mysqli_free_result($result);
	}
	
	public function getCompanyList() {
		return $this->Company;
	}
	
	protected function fetchCompanyList() {
		$SQL = "SELECT `CompanyId` as 'Id', `CompanyDesc` as 'Desc' FROM `Company` ORDER BY `CompanyDesc`";
		$result = $this->query($SQL);
		while ($row = mysqli_fetch_assoc($result)) {
			$this->Company[$row['Id']] = $row;
		}
		mysqli_free_result($result);
	}
	
	public function getCourseList() {
		return $this->CourseList;
	}
	
	protected function fetchCourseList() {
		$SQL = "SELECT `CourseId` as 'Id', `Description` as 'Desc', `Code` FROM `Course`";
		$result = $this->query($SQL);
		while ($row = mysqli_fetch_assoc($result)) {
			$this->CourseList[$row['Id']] = $row;
		}
		mysqli_free_result($result);
	}

	protected function updateLearnerData($UserPwd, $UserId) {
	// SHOULDN'T DO THIS TO THE PASSWORD......
/**		This function generates a random salt<br>
*		adds the salt to the DB<br>
*		encrypts the password and salt<br>
*		updates the user record with the new hash<br>
*/		
		
		$salt = $this->rand_string(60);
		// =====> TODO > SALT <===== set up valid SALT expiry period.
		// =====> TODO > SALT <===== check for existing Salts, change status to '0' and expiry date to now()
		// =====> TODO > SALT <====> Possibly <==> Check for, and prevent, re-using of existing Salts
		$ExpiryDate = gmdate("Y-m-d H:i:s", strtotime(" + 2 years"));
		$UserHash = password_hash($UserPwd . $salt, PASSWORD_DEFAULT);
		$SQL = "UPDATE `Learner` SET `Hash` = '$UserHash' WHERE `LearnerId` = $UserId";
		if ($Updated = $this->execSQL($SQL, 'U')) {
			$SQL = "INSERT `LearnerSalt` (`LearnerId`, `Salt`, `CreateDate`, `ExpiryDate`) VALUES ($UserId, '$salt', '$this->Today', '$ExpiryDate')";
			if ($Done = $this->execSQL($SQL, 'U')) {
				return TRUE;
			}
			else {
				echo $Done . " [Error in UpdateLearnerData:Salt] Please generate a new password for this user.<br>";
				return FALSE;
			}
		}
		else {
			echo $Updated . " [Error in UpdateLearnerData:Hash] Please generate a new password for this user.<br>";
			return FALSE;
		}
	}

	protected function rand_string( $length ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
		$str = '';
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}
		return $str;
	}

	protected function execSQL($SQL, $Task) {
		/**
		 *	@param string $Task 'S' = Select returns array of rows<br>'I' = Insert<br>'U' = Update<br>'O' returns array of resultset objects.
		 */
		$ResultSet = [];
		include INC;
		$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
		}
		if ($result=mysqli_query($conn,$SQL)) {
//			echo "Done: $Task<br>";
			if ($Task === 'S') {
				while ($row = mysqli_fetch_assoc($result)) {
					$ResultSet[] = $row;
				}
				mysqli_free_result($result);
			}
			elseif ($Task === 'B') {
				echo "<br>This needs to change<br>";
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
			elseif ($Task === 'I') {
//				echo "Inserted";
				$this->LastInsertedId = mysqli_insert_id($conn);
				if ($this->LastInsertedId > 0) {
					$ResultSet = TRUE;
				}
//				echo "<br>LastInsertedId: " . $this->LastInsertedId . "<br>";
			}
			elseif ($Task === 'U') {
				$ResultSet = TRUE;
			}
		}
		else {
			$ResultSet = $conn->errno . " : " . $conn->error;
//			print_r($ResultSet);
//			echo "<br>$SQL<br>";
			if ($conn->errno == 1062) {
				$ResultSet = "Error: A Learner with the Email Address / SA Identity Number you have entered already exists in the database.<br>Please select a different one or request a password reset.";
			}
			if ($conn->errno == 1142) {
				$ResultSet = "Error: You have insufficient privileges on this database.";
			}
		}
		$conn->close();
		return $ResultSet;
	}
	
	protected function checkExists($Task, $UserName) {
//		echo "CheckExists: $Task :: $UserName<br>";
		if ($Task === 'User') {
			$SQL = "SELECT count(`UserName`) as 'Recs' FROM `Learner` WHERE UPPER(`UserName`) = UPPER('$UserName')";
		}
//		echo $SQL;
		$Count = $this->execSQL($SQL, 'S');
//		echo "Counted " . $Count[0]['Recs'] . "<br>";
		if ($Count[0]['Recs'] == 0) {
			return FALSE;
		}
		else {
			return TRUE;
		}
	}

	protected function prettyHeaderMap() {
//		echo "Getting Pretty Headers<br>";
		$SQL = "SELECT `Field`, `Desc` FROM `FieldHeaderMap`";
		$result = $this->query($SQL);
		while ($row = mysqli_fetch_assoc($result)) {
			$this->PrettyHeaderMap[$row['Field']] = $row['Desc'];
		}
		mysqli_free_result($result);
//		echo "<br>Header Map<br>";
//		print_r($this->PrettyHeaderMap);
//		echo "<br>";
	}
}

?>
