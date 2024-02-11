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
		
		// Profil anlegen
		$this->RegisterProfileInteger("IPS2DMX.MovingHeadSequenzerProgram", "Popcorn", "", "", 0, 6, 0);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadSequenzerProgram", 0, "Manuelle Steuerung", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadSequenzerProgram", 1, "Bewegung und Farbe synchronisieren", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadSequenzerProgram", 2, "Bewegung synchronisieren, Farbe individuell", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.MovingHeadSequenzerProgram", 3, "Bewegung individuell, Farbe synchronisieren", "Repeat", -1);
		
		// Status-Variablen anlegen
		$this->RegisterVariableInteger("Program", "Program", "IPS2DMX.MovingHeadSequenzerProgram", 10);
		$this->EnableAction("Program");
		
		
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
		switch($Ident) {
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