<?
    // Klassendefinition
    class IPS2DMX_UKingMovingHeadSequenzer extends IPSModule 
    {
	// Überschreibt die interne IPS_Create($id) Funktion
        public function Create() 
        {
            	// Diese Zeile nicht löschen.
            	parent::Create();
 	    	$this->RegisterPropertyBoolean("Open", false);
		$this->ConnectParent("{B1E43BF6-770A-4FD7-B4FE-6D265F93746B}");
		$this->RegisterPropertyInteger("UKingMovingHeadInstanceID_1", 0);
		$this->RegisterPropertyBoolean("UKingMovingHeadActive_1", false);
		$this->RegisterPropertyInteger("UKingMovingHeadInstanceID_2", 0);
		$this->RegisterPropertyBoolean("UKingMovingHeadActive_2", false);
		$this->RegisterPropertyInteger("UKingMovingHeadInstanceID_3", 0);
		$this->RegisterPropertyBoolean("UKingMovingHeadActive_3", false);
		$this->RegisterPropertyInteger("UKingMovingHeadInstanceID_4", 0);
		$this->RegisterPropertyBoolean("UKingMovingHeadActive_4", false);
        }
 	
	public function GetConfigurationForm() 
	{ 
		$arrayStatus = array(); 
		$arrayStatus[] = array("code" => 101, "icon" => "inactive", "caption" => "Instanz wird erstellt"); 
		$arrayStatus[] = array("code" => 102, "icon" => "active", "caption" => "Instanz ist aktiv");
		$arrayStatus[] = array("code" => 104, "icon" => "inactive", "caption" => "Instanz ist inaktiv");
				
		$arrayElements = array(); 
		$arrayElements[] = array("name" => "Open", "type" => "CheckBox",  "caption" => "Aktiv"); 

		$ArrayRowLayout = array();
		$ArrayRowLayout[] = array("name" => "UKingMovingHeadActive_1", "type" => "CheckBox",  "caption" => "Aktiv"); 
		$ArrayRowLayout[] = array("type": "SelectInstance", "name": "UKingMovingHeadInstanceID_1", "caption": "UKing Moving Head 1" }
		$arrayElements[] = array("type" => "RowLayout", "items" => $ArrayRowLayout);

		$ArrayRowLayout = array();
		$ArrayRowLayout[] = array("name" => "UKingMovingHeadActive_2", "type" => "CheckBox",  "caption" => "Aktiv"); 
		$ArrayRowLayout[] = array("type": "SelectInstance", "name": "UKingMovingHeadInstanceID_2", "caption": "UKing Moving Head 2" }
		$arrayElements[] = array("type" => "RowLayout", "items" => $ArrayRowLayout);

		$ArrayRowLayout = array();
		$ArrayRowLayout[] = array("name" => "UKingMovingHeadActive_3", "type" => "CheckBox",  "caption" => "Aktiv"); 
		$ArrayRowLayout[] = array("type": "SelectInstance", "name": "UKingMovingHeadInstanceID_3", "caption": "UKing Moving Head 3" }
		$arrayElements[] = array("type" => "RowLayout", "items" => $ArrayRowLayout);

		$ArrayRowLayout = array();
		$ArrayRowLayout[] = array("name" => "UKingMovingHeadActive_4", "type" => "CheckBox",  "caption" => "Aktiv"); 
		$ArrayRowLayout[] = array("type": "SelectInstance", "name": "UKingMovingHeadInstanceID_4", "caption": "UKing Moving Head 4" }
		$arrayElements[] = array("type" => "RowLayout", "items" => $ArrayRowLayout);

		
		$arrayActions = array();
		$arrayActions[] = array("type" => "Label", "label" => "Test Center"); 
		$arrayActions[] = array("type" => "TestCenter", "name" => "TestCenter");
		
 		return JSON_encode(array("status" => $arrayStatus, "elements" => $arrayElements, "actions" => $arrayActions)); 		 
 	}       
	   
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() 
        {
            	// Diese Zeile nicht löschen
            	parent::ApplyChanges();
		
		// Profil anlegen
		
		
		
		
		
		
		If ($this->HasActiveParent() == true) {	
			If ($this->ReadPropertyBoolean("Open") == true) {
				If ($this->GetStatus() <> 102) {
					$this->SetStatus(102);
				}
				$Status = $this->GetValue("Status");
				
			}
			else {
				
				If ($this->GetStatus() <> 104) {
					$this->SetStatus(104);
				}
			}
		}
	}
	
	public function RequestAction($Ident, $Value) 
	{
		switch($Ident) {
		
		default:
		    throw new Exception("Invalid Ident");
		}
	}
	    
	// Beginn der Funktionen
	
	
	
	
	
	
	    
	private function RegisterProfileInteger($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $StepSize)
	{
	        if (!IPS_VariableProfileExists($Name))
	        {
	            IPS_CreateVariableProfile($Name, 1);
	        }
	        else
	        {
	            $profile = IPS_GetVariableProfile($Name);
	            if ($profile['ProfileType'] != 1)
	                throw new Exception("Variable profile type does not match for profile " . $Name);
	        }
	        IPS_SetVariableProfileIcon($Name, $Icon);
	        IPS_SetVariableProfileText($Name, $Prefix, $Suffix);
	        IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize);    
	}
	    
	private function RegisterProfileFloat($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $StepSize, $Digits)
	{
	        if (!IPS_VariableProfileExists($Name))
	        {
	            IPS_CreateVariableProfile($Name, 2);
	        }
	        else
	        {
	            $profile = IPS_GetVariableProfile($Name);
	            if ($profile['ProfileType'] != 2)
	                throw new Exception("Variable profile type does not match for profile " . $Name);
	        }
	        IPS_SetVariableProfileIcon($Name, $Icon);
	        IPS_SetVariableProfileText($Name, $Prefix, $Suffix);
	        IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize);
	        IPS_SetVariableProfileDigits($Name, $Digits);
	}
	    
	private function GetParentID()
	{
		$ParentID = (IPS_GetInstance($this->InstanceID)['ConnectionID']);  
	return $ParentID;
	}
}
?>
