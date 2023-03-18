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
		$arrayElements[] = array("type" => "Label", "label" => "Dieses Gerät benötigt 24 DMX-Kanäle");
		$arrayElements[] = array("type" => "Label", "label" => "_____________________________________________________________________________________________________");
		$arrayElements[] = array("type" => "Label", "label" => "Angabe der genutzten RGB-Kanäle"); 
		for ($i = 0; $i <= 7; $i++) {
			$arrayElements[] = array("name" => "Visible_".($i + 1), "type" => "CheckBox",  "caption" => "Kanal ".($i + 1));
		}
		 
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
		$this->RegisterProfileInteger("IPS2DMX.Program", "Popcorn", "", "", 0, 4, 0);
		IPS_SetVariableProfileAssociation("IPS2DMX.Program", 0, "Manuelle Steuerung", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.Program", 1, "Jump 3", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.Program", 2, "Jump 7", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.Program", 3, "Fade 3", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2DMX.Program", 4, "Fade 7", "Information", -1);
		
		$this->RegisterProfileInteger("IPS2DMX.RGBGroup", "Popcorn", "", "", 0, 7, 0);
		for ($i = 0; $i <= 7; $i++) {
			IPS_SetVariableProfileAssociation("IPS2DMX.RGBGroup", $i, "Gruppe ".($i + 1), "Network", -1);
		}
		
		$this->RegisterProfileFloat("IPS2DMX.FadeTime", "Popcorn", "", " s", 0.0, 3.0, 0.25, 2);
		
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
			
			$this->RegisterVariableInteger("Program_Group_".($i + 1), "Programmgruppe ".($i + 1), "IPS2DMX.RGBGroup", 60 + ($i * 70));
			$this->EnableAction("Program_Group_".($i + 1));
			IPS_SetHidden($this->GetIDForIdent("Program_Group_".($i + 1)), $Visible);
		}
		
		for ($i = 0; $i <= 7; $i++) {
			$Visible = !$this->ReadPropertyBoolean("Visible_".($i + 1));
			$this->RegisterVariableInteger("Program_RGB_".($i + 1), "Programm für Gruppe ".($i + 1), "IPS2DMX.Program", 560 + ($i * 10));
			$this->EnableAction("Program_RGB_".($i + 1));
			IPS_SetHidden($this->GetIDForIdent("Program_RGB_".($i + 1)), $Visible);
		}
		
		for ($i = 0; $i <= 2; $i++) {
			$this->RegisterVariableInteger("Color_ThreeStep_".($i + 1), "Farbe ".($i + 1), "~HexColor", 640 + ($i * 10));
			$this->EnableAction("Color_ThreeStep_".($i + 1));
		}
		
		for ($i = 0; $i <= 6; $i++) {
			$this->RegisterVariableInteger("Color_SevenStep_".($i + 1), "Farbe ".($i + 1), "~HexColor", 670 + ($i * 10));
			$this->EnableAction("Color_SevenStep_".($i + 1));
		}
		
		$this->RegisterVariableFloat("FadeTime", "FadeTime", "IPS2DMX.FadeTime", 740);
		$this->EnableAction("FadeTime");
		
		
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
		$Parts = explode("_", $Ident);
		$Source = $Parts[0]; // Steuerelement
		$Channel = $Parts[1]; // R, G, B bzw. RGB
		$ChannelArray = ["R" => 0, "G" => 1, "B" => 2];
		$Group = $Parts[2]; // Gruppe (1-8)

		switch($Source) {
		case "Status":
			$this->SetChannelState($Group, $Value);
			break;
		case "Color":
			$this->SetColorValue($Group, $Value);
			break;
		case "Intensity":
			$this->SetChannelValue($Group, $ChannelArray[$Channel], $Value);
			break;
		case "Program":
			If ($Channel == "RGB") {	
				$this->ProgramSelection($Group, $Value);
				$this->SetValue($Ident, $Value);
			} 
			elseif ($Channel == "Group") {	
				$this->GroupSelection($Group, $Value);
				$this->SetValue($Ident, $Value);
			} 
			break;
		case "FadeTime":
			$this->SetValue($Ident, $Value);
			break;
		default:
		    throw new Exception("Invalid Ident");
		}

	}
	    
	// Beginn der Funktionen
	private function SetChannelState(Int $Group, Bool $Status)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetChannelStatus", "Ausfuehrung", 0);
			$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
			$Value_R = $this->GetValue("Intensity_R_".$Group);
			$Value_G = $this->GetValue("Intensity_G_".$Group);
			$Value_B = $this->GetValue("Intensity_B_".$Group);
			
			$DMXChannel = $DMXStartChannel + (($Group - 1) * 3);
			$this->SendDebug("SetChannelStatus", "DMXChannel++: ".$DMXChannel." Rot: ".$Value_R." Gruen: ".$Value_G." Blau: ".$Value_B, 0);
			If ($Status == true) {
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => $Value_R, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 1), "Value" => $Value_G, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 2), "Value" => $Value_B, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
			}
			else {
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => 0, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 1), "Value" => 0, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
				$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 2), "Value" => 0, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
			}
			$this->SetValue("Status_RGB_".$Group, $Status);
			
			$this->SetValue("Color_RGB_".$Group, $this->RGB2Hex($Value_R, $Value_G, $Value_B));
		}
	}     
	
	private function SetColorValue(Int $Group, Int $Value)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetColorValue", "Ausfuehrung", 0);
			$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
			
			$ProgramGroup = $this->GetValue("Program_Group_".$Group);
			
			$DMXChannel = $DMXStartChannel + (($Group - 1) * 3);
			
			// Farbwerte aufsplitten
			list($Value_R, $Value_G, $Value_B) = $this->Hex2RGB($Value);
			
			$this->SendDebug("SetColorValue", "DMXChannel: ".$DMXChannel." Rot: ".$Value_R." Gruen: ".$Value_G." Blau: ".$Value_B, 0);
			
			for ($i = 0; $i <= 7; $i++) {
				If ($this->GetValue("Program_Group_".($i + 1)) == $ProgramGroup) {
					$GroupState = $this->GetValue("Status_RGB_".($i + 1));
					$DMXChannel = $DMXStartChannel + ($i * 3);
					
					$this->SetValue("Intensity_R_".($i + 1), $Value_R);
					$this->SetValue("Intensity_G_".($i + 1), $Value_G);
					$this->SetValue("Intensity_B_".($i + 1), $Value_B);
					$this->SetValue("Color_RGB_".($i + 1), $Value);
					
					If ($GroupState == true) {
						$this->SendDebug("SetColorValue", "Gruppe ".($i + 1)."gesendet", 0);
						$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => $Value_R, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
						$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 1), "Value" => $Value_G, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
						$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 2), "Value" => $Value_B, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
					}
				}
			}
		}
	}   
	    
	private function SetChannelValue(Int $Group, Int $Channel, Int $Value)
	{ 
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetChannelValue", "Ausfuehrung", 0);
			$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
			
			$ProgramGroup = $this->GetValue("Program_Group_".$Group);
			
			for ($i = 0; $i <= 7; $i++) {
				If ($this->GetValue("Program_Group_".($i + 1)) == $ProgramGroup) {
					$GroupState = $this->GetValue("Status_RGB_".($i + 1));
					$DMXChannel = $DMXStartChannel + ($i * 3) + $Channel;
										
					$ChannelArray = ["Intensity_R_", "Intensity_G_", "Intensity_B_"];
					$this->SetValue($ChannelArray[$Channel].($i + 1), $Value);
					
					$Value_R = $this->GetValue("Intensity_R_".($i + 1));
					$Value_G = $this->GetValue("Intensity_G_".($i + 1));
					$Value_B = $this->GetValue("Intensity_B_".($i + 1));
					
					$this->SetValue("Color_RGB_".($i + 1), $this->RGB2Hex($Value_R, $Value_G, $Value_B));
					
					$this->SendDebug("SetChannelValue", "DMXChannel: ".$DMXChannel." Rot: ".$Value_R." Gruen: ".$Value_G." Blau: ".$Value_B, 0);

					If ($GroupState == true) {
						$this->SendDebug("SetChannelValue", "Gruppe ".($i + 1)."gesendet", 0);
						$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => $Value, "FadingSeconds" => 0.0, "DelayedSeconds" => 0.0 )));
					}
				}
			}
		}
	}
	
	private function ProgramSelection(Int $Group, Int $Program)
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("ProgramSelection", "Ausfuehrung Gruppe: ".$Group." Programm: ".$Program, 0);
			
			for ($i = 0; $i <= 7; $i++) {
				$this->SendDebug("ProgramSelection", "Zaehler ".$i." Zugeordnete Programmgruppe ".$this->GetValue("Program_Group_".($i + 1))." gesuchte Gruppe ".$Group, 0);
				If ($this->GetValue("Program_Group_".($i + 1)) == $Group - 1) {
					If ($Program == 0) { //Manuelle Steuerung
						$this->EnableAction("Color_RGB_".($i + 1));
						$this->EnableAction("Intensity_R_".($i + 1));
						$this->EnableAction("Intensity_G_".($i + 1));
						$this->EnableAction("Intensity_B_".($i + 1));
					} else { // Eines der anderen Programme
						$this->DisableAction("Color_RGB_".($i + 1));
						$this->DisableAction("Intensity_R_".($i + 1));
						$this->DisableAction("Intensity_G_".($i + 1));
						$this->DisableAction("Intensity_B_".($i + 1));
					}
				}
			}
		}
		
	}
	
	private function GroupSelection(Int $Group, Int $Value)
	{		
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("GroupSelection", "Ausfuehrung Gruppe: ".$Group." Wert: ".$Value, 0);
			$SelectedProgramm = $this->GetValue("Program_RGB_".($Value + 1));
			$this->SendDebug("GroupSelection", "ProgrammWert ".$SelectedProgramm, 0);
			
			If ($SelectedProgramm == 0) { //Manuelle Steuerung
				$this->EnableAction("Color_RGB_".$Group);
				$this->EnableAction("Intensity_R_".$Group);
				$this->EnableAction("Intensity_G_".$Group);
				$this->EnableAction("Intensity_B_".$Group);
			} else {
				$this->DisableAction("Color_RGB_".$Group);
				$this->DisableAction("Intensity_R_".$Group);
				$this->DisableAction("Intensity_G_".$Group);
				$this->DisableAction("Intensity_B_".$Group);
			}
		}
	}
	
	public function MessageSink($TimeStamp, $SenderID, $Message, $Data)
    	{
 		switch ($Message) {
			case 10603:
				// Änderung der Trigger-Variablen
				$this->SendDebug("MessageSink", "Trigger empfangen", 0);
				If ($SenderID == $this->ReadPropertyInteger("TriggerID")) {
					If ($Data[0] == 1) {
						$this->SetProgrammedValue();
					}
				}
				break;
		}
    	}    
	
	private function SetProgrammedValue()
	{	
		$this->SendDebug("SetProgrammedValue", "Ausfuehrung", 0);
		$DMXStartChannel = $this->ReadPropertyInteger("DMXStartChannel");
		$ThreeStepCounter = intval($this->GetBuffer("ThreeStepCounter"));
		$SevenStepCounter = intval($this->GetBuffer("SevenStepCounter"));
		$ThreeStepColorArray = [$this->GetValue("Color_ThreeStep_1"), $this->GetValue("Color_ThreeStep_2"), $this->GetValue("Color_ThreeStep_3")];
		$SevenStepColorArray = [$this->GetValue("Color_SevenStep_1"), $this->GetValue("Color_SevenStep_2"), $this->GetValue("Color_SevenStep_3"), $this->GetValue("Color_SevenStep_4"), $this->GetValue("Color_SevenStep_5"), $this->GetValue("Color_SevenStep_6", $this->GetValue("Color_SevenStep_7")];
																	   
		for ($i = 0; $i <= 7; $i++) {
			$ValuesChanged = false;
			$DMXChannel = $DMXStartChannel + ($i * 3);
			$Programmgoup = $this->GetValue("Program_Group_".($i + 1));
			$Program = $this->GetValue("Program_RGB_".($Programmgoup + 1));
			$GroupState = $this->GetValue("Status_RGB_".($i + 1));
			
			
			$this->SendDebug("SetProgrammedValue", "RGB Gruppe ".($i + 1)." Programmgruppe ".$Programmgoup." Selektiertes Programm ".$Program, 0);				
							
			If ($Program == 1) { // Jump 3
				$FadeTime = 0;
				// Farbwerte aufsplitten
				$Value_RGB = $ThreeStepColorArray[$ThreeStepCounter];
				list($Value_R, $Value_G, $Value_B) = $this->Hex2RGB($ThreeStepColorArray[$ThreeStepCounter]);
				$ValuesChanged = true;
				$this->SendDebug("SetProgrammedValue 1", "Value_RGB ".dechex($Value_RGB), 0);
			}
			elseif ($Program == 2) { // Jump 7
				$FadeTime = 0;
				// Farbwerte aufsplitten
				$Value_RGB = $SevenStepColorArray[$SevenStepCounter];
				list($Value_R, $Value_G, $Value_B) = $this->Hex2RGB($SevenStepColorArray[$SevenStepCounter]);
				$ValuesChanged = true;
				$this->SendDebug("SetProgrammedValue 1", "Value_RGB ".dechex($Value_RGB), 0);
			}
			elseif ($Program == 3) { // Fade 3
				// Farbwerte aufsplitten
				$FadeTime = $this->GetValue("FadeTime");
				$Value_RGB = $ThreeStepColorArray[$ThreeStepCounter];
				list($Value_R, $Value_G, $Value_B) = $this->Hex2RGB($ThreeStepColorArray[$ThreeStepCounter]);
				$ValuesChanged = true;
				$this->SendDebug("SetProgrammedValue 1", "Value_RGB ".dechex($Value_RGB), 0);
			
			}
			elseif ($Program == 4) { // Fade 7
				// Farbwerte aufsplitten
				$FadeTime = $this->GetValue("FadeTime");
				$Value_RGB = $SevenStepColorArray[$SevenStepCounter];
				list($Value_R, $Value_G, $Value_B) = $this->Hex2RGB($SevenStepColorArray[$SevenStepCounter]);
				$ValuesChanged = true;
				$this->SendDebug("SetProgrammedValue 1", "Value_RGB ".dechex($Value_RGB), 0);
			}
			
			If ($ValuesChanged == true) {
				// Steuerelemente setzen
				$this->SetValue("Intensity_R_".($i + 1), $Value_R);
				$this->SetValue("Intensity_G_".($i + 1), $Value_G);
				$this->SetValue("Intensity_B_".($i + 1), $Value_B);
				$this->SetValue("Color_RGB_".($i + 1), $Value_RGB);
				
				If ($GroupState == true) {
					$this->SendDebug("SetColorValue", "Gruppe ".($i + 1)."gesendet", 0);
					$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => $DMXChannel, "Value" => $Value_R, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
					$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 1), "Value" => $Value_G, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
					$this->SendDataToParent(json_encode(Array("DataID"=> "{F241DA6A-A8BD-484B-A4EA-CC2FA8D83031}", "Size" => 1,  "Channel" => ($DMXChannel + 2), "Value" => $Value_B, "FadingSeconds" => $Fadetime, "DelayedSeconds" => 0.0 )));
				}
				
			}
			
		}
		
		If ($ThreeStepCounter < 2) {
			$ThreeStepCounter = $ThreeStepCounter + 1;
		}
		else {
			$ThreeStepCounter = 0;
		}
		If ($SevenStepCounter < 6) {
			$SevenStepCounter = $SevenStepCounter + 1;
		}
		else {
			$SevenStepCounter = 0;
		}
		$this->SetBuffer("ThreeStepCounter", $ThreeStepCounter);
		$this->SetBuffer("SevenStepCounter", $SevenStepCounter);
	}
	    
	private function ProgramJump3(Int $Programmgoup)
	{		
		If ($this->ReadPropertyBoolean("Open") == true) { 
			$this->SendDebug("ProgramJump3", "Ausfuehrung Schrittzähler ".$Stepcounter, 0);
			
			// Drei Farben
			//$ColorArray = [#FF0000, #00FF00, #0000FF];
			
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
