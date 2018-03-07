<?
    // Klassendefinition
    class IPS2DMX_ProgramTrigger extends IPSModule 
    {
	public function Destroy() 
	{
		//Never delete this line!
		parent::Destroy();
		$this->SetTimerInterval("Timer_1", 0);
	}
	    
	// Überschreibt die interne IPS_Create($id) Funktion
        public function Create() 
        {
            	// Diese Zeile nicht löschen.
            	parent::Create();
 	    	$this->RegisterPropertyBoolean("Open", false);
		$this->ConnectParent("{B1E43BF6-770A-4FD7-B4FE-6D265F93746B}");
		$this->RegisterPropertyInteger("Timer_1", 1);
		$this->RegisterTimer("Timer_1", 0, 'I2DPT_SetTrigger($_IPS["TARGET"]);');
        }
 	
	public function GetConfigurationForm() 
	{ 
		$arrayStatus = array(); 
		$arrayStatus[] = array("code" => 101, "icon" => "inactive", "caption" => "Instanz wird erstellt"); 
		$arrayStatus[] = array("code" => 102, "icon" => "active", "caption" => "Instanz ist aktiv");
		$arrayStatus[] = array("code" => 104, "icon" => "inactive", "caption" => "Instanz ist inaktiv");
				
		$arrayElements = array(); 
		$arrayElements[] = array("name" => "Open", "type" => "CheckBox",  "caption" => "Aktiv"); 
 		$arrayElements[] = array("type" => "Label", "label" => "_____________________________________________________________________________________________________");
		
		$arrayElements[] = array("type" => "Label", "label" => "_____________________________________________________________________________________________________"); 
		$arrayActions = array();
		$arrayActions[] = array("type" => "Label", "label" => "Diese Funktionen stehen erst nach Eingabe und Übernahme der erforderlichen Daten zur Verfügung!");
		
 		return JSON_encode(array("status" => $arrayStatus, "elements" => $arrayElements, "actions" => $arrayActions)); 		 
 	}       
	   
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() 
        {
            	// Diese Zeile nicht löschen
            	parent::ApplyChanges();
		
		$this->RegisterVariableBoolean("Trigger", "Trigger", "~Switch", 10);
		$this->DisableAction("Trigger");
		IPS_SetHidden($this->GetIDForIdent("Trigger"), false);
		
		$this->RegisterVariableBoolean("Status", "Status", "~Switch", 20);
		$this->EnableAction("Status");
		IPS_SetHidden($this->GetIDForIdent("Status"), false);
		
		
		
		If ((IPS_GetKernelRunlevel() == 10103) AND ($this->HasActiveParent() == true)) {	
		
			If ($this->ReadPropertyBoolean("Open") == true) {
				$Timer_1 = $this->ReadPropertyInteger("Timer_1");
				$this->SetTimerInterval("Timer_1", ($Timer_1 * 1000));
				$this->SetStatus(102);
			}
			else {
				$this->SetTimerInterval("Timer_1", 0);
				$this->SetStatus(104);
			}
		}
	}
	
	public function RequestAction($Ident, $Value) 
	{
		switch($Ident) {
		case "Status":
			//$this->SetChannelStatus($Value);
			break;
		
		default:
		    throw new Exception("Invalid Ident");
		}
	}
	    
	// Beginn der Funktionen
	public function SetTrigger()
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetTrigger", "Ausfuehrung", 0);
			SetValueBoolean($this->GetIDForIdent("Trigger"), true);
			SetValueBoolean($this->GetIDForIdent("Trigger"), false);
		}
	} 
	
	
	    
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
	    
	private function HasActiveParent()
    	{
		$Instance = @IPS_GetInstance($this->InstanceID);
		if ($Instance['ConnectionID'] > 0)
		{
			$Parent = IPS_GetInstance($Instance['ConnectionID']);
			if ($Parent['InstanceStatus'] == 102)
			return true;
		}
        return false;
    	}  
}
?>
