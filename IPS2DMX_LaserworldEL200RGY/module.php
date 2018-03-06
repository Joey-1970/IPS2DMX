<?
    // Klassendefinition
    class IPS2DMX_LaserworldEL200RGY extends IPSModule 
    {
	 // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() 
        {
            	// Diese Zeile nicht löschen.
            	parent::Create();
 	    	$this->RegisterPropertyBoolean("Open", false);
		$this->ConnectParent("{B1E43BF6-770A-4FD7-B4FE-6D265F93746B}");
 	    	$this->RegisterPropertyInteger("DMXStartChannel", 1);
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
		$arrayElements[] = array("type" => "Label", "label" => "Dieses Gerät benötigt 10 DMX-Kanäle");
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
		$this->RegisterProfileInteger("IPS2DMX.EL200RGYModus", "Popcorn", "", "", 0, 2, 0);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYModus", 0, "Aus", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYModus", 80, "Sound", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYModus", 255, "DMX", "Information", -1);
		
		$this->RegisterProfileInteger("IPS2DMX.EL200RGYMuster", "Popcorn", "", "", 0, 38, 0);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 2, "Linie waagerecht", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 4, "Linie senkrecht", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 6, "Kreuz", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 8, "Quadrat", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 10, "Diagonale rechts", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 12, "Diagonale links", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 14, "Welle", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 16, "Schnecke", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 18, "Dreieck", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 20, "X-Wing normal", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 22, "X-Wing gedreht", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 24, "Umgedrehtes V", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 26, "Kreis", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 28, "Rechteck waagerecht", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 30, "X-Wing verschobene Flügel", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 32, "X-Wing verschobene Flügel gedreht", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 144, "-- Fläche waagerecht auf und zu", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 154, "-- Vogel Flügelschlag unten", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 156, "-- Drehendes V", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 158, "-- Vogel Flügelschlag unten und oben", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 160, "-- Drehendes V aus Linien", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 178, "-- Rechteck auf und zu", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 180, "-- Rechteck drehend", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 182, "-- Rechteck drehend 2", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 184, "-- X-Wing drehend", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 186, "-- X-Wing versetzt auf/zu/über Kreuz", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 188, "-- X-Wing versetzt auf/zu/über Kreuz aus Linien", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 190, "-- X-Wing drehend Linien", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 192, "-- X-Wing versetzt horizontal auf/zu/über Kreuz", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 194, "-- Kreise wechselnde Positionen", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 198, "-- Kreis grösser werdend", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 204, "-- Kreis kleiner werdend", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 210, "-- Kreis kleiner und grösser werdend", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 216, "-- Quadrate wechselnde Positionen", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 222, "-- Quadrat grösser werdend", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 228, "-- Quadrat kleiner werdend", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 234, "-- Quadrat kleiner und grösser werdend", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 240, "-- Rote springende Strahlen", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYMuster", 246, "-- Gelbe springende Strahlen", "Information", -1);
		
		$this->RegisterProfileInteger("IPS2DMX.EL200RGYColor", "Popcorn", "", "", 0, 2, 0);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYColor", 1, "Gelb", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYColor", 40, "Rot", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYColor", 80, "Grün", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYColor", 120, "Originalmuster", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYColor", 160, "Farbwechsel", "Information", -1);
		
		$this->RegisterProfileInteger("IPS2DMX.EL200RGYFarbeffekt", "Popcorn", "", "", 0, 2, 0);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYFarbeffekt", 0, "Aus", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYFarbeffekt", 1, "Teil des Musters zeichnen", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYFarbeffekt", 80, "Durchlaufend", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.EL200RGYFarbeffekt", 120, "Farbwechsel", "Information", -1);
		
		
		
		// Statusvariablen anlegen
		$this->RegisterVariableInteger("Modus", "Modus", "IPS2DMX.EL200RGYModus", 10);
		$this->EnableAction("Modus");
		IPS_SetHidden($this->GetIDForIdent("Modus"), false);
		
		$this->RegisterVariableInteger("Muster", "Muster", "IPS2DMX.EL200RGYMuster", 20);
		$this->EnableAction("Muster");
		IPS_SetHidden($this->GetIDForIdent("Muster"), false);
		
		$this->RegisterVariableInteger("Strobe", "Strobe", "~Intensity.255", 30);
		$this->EnableAction("Strobe");
		IPS_SetHidden($this->GetIDForIdent("Strobe"), false);
		
		$this->RegisterVariableInteger("Punktspeed", "Punktspeed", "~Intensity.255", 40);
		$this->EnableAction("Punktspeed");
		IPS_SetHidden($this->GetIDForIdent("Punktspeed"), false);
		
		$this->RegisterVariableInteger("Color", "Farbe", "IPS2DMX.EL200RGYColor", 80);
		$this->EnableAction("Color");
		IPS_SetHidden($this->GetIDForIdent("Color"), false);
		
		// Reset
		
		$this->RegisterVariableInteger("Farbeffekt", "Farbeffekt", "IPS2DMX.EL200RGYFarbeffekt", 100);
		$this->EnableAction("Farbeffekt");
		IPS_SetHidden($this->GetIDForIdent("Farbeffekt"), false);
		
		
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
		SetValueInteger($this->GetIDForIdent($Ident), $Value);
		
		switch($Ident) {
		case "Modus":
			$this->SetChannelValue(0, $Value);
			break;
		case "Muster":
			$this->SetChannelValue(1, $Value);
			break;
		case "Strobe":
			$this->SetChannelValue(2, $Value);
			break;
		case "Punktspeed":
			$this->SetChannelValue(3, $Value);
			break;
				
		case "Color":
			$this->SetChannelValue( 7, $Value);
			break;
				
		case "Farbeffekt":
			$this->SetChannelValue( 9, $Value);
			break;
		default:
		    throw new Exception("Invalid Ident");
		}
	}
	    
	// Beginn der Funktionen
	private function SetChannelValue(Int $Channel, Int $Value)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetChannelValue", "Ausfuehrung", 0);
			$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
			$DMXChannel = $DMXStartChannel + $Channel; 
			$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => $Value, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
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
