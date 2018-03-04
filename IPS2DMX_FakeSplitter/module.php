<?
class IPS2DMX_FakeSplitter extends IPSModule
{
	
	public function Create() 
	{
	    	// Diese Zeile nicht entfernen
	    	parent::Create();
	    
	    	// Modul-Eigenschaftserstellung
	    	$this->RegisterPropertyBoolean("Open", false);
	}
  	
	public function GetConfigurationForm() 
	{ 
		$arrayStatus = array(); 
		$arrayStatus[] = array("code" => 101, "icon" => "inactive", "caption" => "Instanz wird erstellt"); 
		$arrayStatus[] = array("code" => 102, "icon" => "active", "caption" => "Instanz ist aktiv");
		$arrayStatus[] = array("code" => 104, "icon" => "inactive", "caption" => "Instanz ist inaktiv");
		$arrayStatus[] = array("code" => 200, "icon" => "error", "caption" => "Instanz ist fehlerhaft");
		
		$arrayElements = array(); 
		$arrayElements[] = array("type" => "CheckBox", "name" => "Open", "caption" => "Aktiv");
	

		$arrayActions = array();
		If ($this->ReadPropertyBoolean("Open") == true) {   
			$arrayActions[] = array("type" => "Label", "label" => "Aktuell sind keine Testfunktionen definiert");
		}
		else {
			$arrayActions[] = array("type" => "Label", "label" => "Diese Funktionen stehen erst nach Eingabe und Übernahme der erforderlichen Daten zur Verfügung!");
		}
		
 		return JSON_encode(array("status" => $arrayStatus, "elements" => $arrayElements, "actions" => $arrayActions)); 		 
 	} 
	
	
	public function ApplyChanges()
	{
		//Never delete this line!
		parent::ApplyChanges();			
	}
		  
	public function ForwardData($JSONString) 
	{
	 	// Empfangene Daten von der Device Instanz
	    	$data = json_decode($JSONString);
	    	$this->SendDebug("ForwardData", "Daten: ".$JSONString, 0);
	}

}
?>
