<?
    // Klassendefinition
    class IPS2DMX_6ChDimmer extends IPSModule 
    {
	 // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() 
        {
            	// Diese Zeile nicht löschen.
            	parent::Create();
 	    	$this->RegisterPropertyBoolean("Open", false);
		$this->ConnectParent("{B1E43BF6-770A-4FD7-B4FE-6D265F93746B}");
 	    	$this->RegisterPropertyInteger("DMXStartChannel", 1);
		$this->RegisterPropertyInteger("TriggerID", 0);
        }
 	
	public function GetConfigurationForm() 
	{ 
		$arrayStatus = array(); 
		$arrayStatus[] = array("code" => 101, "icon" => "inactive", "caption" => "Instanz wird erstellt"); 
		$arrayStatus[] = array("code" => 102, "icon" => "active", "caption" => "Instanz ist aktiv");
		$arrayStatus[] = array("code" => 104, "icon" => "inactive", "caption" => "Instanz ist inaktiv");
				
		$arrayElements = array(); 
		$arrayElements[] = array("name" => "Open", "type" => "CheckBox",  "caption" => "Aktiv"); 
 		$arrayElements[] = array("type" => "NumberSpinner", "name" => "DMXStartChannel",  "caption" => "DMX-Start-Kanal");
		$arrayElements[] = array("type" => "Label", "label" => "_____________________________________________________________________________________________________");
		$arrayElements[] = array("type" => "Label", "label" => "Trigger-Variable");
		$arrayElements[] = array("type" => "SelectVariable", "name" => "TriggerID", "caption" => "Trigger"); 

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
		
		for ($i = 0; $i <= 5; $i++) {
			/*
			$this->RegisterVariableBoolean("Status_".($i + 1), "Status ".($i + 1), "~Switch", 10 + ($i * 20));
			$this->EnableAction("Status_".($i + 1));
			IPS_SetHidden($this->GetIDForIdent("Status_".($i + 1)), false);
			*/
			
			$this->RegisterVariableInteger("Intensity_".($i + 1), "Intensity ".($i + 1), "~Intensity.255", 20 + ($i * 20) );
			$this->EnableAction("Intensity_".($i + 1));
			IPS_SetHidden($this->GetIDForIdent("Intensity_".($i + 1)), false);
		}
		$this->RegisterVariableInteger("IntensityMaster_0", "Intensity Master", "~Intensity.255", 130);
		$this->EnableAction("IntensityMaster_0");
		IPS_SetHidden($this->GetIDForIdent("IntensityMaster_0"), false);
		
		// Registrierung für die Änderung der Trigger-Variablen
		If ($this->ReadPropertyInteger("TriggerID") > 0) {
			$this->RegisterMessage($this->ReadPropertyInteger("TriggerID"), 10603);
		}
		
		If ((IPS_GetKernelRunlevel() == 10103) AND ($this->HasActiveParent() == true)) {	
		
			If ($this->ReadPropertyBoolean("Open") == true) {
				$this->SetStatus(102);
			}
			else {
				$this->SetStatus(104);
			}
		}
	}
	
	public function RequestAction($Ident, $Value) 
	{
		$Parts = explode("_", $Ident);
		$Source = $Parts[0]; // Steuerelement
		$Channel = intval($Parts[1]); 
		
		switch($Source) {
		case "Status":
			//$this->SetChannelStatus($Value);
			break;
		case "Intensity":
			$this->SetChannelValue($Channel, $Value);
			break;
		case "IntensityMaster":
			SetValueInteger($this->GetIDForIdent("IntensityMaster_0"), $Value);
			//$this->SetChannelStatus($Value);
			break;
		default:
		    throw new Exception("Invalid Ident");
		}
	}
	
	public function MessageSink($TimeStamp, $SenderID, $Message, $Data)
    	{
 		switch ($Message) {
			case 10603:
				// Änderung der Trigger-Variablen
				If ($SenderID == $this->ReadPropertyInteger("TriggerID")) {
					$this->SendDebug("MessageSink", "Trigger-Daten: ".$Data, 0);
				}
				break;
		}
    	}    
	    
	    
	// Beginn der Funktionen
	private function SetChannelValue(Int $Channel, Int $Value)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetChannelValue", "Ausfuehrung", 0);
			$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
			$IntensityMaster = GetValueInteger($this->GetIDForIdent("IntensityMaster_0"));
			$DMXChannel = $DMXStartChannel + $Channel - 1;
			$Value = min($IntensityMaster, $Value);
			$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => $Value, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
			SetValueInteger($this->GetIDForIdent("Intensity_".$Channel), $Value);
		}
	} 
	
	/*
	private function SetChannelStatus(Int $Channel, Bool $Status)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetChannelStatus", "Ausfuehrung", 0);
			$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
			
			If ($Status == true) {
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXStartChannel, "Value" => 255, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
			}
			else {
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXStartChannel, "Value" => 0, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
			}
			SetValueBoolean($this->GetIDForIdent("Status"), $Status);
		}
	} 
	*/
	
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
