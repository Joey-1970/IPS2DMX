<?
    // Klassendefinition
    class IPS2DMX_ProgramTrigger extends IPSModule 
    {
	public function Destroy() 
	{
		//Never delete this line!
		parent::Destroy();
		$this->SetTimerInterval("Timer_1", 0);
		$this->SetTimerInterval("Timer_2", 0);
	}
	    
	// Überschreibt die interne IPS_Create($id) Funktion
        public function Create() 
        {
            	// Diese Zeile nicht löschen.
            	parent::Create();
 	    	$this->RegisterPropertyBoolean("Open", false);
		$this->ConnectParent("{B1E43BF6-770A-4FD7-B4FE-6D265F93746B}");
		$this->RegisterTimer("Timer_1", 0, 'I2DPT_SetTrigger($_IPS["TARGET"]);');
		$this->RegisterTimer("Timer_2", 0, 'I2DPT_SetBlackOutStatus($_IPS["TARGET"], false);');
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
		
		$arrayActions = array();
		$arrayActions[] = array("type" => "Label", "label" => "Diese Funktionen stehen erst nach Eingabe und Übernahme der erforderlichen Daten zur Verfügung!");
		
 		return JSON_encode(array("status" => $arrayStatus, "elements" => $arrayElements, "actions" => $arrayActions)); 		 
 	}       
	   
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() 
        {
            	// Diese Zeile nicht löschen
            	parent::ApplyChanges();
		
		// Profil anlegen
		$this->RegisterProfileInteger("IPS2DMX.PTBlackOut", "Clock", "", "", 0, 6, 1);
		IPS_SetVariableProfileAssociation("IPS2DMX.PTBlackOut", 0, "Aus", "Clock", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.PTBlackOut", 1, "2 sek", "Clock", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.PTBlackOut", 2, "4 sek", "Clock", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.PTBlackOut", 3, "6 sek", "Clock", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.PTBlackOut", 4, "8 sek", "Clock", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.PTBlackOut", 5, "10 sek", "Clock", -1);
		
		
		$this->RegisterProfileFloat("IPS2DMX.TriggerTime", "Popcorn", "", " s", 0.5, 5.0, 0.25, 2);
		
		
		
		$this->RegisterVariableBoolean("Trigger", "Trigger", "~Switch", 10);
		$this->DisableAction("Trigger");
		IPS_SetHidden($this->GetIDForIdent("Trigger"), false);
		
		$this->RegisterVariableBoolean("Status", "Status", "~Switch", 20);
		$this->EnableAction("Status");
		IPS_SetHidden($this->GetIDForIdent("Status"), false);
		
		$this->RegisterVariableFloat("TriggerTime", "Trigger", "IPS2DMX.TriggerTime", 30);
		$this->EnableAction("TriggerTime");
		IPS_SetHidden($this->GetIDForIdent("TriggerTime"), false);
		
		$this->RegisterVariableBoolean("BlackOut", "BlackOut", "~Switch", 40);
		$this->EnableAction("BlackOut");
		IPS_SetHidden($this->GetIDForIdent("BlackOut"), false);
		
		$this->RegisterVariableInteger("AutoReset", "Auto Reset", "IPS2DMX.PTBlackOut", 50);
		$this->EnableAction("AutoReset");
		IPS_SetHidden($this->GetIDForIdent("AutoReset"), false);
		
		If ((IPS_GetKernelRunlevel() == 10103) AND ($this->HasActiveParent() == true)) {	
		
			If ($this->ReadPropertyBoolean("Open") == true) {
				$this->SetStatus(102);
			}
			else {
				$this->SetTimerInterval("Timer_1", 0);
				$this->SetTimerInterval("Timer_2", 0);
				$this->SetStatus(104);
			}
		}
	}
	
	public function RequestAction($Ident, $Value) 
	{
		switch($Ident) {
		case "Status":
			SetValueBoolean($this->GetIDForIdent($Ident), $Value);
			$this->SetTriggerStatus($Value);
			break;
		case "TriggerTime":
			SetValueFloat($this->GetIDForIdent($Ident), $Value);
			$this->SetTriggerTime($Value);
			break;
		case "BlackOut":
			SetValueBoolean($this->GetIDForIdent($Ident), $Value);
			$this->SetBlackOutStatus($Value);
			break;
		case "AutoReset":
			SetValueInteger($this->GetIDForIdent("AutoReset"), $Value);
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
	
	private function SetTriggerStatus(Bool $Value)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			If ($Value == true) {
				$Timer_1 = GetValueFloat($this->GetIDForIdent("TriggerTime"));
				$this->SetTimerInterval("Timer_1", ($Timer_1 * 1000));
			}
			else {
				$this->SetTimerInterval("Timer_1", 0);
			}
		}
	} 
	
	private function SetTriggerTime(Float $Value)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$Status = GetValueBoolean($this->GetIDForIdent("Status"));
			If ($Status == true) {
				$this->SetTimerInterval("Timer_1", ($Value * 1000));
			}
		}
	} 
	
	public function SetBlackOutStatus(Bool $Status)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetBlackOutStatus", "Ausfuehrung", 0);
			$AutoReset = 2 * GetValueInteger($this->GetIDForIdent("AutoReset"));
			$ParentID = $this->GetParentID();
			
			If ($Status == true) {
				DMX_SetBlackOut($ParentID, $Status);
				If ($AutoReset > 0) {
					$this->SetTimerInterval("Timer_2", ($AutoReset * 1000));
				}	
			}
			else {
				DMX_SetBlackOut($ParentID, $Status);
				$this->SetTimerInterval("Timer_2", 0);
				SetValueBoolean($this->GetIDForIdent("BlackOut"), $Status);
			}
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
