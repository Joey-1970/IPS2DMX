<?
    // Klassendefinition
    class IPS2DMX_ProgramTrigger extends IPSModule 
    {
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
		
		$this->RegisterVariableBoolean("Status", "Status", "~Switch", 20);
		
		$this->RegisterVariableFloat("TriggerTime", "Trigger", "IPS2DMX.TriggerTime", 30);
		
		$this->RegisterVariableBoolean("BlackOut", "BlackOut", "~Switch", 40);
		
		$this->RegisterVariableInteger("AutoReset", "Auto Reset", "IPS2DMX.PTBlackOut", 50);
		
		If ($this->HasActiveParent() == true) {	
			If ($this->ReadPropertyBoolean("Open") == true) {
				If ($this->GetStatus() <> 102) {
					$this->SetStatus(102);
				}
				$Status = $this->GetValue("Status");
				$TriggerTime = $this->GetValue("TriggerTime");
				If ($Status == true) {
					$this->SetTimerInterval("Timer_1", ($TriggerTime * 1000));
				}
			}
			else {
				$this->SetTimerInterval("Timer_1", 0);
				$this->SetTimerInterval("Timer_2", 0);
				If ($this->GetStatus() <> 104) {
					$this->SetStatus(104);
				}
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
			$this->SetValue("Trigger", true);
			$this->SetValue("Trigger", false);
		}
	} 
	
	private function SetTriggerStatus(Bool $Value)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			If ($Value == true) {
				$Timer_1 = $this->GetValue("TriggerTime");
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
			$Status = $this->GetValue("Status");
			If ($Status == true) {
				$this->SetTimerInterval("Timer_1", ($Value * 1000));
			}
		}
	} 
	
	public function SetBlackOutStatus(Bool $Status)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetBlackOutStatus", "Ausfuehrung", 0);
			$AutoReset = 2 * $this->GetValue("AutoReset");
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
				$this->SetValue("BlackOut", $Status);
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
}
?>
