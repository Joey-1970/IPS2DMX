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
		
		// Profile anlegen
		
		
		// Status-Variablen anlegen
	
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
		$Channel = $Parts[1]; // R, G, B bzw. RGB
		$ChannelArray = ["R" => 0, "G" => 1, "B" => 2, "W" => 3];
	
		switch($Source) {
		case "State":
			$this->SetState($Value);
			break;
		case "Color":
			SetValueInteger($this->GetIDForIdent($Ident), $Value);
			$this->SetColor($Value);
			break;
		case "Intensity":
			SetValueInteger($this->GetIDForIdent($Ident), $Value);
			$this->SetChannelValue($ChannelArray[$Channel], $Value);
			break;
		case "Fadetime":
			SetValueInteger($this->GetIDForIdent($Ident), $Value);
			break;
		case "Memory":
			SetValueInteger($this->GetIDForIdent($Ident), $Value);
			$this->SaveColor($Value);
			break;
		case "ColorMemory":
			SetValueInteger($this->GetIDForIdent($Ident), $Value);
			break;
		default:
		    throw new Exception("Invalid Ident");
		}
	}
	    
	// Beginn der Funktionen
	public function SetColor(Int $Color)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetColor", "Ausfuehrung", 0);
			$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
			$Fadetime = GetValueInteger($this->GetIDForIdent("Fadetime_RGBW")) / 10;
			$State_RGBW = GetValueBoolean($this->GetIDForIdent("State_RGBW"));
			// Farbwerte aufsplitten
			list($Value_R, $Value_G, $Value_B) = $this->Hex2RGB($Color);
			$DMXChannel = $DMXStartChannel;
			
			If ($State_RGBW == true) {
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => $Value_R, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 1), "Value" => $Value_G, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 2), "Value" => $Value_B, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
			}
			SetValueInteger($this->GetIDForIdent("Intensity_R"), $Value_R);
			SetValueInteger($this->GetIDForIdent("Intensity_G"), $Value_G);
			SetValueInteger($this->GetIDForIdent("Intensity_B"), $Value_B);
		}
	}
	    
	public function SetChannelValue(Int $Channel, Int $Value)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetChannelValue", "Ausfuehrung", 0);
			$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
			$Fadetime = GetValueInteger($this->GetIDForIdent("Fadetime_RGBW")) / 10;
						
			$State_RGBW = GetValueBoolean($this->GetIDForIdent("State_RGBW"));
			$Value_R = GetValueInteger($this->GetIDForIdent("Intensity_R"));
			$Value_G = GetValueInteger($this->GetIDForIdent("Intensity_G"));
			$Value_B = GetValueInteger($this->GetIDForIdent("Intensity_B"));
			$Value_W = GetValueInteger($this->GetIDForIdent("Intensity_W"));
			
			$DMXChannel = $DMXStartChannel + $Channel;
			$this->SendDebug("SetChannelValue", "DMXChannel: ".$DMXChannel." Rot: ".$Value_R." Gruen: ".$Value_G." Blau: ".$Value_B, 0);
			
			If ($State_RGBW == true) {
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => $Value, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
				SetValueInteger($this->GetIDForIdent("Color_RGB"), $this->RGB2Hex($Value_R, $Value_G, $Value_B));
			}
		}
	}
	
	public function SetState(Bool $State)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetChannelState", "Ausfuehrung", 0);
			$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
			$Fadetime = GetValueInteger($this->GetIDForIdent("Fadetime_RGBW")) / 10;
			$Value_R = GetValueInteger($this->GetIDForIdent("Intensity_R"));
			$Value_G = GetValueInteger($this->GetIDForIdent("Intensity_G"));
			$Value_B = GetValueInteger($this->GetIDForIdent("Intensity_B"));
			$Value_W = GetValueInteger($this->GetIDForIdent("Intensity_W"));
			
			$DMXChannel = $DMXStartChannel;
			$this->SendDebug("SetChannelStatus", "DMXChannel++: ".$DMXChannel." Rot: ".$Value_R." Gruen: ".$Value_G." Blau: ".$Value_B, 0);
			
			If ($State == true) {
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => $Value_R, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 1), "Value" => $Value_G, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 2), "Value" => $Value_B, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 3), "Value" => $Value_W, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
			}
			else {
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => 0, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 1), "Value" => 0, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 2), "Value" => 0, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 3), "Value" => 0, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
			}
			SetValueBoolean($this->GetIDForIdent("State_RGBW"), $State);
			SetValueInteger($this->GetIDForIdent("Color_RGB"), $this->RGB2Hex($Value_R, $Value_G, $Value_B));
		}
	} 
	 
	private function SaveColor(Int $MemorySlot)
	{
		$Color = GetValueInteger($this->GetIDForIdent("Color_RGB"));
		$Intensity = round(GetValueInteger($this->GetIDForIdent("Intensity_W")) / 2.55);
		IPS_SetVariableProfileAssociation("IPS2DMX.RGBW_".$this->InstanceID, $MemorySlot, $Intensity." %", "Information", $Color);
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
