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
		$arrayElements[] = array("type" => "Label", "label" => "Dieses Gerät benötigt 6 DMX-Kanäle");
		$arrayElements[] = array("type" => "Label", "label" => "_____________________________________________________________________________________________________");
		$arrayElements[] = array("type" => "Label", "label" => "Trigger-Variable");
		$arrayElements[] = array("type" => "SelectVariable", "name" => "TriggerID", "caption" => "Trigger"); 

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
		$this->RegisterProfileInteger("IPS2DMX.ProgramDimmer", "Popcorn", "", "", 0, 6, 0);
		IPS_SetVariableProfileAssociation("IPS2DMX.ProgramDimmer", 0, "Manuelle Steuerung", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.ProgramDimmer", 1, "Wechselblinker", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.ProgramDimmer", 2, "Einfaches Lauflicht", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.ProgramDimmer", 3, "Knight Rider", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.ProgramDimmer", 4, "Doppeltes Lauflicht", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.ProgramDimmer", 5, "Flash", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.ProgramDimmer", 6, "Random", "Repeat", -1);
		
		$this->RegisterProfileFloat("IPS2DMX.FadeTime", "Popcorn", "", " s", 0.0, 3.0, 0.25, 2);
		
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
		
		$this->RegisterVariableInteger("Program_0", "Programm", "IPS2DMX.ProgramDimmer", 140);
		$this->EnableAction("Program_0");
		IPS_SetHidden($this->GetIDForIdent("Program_0"), false);
		
		$this->RegisterVariableFloat("FadeTime_0", "FadeTime", "IPS2DMX.FadeTime", 150);
		$this->EnableAction("FadeTime_0");
		IPS_SetHidden($this->GetIDForIdent("FadeTime_0"), false);
		
		
		
		If ($this->HasActiveParent() == true) {	
			If ($this->ReadPropertyBoolean("Open") == true) {
				If ($this->GetStatus() <> 102) {
					$this->SetStatus(102);
				}
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
			$this->SetValue($Ident, $Value);
			$this->SetMasterValue($Value);
			break;
		case "Program":
			SetValueInteger($this->GetIDForIdent($Ident), $Value);
			$this->SetBuffer("StepCounter", 0);
			If ($Value == 0) {
				for ($i = 0; $i <= 5; $i++) {
					$this->EnableAction("Intensity_".($i + 1));
				}
				If ($this->ReadPropertyInteger("TriggerID") > 0) {
					$this->UnregisterMessage($this->ReadPropertyInteger("TriggerID"), 10603);
				}
			}
			else {
				for ($i = 0; $i <= 5; $i++) {
					$this->DisableAction("Intensity_".($i + 1));
				}
				// De-Registrierung für die Änderung der Trigger-Variablen
				If ($this->ReadPropertyInteger("TriggerID") > 0) {
					$this->RegisterMessage($this->ReadPropertyInteger("TriggerID"), 10603);
				}
			}
			break;
		case "FadeTime":
			SetValueFloat($this->GetIDForIdent($Ident), $Value);
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
					$Program = GetValueInteger($this->GetIDForIdent("Program_0"));
					//$this->SendDebug("MessageSink", "Ausfuehrung - Wert: ".$Data[0]." Programm: ".$Program, 0);
					If (($Data[0] == 1) AND ($Program > 0)) {
						$this->SetProgrammedValue();
					}
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
			$IntensityMaster = $this->GetValue("IntensityMaster_0");
			$DMXChannel = $DMXStartChannel + $Channel - 1;
			$this->SetValue("Intensity_".$Channel, $Value);
			$Value = min($IntensityMaster, $Value);
			$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => $Value, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
		}
	} 
	    
	private function SetMasterValue(Int $NewValue)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetMasterValue", "Ausfuehrung", 0);
			$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
			
			for ($i = 0; $i <= 5; $i++) {
				$DMXChannel = $DMXStartChannel + $i;
				$Value = min($NewValue, $this->GetValue("Intensity_".($i + 1)));
				$this->SendDebug("SetMasterValue", "Neuer Wert: ".$NewValue." Channel: ".$i." Alter Wert: ".$this->GetValue("Intensity_".($i + 1)), 0);
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => $Value, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
			}
		}
	} 
	
	private function SetProgrammedValue()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetProgrammedValue", "Ausfuehrung", 0);
			$Program = $this->GetValue("Program_0");
			$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
			$IntensityMaster = $this->GetValue("IntensityMaster_0");
			$FadeTime = $this->GetValue("FadeTime_0");
			
			switch($Program) {
				case "1":
					// Wechselblinker
					$Step[0] = array(255, 0, 255, 0, 255, 0);
					$Step[1] = array(0, 255, 0, 255, 0, 255);
					break;
				case "2":
					// Einfaches Lauflicht
					$Step[0] = array(255, 0, 0, 0, 0, 0);
					$Step[1] = array(0, 255, 0, 0, 0, 0);
					$Step[2] = array(0, 0, 255, 0, 0, 0);
					$Step[3] = array(0, 0, 0, 255, 0, 0);
					$Step[4] = array(0, 0, 0, 0, 255, 0);
					$Step[5] = array(0, 0, 0, 0, 0, 255);
					break;
				case "3":
					// Knght Rider
					$Step[0] = array(255, 0, 0, 0, 0, 0);
					$Step[1] = array(0, 255, 0, 0, 0, 0);
					$Step[2] = array(0, 0, 255, 0, 0, 0);
					$Step[3] = array(0, 0, 0, 255, 0, 0);
					$Step[4] = array(0, 0, 0, 0, 255, 0);
					$Step[5] = array(0, 0, 0, 0, 0, 255);
					$Step[6] = array(0, 0, 0, 0, 255, 0);
					$Step[7] = array(0, 0, 0, 255, 0, 0);
					$Step[8] = array(0, 0, 255, 0, 0, 0);
					$Step[9] = array(0, 255, 0, 0, 0, 0);
					break;
				case "4":
					// Doppel-Laulicht
					$Step[0] = array(255, 0, 0, 0, 0, 255);
					$Step[1] = array(0, 255, 0, 0, 255, 0);
					$Step[2] = array(0, 0, 255, 255, 0, 0);
					$Step[3] = array(0, 255, 0, 0, 255, 0);
					break;
				case "5":
					// Flash
					$Step[0] = array(255, 255, 255, 255, 255, 255);
					$Step[1] = array(0, 0, 0, 0, 0, 0);
					break;
				case "6":
					// Random
					$Step[0] = array(rand(0, $IntensityMaster), rand(0, $IntensityMaster), rand(0, $IntensityMaster), rand(0, $IntensityMaster), rand(0, $IntensityMaster), rand(0, $IntensityMaster));
					break;
			}
			
			// Datenausgabe
			$Steps = count($Step);
			$StepCounter = intval($this->GetBuffer("StepCounter"));
			If ($StepCounter >= $Steps) {
				$StepCounter = 0;
			}
			$this->SendDebug("SetProgrammedValue", "Steps: ".$Steps." Zaehler: ".$StepCounter, 0);
			for ($i = 0; $i <= 5; $i++) {
				$DMXChannel = $DMXStartChannel + $i;
				$this->SetValue("Intensity_".($i + 1), $Value);
				$Value = min($IntensityMaster, $Step[$StepCounter][$i]);
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => $Value, "FadingSeconds" => $FadeTime, "DelayedSeconds" => 0.0 )));
			}
			$this->SetBuffer("StepCounter", $StepCounter + 1);
			
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
}
?>
