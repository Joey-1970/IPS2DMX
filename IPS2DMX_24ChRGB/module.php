<?
    // Klassendefinition
    class IPS2DMX_24ChRGB extends IPSModule 
    {
	// Überschreibt die interne IPS_Create($id) Funktion
        public function Create() 
        {
            	// Diese Zeile nicht löschen.
            	parent::Create();
 	    	$this->RegisterPropertyBoolean("Open", false);
		$this->ConnectParent("{B1E43BF6-770A-4FD7-B4FE-6D265F93746B}");
 	    	$this->RegisterPropertyInteger("DMXStartChannel", 1);
		for ($i = 0; $i <= 7; $i++) {
			$this->RegisterPropertyBoolean("Visible_".($i + 1), true);
		}
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
		$arrayElements[] = array("type" => "Label", "label" => "Angabe der genutzten Kanäle"); 
		for ($i = 0; $i <= 7; $i++) {
			$arrayElements[] = array("name" => "Visible_".($i + 1), "type" => "CheckBox",  "caption" => "Kanal ".($i + 1));
		}
		
		
		 
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
		
			//Status-Variablen anlegen
		for ($i = 0; $i <= 7; $i++) {
			$Visible = !$this->ReadPropertyBoolean("Visible_".($i + 1));
			$this->RegisterVariableBoolean("Status_RGB_".($i + 1), "Status RGB ".($i + 1), "~Switch", 10 + ($i * 70));
			$this->EnableAction("Status_RGB_".($i + 1));
			IPS_SetHidden($this->GetIDForIdent("Status_RGB_".($i + 1)), $Visible);
			
			$this->RegisterVariableInteger("Color_RGB_".($i + 1), "Farbe ".($i + 1), "~HexColor", 20 + ($i * 70));
			$this->EnableAction("Color_RGB_".($i + 1));
			IPS_SetHidden($this->GetIDForIdent("Color_RGB_".($i + 1)), $Visible);
			
			$this->RegisterVariableInteger("Intensity_R_".($i + 1), "Intensity Rot ".($i + 1), "~Intensity.255", 30 + ($i * 70) );
			$this->EnableAction("Intensity_R_".($i + 1));
			IPS_SetHidden($this->GetIDForIdent("Intensity_R_".($i + 1)), $Visible);
			
			$this->RegisterVariableInteger("Intensity_G_".($i + 1), "Intensity Grün ".($i + 1), "~Intensity.255", 40 + ($i * 70));
			$this->EnableAction("Intensity_G_".($i + 1));
			IPS_SetHidden($this->GetIDForIdent("Intensity_G_".($i + 1)), $Visible);
			
			$this->RegisterVariableInteger("Intensity_B_".($i + 1), "Intensity Blau ".($i + 1), "~Intensity.255", 50 + ($i * 70));
			$this->EnableAction("Intensity_B_".($i + 1));
			IPS_SetHidden($this->GetIDForIdent("Intensity_B_".($i + 1)), $Visible);
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
	$Channel = $Parts[1]; // R, G, B bzw. RGB
	$ChannelArray = ["R" => 0, "G" => 1, "B" => 2];
	$Group = $Parts[2]; // Gruppe (1-8)

	switch($Source) {
	case "Status":
		//$this->SetOutputPinStatus($Group, $Channel, $Value);
		break;
	case "Color":
		//$this->SetOutputPinColor($Group, $Value);
		break;
	case "Intensity":
		$this->SetChannelValue($Group, $ChannelArray[$Channel], $Value);
		break;
	default:
	    throw new Exception("Invalid Ident");
	}

}
	    
	// Beginn der Funktionen
	public function SetOutputValue(Int $Channel, Int $Value)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetOutputValue", "Ausfuehrung", 0);
			$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $Channel, "Value" => $Value, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
		}
	}
	    
	private function SetChannelValue(Int $Group, Int $Channel, Int $Value)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetChannelValue", "Ausfuehrung", 0);
			$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
			$GroupStatus = GetValueBoolean($this->GetIDForIdent("Status_RGB_".$Group));
			
			$DMXChannel = $DMXStartChannel + (($Group - 1) * 3) + $Channel;
			$this->SendDebug("SetChannelValue", "DMXChannel: ".$DMXChannel, 0);
			If ($GroupStatus == true) {
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => $Value, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
			}
			SetValueInteger($this->GetIDForIdent("Color_RGB_".$Group), $this->RGB2Hex($Value_R, $Value_G, $Value_B));
		}
	}

	 	    
	private function Hex2RGB($Hex)
	{
		$r = (($Hex >> 16) & 0xFF);
		$g = (($Hex >> 8) & 0xFF);
		$b = (($Hex >> 0) & 0xFF);	
	return array($r, $g, $b);
	}
	
	private function RGB2Hex($r, $g, $b)
	{
		$Hex = hexdec(str_pad(dechex($r), 2,'0', STR_PAD_LEFT).str_pad(dechex($g), 2,'0', STR_PAD_LEFT).str_pad(dechex($b), 2,'0', STR_PAD_LEFT));
	return $Hex;
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
