<?
    // Klassendefinition
    class IPS2DMX_UKingMovingHead extends IPSModule 
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
		
		// Profile anlegen
		$this->RegisterProfileInteger("IPS2DMX.MovingHeadColor", "Paintbrush", "", "", 0, 190, 0);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadColor", 0, "Color 1", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadColor", 8, "Color 2", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadColor", 15, "Color 3", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadColor", 22, "Color 4", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadColor", 29, "Color 5", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadColor", 36, "Color 6", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadColor", 43, "Color 7", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadColor", 50, "Color 8", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadColor", 57, "Half Color", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadColor", 128, "Color-Fast-Slow-Stop", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadColor", 190, "Color-Slow-Fast", "Paintbrush", -1);

		$this->RegisterProfileInteger("IPS2DMX.MovingHeadGobo", "Information", "", "", 0, 190, 0);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 0, "Gobo 1", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 8, "Gobo 2", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 16, "Gobo 3", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 24, "Gobo 4", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 32, "Gobo 5", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 40, "Gobo 6", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 48, "Gobo 7", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 56, "Gobo 8", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 64, "Gobo 1 Jitter", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 72, "Gobo 2 Jitter", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 80, "Gobo 3 Jitter", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 88, "Gobo 4 Jitter", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 96, "Gobo 5 Jitter", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 104, "Gobo 6 Jitter", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 112, "Gobo 7 Jitter", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 120, "Gobo 8 Jitter", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 128, "Gobo-Fast-Slow-Stop", "Paintbrush", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadGobo", 190, "Gobo-Slow-Fast", "Paintbrush", -1);

		$this->RegisterProfileInteger("IPS2DMX.MovingHeadDimming", "Intensity", "", "", 0, 240, 0);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadDimming", 0, "On", "Intensity", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadDimming", 8, "Off", "Intensity", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadDimming", 16, "Dimming-Slow-Fast", "Intensity", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadDimming", 140, "Fast On - Slow Off", "Intensity", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadDimming", 190, "Fast Off - Slow On", "Intensity", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadDimming", 240, "Dimming", "Intensity", -1);

		$this->RegisterProfileInteger("IPS2DMX.LightningMode", "Lightning", "", "", 0, 250, 0);
		IPS_SetVariableProfileAssociation("IPS2DMX.LightningMode", 0, "When Pan & Tilt Moving", "Lightning", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.LightningMode", 90, "When Color Moving", "Lightning", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.LightningMode", 110, "When Gobo Moving", "Lightning", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.LightningMode", 210, "Rest", "Lightning", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.LightningMode", 250, "Sound Activated", "Lightning", -1);
		
		$this->RegisterProfileInteger("IPS2DMX.MovingHeadDimmingMode", "Intensity", "", "", 0, 81, 0);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadDimmingMode", 0, "Standard", "Intensity", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadDimmingMode", 21, "Stage", "Intensity", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadDimmingMode", 41, "TV", "Intensity", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadDimmingMode", 61, "Building", "Intensity", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadDimmingMode", 81, "Theatre", "Intensity", -1);
		
		$this->RegisterProfileInteger("IPS2DMX.MovingHeadProgram", "Popcorn", "", "", 0, 6, 0);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadProgram", 0, "Manuelle Steuerung", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadProgram", 1, "Dance", "Repeat", -1);
		

		
		// Status-Variablen anlegen
		// Channel 1 Pan Motion 0 - 100% - Drehbewegung
		$this->RegisterVariableInteger("PanMotion", "Pan Motion", "~Intensity.255", 10);
		$this->EnableAction("PanMotion");
		// Channel 2 Pan Fine Turning Motion
		$this->RegisterVariableInteger("PanFineTurningMotion", "Pan Fine Turning Motion", "~Intensity.255", 20);
		$this->EnableAction("PanFineTurningMotion");
		// Channel 3 Till Motion 0 - 100% - Kippbewegung
		$this->RegisterVariableInteger("TiltMotion", "Tilt Motion", "~Intensity.255", 40);
		$this->EnableAction("TiltMotion");
		// Channel 4 Till Fine Turning Motion
		$this->RegisterVariableInteger("TiltFineTurningMotion", "Tilt Fine Turning Motion", "~Intensity.255", 50);
		$this->EnableAction("TiltFineTurningMotion");
		// Channel 5 Color 1-8 (value 000-056), Half Color (value 057-127), Color fast-slow (value 128-189), Color slow-fast (value 190-255)
		$this->RegisterVariableInteger("Color", "Color", "IPS2DMX.MovingHeadColor", 60);
		$this->EnableAction("Color");
		// Channel 6 Gobo 1-8 (value 000-063), Gobo Shake 1-8 (value 064-127), Gobo fast-slow (value 128-189), Gobo slow-fast (value 190-255)
		$this->RegisterVariableInteger("Gobo", "Gobo", "IPS2DMX.MovingHeadGobo", 70);
		$this->EnableAction("Gobo");
		// Channel 7 Diming ON (value 000-007), Diming OFF (value 008-015), Diming slow-fast (value 016-139), Diming fast-slow (value 140-189), Diming close quickly and open slowly (value 190-239), Diming close slowly and open quickly (value 240-255)
		$this->RegisterVariableInteger("Dimming", "Dimming", "IPS2DMX.MovingHeadDimming", 80);
		$this->EnableAction("Dimming");
		// Channel 8 Lightning ON/OFF (0 - 100%)
		$this->RegisterVariableInteger("Lightning", "Lightning", "~Intensity.255", 90);
		$this->EnableAction("Lightning");
		// Channel 9 Speed (fast-slow / pan & tilt)
		$this->RegisterVariableInteger("PanTiltSpeed", "Pan Tilt Speed", "~Intensity.255", 100);
		$this->EnableAction("PanTiltSpeed");
		// Channel 10 When Pan & Tilt moving lighting ON (value 000-069), when Color moving lightning ON (value 090-109), when Gobo moving lightning ON (value 110-209), Rest (value 210-249), Sound Activated (value 250-255)
		$this->RegisterVariableInteger("LightningMode", "Lightning Mode", "IPS2DMX.LightningMode", 110);
		$this->EnableAction("LightningMode");
		// Channel 11 Standard Dimming mode (value 000-020), Stage dimming mode (value 021-040), TV Dimming mode (value 041-060), Building Dimming mode (value 061-080), Theatre Dimming mode (value 081-255)
		$this->RegisterVariableInteger("DimmingMode", "Dimming Mode", "IPS2DMX.MovingHeadDimmingMode", 120);
		$this->EnableAction("DimmingMode");
		// Programmauswahl
		$this->RegisterVariableInteger("Program", "Program", "IPS2DMX.MovingHeadProgram", 130);
		$this->EnableAction("Program");
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
		$arrayElements[] = array("type" => "Label", "label" => "Dieses Gerät benötigt 11 DMX-Kanäle");
		
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
		
		If ($this->HasActiveParent() == true) {	
			If ($this->ReadPropertyBoolean("Open") == true) {
				If ($this->GetStatus() <> 102) {
					$this->SetStatus(102);
				}
				If ($this->ReadPropertyInteger("TriggerID") > 0) {
					$this->RegisterMessage($this->ReadPropertyInteger("TriggerID"), 10603);
				}
			}
			else {
				If ($this->GetStatus() <> 104) {
					$this->SetStatus(104);
				}
				$this->UnregisterMessage($this->ReadPropertyInteger("TriggerID"), 10603);
			}
		}
	}
	
	public function RequestAction($Ident, $Value) 
	{
		SetValueInteger($this->GetIDForIdent($Ident), $Value);
		
		switch($Ident) {
			case "PanMotion":
				$this->SetChannelValue( 1, $Value);
				break;
			case "PanFineTurningMotion":
				$this->SetChannelValue( 2, $Value);
				break;
			case "TiltMotion":
				$this->SetChannelValue( 3, $Value);
				break;
			case "TiltFineTurningMotion":
				$this->SetChannelValue( 4, $Value);
				break;
			case "Color":
				$this->SetChannelValue( 5, $Value);
				break;
			case "Gobo":
				$this->SetChannelValue( 6, $Value);
				break;
			case "Dimming":
				$this->SetChannelValue( 7, $Value);
				break;
			case "Lightning":
				$this->SetChannelValue( 8, $Value);
				break;
			case "PanTiltSpeed":
				$this->SetChannelValue( 9, $Value);
				break;
			case "LightningMode":
				$this->SetChannelValue( 10, $Value);
				break;
			case "DimmingMode":
				$this->SetChannelValue( 11, $Value);
				break;
			case "Program":
				$this->SetValue($Ident, $Value);
				$this->SetBuffer("StepCounter", 0);
				If ($Value == 0) {
					If ($this->ReadPropertyInteger("TriggerID") > 0) {
						$this->UnregisterMessage($this->ReadPropertyInteger("TriggerID"), 10603);
					}
				}
				else {
					// De-Registrierung für die Änderung der Trigger-Variablen
					If ($this->ReadPropertyInteger("TriggerID") > 0) {
						$this->RegisterMessage($this->ReadPropertyInteger("TriggerID"), 10603);
					}
				}
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
					$Program = $this->GetValue("Program");
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
			$this->SendDebug("SetChannelValue", "Ausfuehrung: Channel - ".$Channel." - Value - ".$Value, 0);
			$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
			$DMXChannel = $DMXStartChannel + ($Channel - 1); 
			$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => $Value, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
		}
	}  
	    
	private function SetProgrammedValue()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetProgrammedValue", "Ausfuehrung", 0);
			$Program = $this->GetValue("Program");
			$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
			
			// Arrayaufbau: Pan, Till, Color, Gobo
			
			switch($Program) {
				case "1":
					// Dance
					$Step[0] = array(rand(0, 255), rand(0, 255), rand(0, 190), rand(0, 190));
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
}
?>
