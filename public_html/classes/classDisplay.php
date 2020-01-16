<?php

/**
 * classDisplay<br>
 * display methods and properties<br>
 *
 * @author rory
 */
class classDisplay {

	protected $PrettyHeaders;
	
	public function __construct() {
	}
	
	public function setPrettyHeaders($Array) {
		$this->PrettyHeaders = $Array;
	}

	public function tableHeader($ArrayData) {
		$a = key($ArrayData);
		$Headers = array_keys($ArrayData[$a]);
		$TableHeader = "<table class='table table-hover table-responsive text-small'><thead><tr class='filters'>";
		foreach ($Headers as $Key => $Field) {
			if (strpos(strtolower($Field), "id") == '' && strpos(strtolower($Field), "id") !== 0) {
				$TableHeader .= "<th><input type='text' class='form-control' placeholder='";
				if (array_key_exists($Field, $this->PrettyHeaders)) {
					$TableHeader .= $this->PrettyHeaders[$Field];
				}
				else {
					$TableHeader .= $Field;
				}
				$TableHeader .= "' disabled></th>";
			}
		}
		$TableHeader .= "</tr></thead>";
		echo $TableHeader;
	}
	
	public function tableBody($ArrayData, $sender) {
//		print_r($ArrayData);
		$TableBody = "<tbody>";
		foreach ($ArrayData as $Key => $record) {
			$TableBody .= "<tr type='button' onclick=\"showModal(" . $record['Id'] . ", '$sender')\" data-toggle='modal' data-target='#modalDiv'>";
			foreach ($record as $Field => $Value) {
//				if  (($Field !== 'LearnerId') && ($Field !== 'CompanyId')) {
				if (strpos(strtolower($Field), "id") == '' && strpos(strtolower($Field), "id") !== 0) {
					if ($Field === 'Hash') {
						if (!is_null($Value)) {
							$TableBody .= "<td>Generate New</td>";
						}
						else {
							$TableBody .= "<td>-</td>";
						}
					}
					else {
						$TableBody .= "<td>$Value</td>";
					}
				}
			}
			$TableBody .= "</tr>";
		}
		$TableBody .= "</tbody></table>";
		echo $TableBody;
	}

	public function selectOptions($OptionArray, $type) {
		/**
		 *	$type if numeric - set selected to id = $type
		 *  $type 'All' - show all options
		 *	$type 'learnerNewCourse' - only show courses NOT on learner file yet
		 */
		$options = '<option value="zzzz">===== Select =====</option>';
		foreach ($OptionArray as $Key => $Value) {
			if (is_numeric($type) && ($type == $Key)) {
				$selected = 'selected';
			}
			else {
				$selected = '';
			}

			$options .= "<option value='$Key' $selected>" . $Value['Desc'] . "</option>";
		}
		echo $options;
	}
	
}

?>
