<?php

 
class wineselection{
	/**
     * Class wileselection
     *
     * input the file name in class to process
     *
     * @var $fileName
     */
	public $fileName;

	function __construct($text){
		$this->fileName = $text;
	}

	/**
     * function getResult 
     * This  function reads file then takes unique wine ids in allWines array and 
	 requestedWine array holds key as wine id and values as person who requested that wine
	 
     * The resultdata array finally holds the desired data ie person id mapped with wine id and 
     * And finally result is populated in a file named result.txt
     */
	 
	public function getResult(){
		
		
		$requestedWine	= [];
		$allWines 		= [];
		$sold 		= 0;
		$resultdata 		= [];
		$file 			= fopen($this->fileName,"r");
		while (($line = fgets($file)) !== false) {
			$name_and_wine = explode("\t", $line);
			$name = trim($name_and_wine[0]);
			$wine = trim($name_and_wine[1]);
			if(!array_key_exists($wine, $requestedWine)){
				$requestedWine[$wine] = [];
			}
			$requestedWine[$wine][] = $name;
			$allWines[] = $wine;
		}
		fclose($file);
		
		$allWines = array_unique($allWines);
		
		foreach ($allWines as $key => $wine) {
			
			
				$guy = $requestedWine[$wine][0];
				
				if(!array_key_exists($guy, $resultdata)){
					$resultdata[$guy] = [];
				}
				if(count($resultdata[$guy])<3){
					$resultdata[$guy][] = $wine;
					$sold++;
				}	
		}

		$fh = fopen("result.txt", "w");
		fwrite($fh, "Total number of wine bottles sold in aggregate : ".$sold."\n");
		foreach (array_keys($resultdata) as $key => $guy) {
			foreach ($resultdata[$guy] as $key => $wine) {
				fwrite($fh, $guy." ".$wine."\n");
			}
		}
		fclose($fh);
	}
}
echo "execution started";
echo "<br/>";
echo "-------------";
echo "<br>";
$puzzle = new wineselection("person_wine_3.txt");
$puzzle->getResult();
echo "execution ended";
?>
