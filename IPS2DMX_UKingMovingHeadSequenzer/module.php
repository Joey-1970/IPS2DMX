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
		$this->RegisterPropertyInteger("TriggerID", 0);
		$this->RegisterPropertyInteger("UKingMovingHeadInstanceID_1", 0);
		$this->RegisterPropertyBoolean("UKingMovingHeadActive_1", false);
		$this->RegisterPropertyInteger("UKingMovingHeadInstanceID_2", 0);
		$this->RegisterPropertyBoolean("UKingMovingHeadActive_2", false);
		$this->RegisterPropertyInteger("UKingMovingHeadInstanceID_3", 0);
		$this->RegisterPropertyBoolean("UKingMovingHeadActive_3", false);
		$this->RegisterPropertyInteger("UKingMovingHeadInstanceID_4", 0);
		$this->RegisterPropertyBoolean("UKingMovingHeadActive_4", false);

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

		$this->RegisterProfileInteger("IPS2DMX.MovingHeadSequenzerProgram", "Popcorn", "", "", 0, 6, 0);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadSequenzerProgram", 0, "Manuelle Steuerung", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadSequenzerProgram", 1, "Bewegung und Farbe synchronisieren", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadSequenzerProgram", 2, "Bewegung synchronisieren, Farbe individuell", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadSequenzerProgram", 3, "Bewegung individuell, Farbe synchronisieren", "Repeat", -1);
		
		// Status-Variablen anlegen
		$this->RegisterVariableInteger("Program", "Program", "IPS2DMX.MovingHeadSequenzerProgram", 10);
		$this->EnableAction("Program");
		// Channel 1 Pan Motion 0 - 100% - Drehbewegung
		$this->RegisterVariableInteger("PanMotion", "Pan Motion", "~Intensity.255", 10);
		$this->EnableAction("PanMotion");
		// Channel 3 Tilt Motion 0 - 100% - Kippbewegung
		$this->RegisterVariableInteger("TiltMotion", "Tilt Motion", "~Intensity.255", 40);
		$this->EnableAction("TiltMotion");
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
        }
 	
	public function GetConfigurationForm() 
	{ 
		$arrayStatus = array(); 
		$arrayStatus[] = array("code" => 101, "icon" => "inactive", "caption" => "Instanz wird erstellt"); 
		$arrayStatus[] = array("code" => 102, "icon" => "active", "caption" => "Instanz ist aktiv");
		$arrayStatus[] = array("code" => 104, "icon" => "inactive", "caption" => "Instanz ist inaktiv");
				
		$arrayElements = array(); 
		$arrayElements[] = array("name" => "Open", "type" => "CheckBox",  "caption" => "Aktiv"); 

		$arrayElements[] = array("type" => "Label", "label" => "Trigger-Variable");
		$arrayElements[] = array("type" => "SelectVariable", "name" => "TriggerID", "caption" => "Trigger"); 

		$ArrayRowLayout = array();
		$ArrayRowLayout[] = array("name" => "UKingMovingHeadActive_1", "type" => "CheckBox",  "caption" => "Moving Head 1 aktivieren"); 
		$ArrayRowLayout[] = array("type" => "SelectInstance", "name" => "UKingMovingHeadInstanceID_1", "caption" => "Instanz ID UKing Moving Head 1", "validModules" => "{EBF15A7E-CE16-EC92-BDDE-85E833A949EF}");
		$arrayElements[] = array("type" => "RowLayout", "items" => $ArrayRowLayout);

		$ArrayRowLayout = array();
		$ArrayRowLayout[] = array("name" => "UKingMovingHeadActive_2", "type" => "CheckBox",  "caption" => "Moving Head 2 aktivieren"); 
		$ArrayRowLayout[] = array("type" => "SelectInstance", "name" => "UKingMovingHeadInstanceID_2", "caption" => "Instanz ID UKing Moving Head 2", "validModules" => "{EBF15A7E-CE16-EC92-BDDE-85E833A949EF}");
		$arrayElements[] = array("type" => "RowLayout", "items" => $ArrayRowLayout);

		$ArrayRowLayout = array();
		$ArrayRowLayout[] = array("name" => "UKingMovingHeadActive_3", "type" => "CheckBox",  "caption" => "Moving Head 3 aktivieren"); 
		$ArrayRowLayout[] = array("type" => "SelectInstance", "name" => "UKingMovingHeadInstanceID_3", "caption" => "Instanz ID UKing Moving Head 3", "validModules" => "{EBF15A7E-CE16-EC92-BDDE-85E833A949EF}");
		$arrayElements[] = array("type" => "RowLayout", "items" => $ArrayRowLayout);

		$ArrayRowLayout = array();
		$ArrayRowLayout[] = array("name" => "UKingMovingHeadActive_4", "type" => "CheckBox",  "caption" => "Moving Head 4 aktivieren"); 
		$ArrayRowLayout[] = array("type" => "SelectInstance", "name" => "UKingMovingHeadInstanceID_4", "caption" => "Instanz ID UKing Moving Head 4", "validModules" => "{EBF15A7E-CE16-EC92-BDDE-85E833A949EF}");
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
		// SetValueInteger($this->GetIDForIdent($Ident), $Value);
		
		switch($Ident) {
			case "PanMotion":
				$this->SetChannelValue( 1, $Value, $Ident);
				break;
			case "TiltMotion":
				$this->SetChannelValue( 3, $Value, $Ident);
				break;
			case "Color":
				$this->SetChannelValue( 5, $Value, $Ident);
				break;
			case "Gobo":
				$this->SetChannelValue( 6, $Value, $Ident);
				break;
			case "Dimming":
				$this->SetChannelValue( 7, $Value, $Ident);
				break;
			case "Lightning":
				$this->SetChannelValue( 8, $Value, $Ident);
				break;
			case "PanTiltSpeed":
				$this->SetChannelValue( 9, $Value, $Ident);
				break;
			case "LightningMode":
				$this->SetChannelValue( 10, $Value, $Ident);
				break;
			case "DimmingMode":
				$this->SetChannelValue( 11, $Value, $Ident);
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
					
					If (($Data[0] == 1) AND ($Program > 0)) {
						$this->SetProgrammedValue();
					}
				}
				break;
		}
    	}    
	
	// Beginn der Funktionen
	private function SetProgrammedValue()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetProgrammedValue", "Ausfuehrung", 0);
			$Program = $this->GetValue("Program");


			
			$ColorArray = array(0, 8, 15, 22, 29, 36, 43, 50, 57, 128, 190);
			$GoboArray = array(0, 8, 16, 24, 32, 40, 48, 56, 64, 72, 80, 88, 96, 104, 112, 120, 128, 190);
			// Arrayaufbau: Pan, Tilt, Color, Gobo
			
			switch($Program) {
				case "1":
					// Farbe und Bewegung synchronisieren
					$Pan = rand(0, 255);
					$Tilt = rand(0, 255);
					$Color = $ColorArray[rand(0, count($ColorArray) - 1)];
					$Gobo = $GoboArray[rand(0, count($GoboArray) - 1)];

					// Daten senden
					for ($i = 1; $i <= 4; $i++) {
						$UKingMovingHeadInstanceID = $this->ReadPropertyInteger("UKingMovingHeadInstanceID_".$i);
						$UKingMovingHeadActive = $this->ReadPropertyBoolean("UKingMovingHeadActive_".$i);
						If (($UKingMovingHeadInstanceID > 0) AND ($UKingMovingHeadActive = true)) {
							I2DUKMH_UKingMovingHeadSequenzer($UKingMovingHeadInstanceID, $Pan, $Tilt, $Color, $Gobo);
						}
					}
					break;
				case "2":
					// Bewegung synchronisieren, Farbe individuell
					$Pan = rand(0, 255);
					$Tilt = rand(0, 255);
					
					for ($i = 1; $i <= 4; $i++) {
						$UKingMovingHeadInstanceID = $this->ReadPropertyInteger("UKingMovingHeadInstanceID_".$i);
						$UKingMovingHeadActive = $this->ReadPropertyBoolean("UKingMovingHeadActive_".$i);
						If (($UKingMovingHeadInstanceID > 0) AND ($UKingMovingHeadActive = true)) {
							$Color = $ColorArray[rand(0, count($ColorArray) - 1)];
							$Gobo = $GoboArray[rand(0, count($GoboArray) - 1)];
							I2DUKMH_UKingMovingHeadSequenzer($UKingMovingHeadInstanceID, $Pan, $Tilt, $Color, $Gobo);
						}
					}
					break;
				case "3":
					// Farbe synchronisieren, Bewegung individuell
					$Color = $ColorArray[rand(0, count($ColorArray) - 1)];
					$Gobo = $GoboArray[rand(0, count($GoboArray) - 1)];
				
					for ($i = 1; $i <= 4; $i++) {
						$UKingMovingHeadInstanceID = $this->ReadPropertyInteger("UKingMovingHeadInstanceID_".$i);
						$UKingMovingHeadActive = $this->ReadPropertyBoolean("UKingMovingHeadActive_".$i);
						If (($UKingMovingHeadInstanceID > 0) AND ($UKingMovingHeadActive = true)) {
							$Pan = rand(0, 255);
							$Tilt = rand(0, 255);
							I2DUKMH_UKingMovingHeadSequenzer($UKingMovingHeadInstanceID, $Pan, $Tilt, $Color, $Gobo);
						}
					}
					break;
			}
			
			// Datenausgabe
			/*
			$Steps = count($Step);
			$StepCounter = intval($this->GetBuffer("StepCounter"));
			If ($StepCounter >= $Steps) {
				$StepCounter = 0;
			}
			$this->SendDebug("SetProgrammedValue", "Steps: ".$Steps." Zaehler: ".$StepCounter, 0);
			
			
			// Daten senden
			for ($i = 1; $i <= 4; $i++) {
				$UKingMovingHeadInstanceID = $this->ReadPropertyInteger("UKingMovingHeadInstanceID_".$i);
				$UKingMovingHeadActive = $this->ReadPropertyBoolean("UKingMovingHeadActive_".$i);
				If (($UKingMovingHeadInstanceID > 0) AND ($UKingMovingHeadActive = true)) {
					$Pan = $Step[$StepCounter][0];
					$Tilt = $Step[$StepCounter][1];
					$Color = $ColorArray[$Step[$StepCounter][2]];
					$Gobo = $GoboArray[$Step[$StepCounter][3]];
					I2DUKMH_UKingMovingHeadSequenzer($UKingMovingHeadInstanceID, $Pan, $Tilt, $Color, $Gobo);
				}
			}
			*/
			$this->SetBuffer("StepCounter", $StepCounter + 1);
			
		}
	}
	
	private function ResetCounter(int $Steps)
	{
		$StepCounter = intval($this->GetBuffer("StepCounter"));
		If ($StepCounter >= $Steps) {
			$StepCounter = 0;
		}
		$this->SendDebug("SetProgrammedValue", "Steps: ".$Steps." Zaehler: ".$StepCounter, 0);
		
	return $StepCounter;
	}

	private function SetChannelValue(Int $Channel, Int $Value, string $Ident)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetChannelValue", "Ausfuehrung: Channel - ".$Channel." - Value - ".$Value, 0);
			for ($i = 1; $i <= 4; $i++) {
				$UKingMovingHeadInstanceID = $this->ReadPropertyInteger("UKingMovingHeadInstanceID_".$i);
				$UKingMovingHeadActive = $this->ReadPropertyBoolean("UKingMovingHeadActive_".$i);
				If (($UKingMovingHeadInstanceID > 0) AND ($UKingMovingHeadActive = true)) {
					I2DUKMH_SetChannelValue($UKingMovingHeadInstanceID, $Channel, $Value, $Ident);
				}
			}
			SetValueInteger($this->GetIDForIdent($Ident), $Value);
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
