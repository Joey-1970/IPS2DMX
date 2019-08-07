<?
    // Klassendefinition
    class IPS2DMX_OPPSK30UV extends IPSModule 
    {
	 // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() 
        {
            	// Diese Zeile nicht löschen.
            	parent::Create();
 	    	$this->RegisterPropertyBoolean("Open", false);
		$this->ConnectParent("{B1E43BF6-770A-4FD7-B4FE-6D265F93746B}");
 	    	$this->RegisterPropertyInteger("DMXStartChannel", 1);
		
		$this->RegisterVariableInteger("Brightness", "Brightness", "~Intensity.255", 10);
		$this->EnableAction("Brightness");
		
		$this->RegisterVariableInteger("Strobe", "Strobe", "~Intensity.255", 20);
		$this->EnableAction("Strobe");
		
		$this->RegisterVariableInteger("AutoPrograms", "AutoPrograms", "~Intensity.255", 30);
		$this->EnableAction("AutoPrograms");
		
		$this->RegisterVariableInteger("SoundActive", "SoundActive", "~Intensity.255", 40);
		$this->EnableAction("SoundActive");
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
		$arrayElements[] = array("type" => "Label", "label" => "Dieses Gerät benötigt 4 DMX-Kanäle");
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
		case "Brightness":
			$this->SetChannelValue( 0, $Value);
			$Strobe = GetValueInteger($this->GetIDForIdent("Strobe"));
			$this->SetChannelValue( 1, $Strobe);
			break;
		case "Strobe":
			$this->SetChannelValue( 1, $Value);
			$Brightness = GetValueInteger($this->GetIDForIdent("Brightness"));
			$this->SetChannelValue( 0, $Brightness);
			break;
		case "AutoPrograms":
			$this->SetChannelValue( 2, $Value);
			break;
		case "SoundActive":
			$this->SetChannelValue( 3, $Value);
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
	
	protected function HasActiveParent()
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
