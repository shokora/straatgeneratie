#!/usr/bin/php
<?php
/**
Author: Shokora && Knuckle
Date: 17-11-2011
Description: With diz cool generator you never have to be without streetcred again. Be gangstah!
*/

$generator = new StraatGeneratie();

$generator->bruteForceCheck($argv[1]);

//echo $generator->genereerRandomWoord(100);

class StraatGeneratie
{ 
	//Data
	private $korteKlinkers;
	private $langeKlinkers;			
	private $medeklinkersDubbel; 		
	private $medeklinkersEnkel;
	private $maximaalWoorden;		
	
	public function __construct()
	{
		$this->klinkers	 	= array('a','e','i','o','u','ie','ij','oe','ei','y');
		$this->medeklinkersDubbel 	= array('b','c','d','f','g','k','l','m','n','p','s','q','r','t','v','x','z');
		$this->medeklinkersEnkel	= array('h','j','w','ch','sch','sk','sc','sp','sl','bl','pl','gl','cl','st','fr','wr','br','kr','dr','gr','kr','pr','qr','tr','vr');
		$this->medeklinkers             = $this->medeklinkersDubbel + $this->medeklinkersEnkel;
		$this->maximaalWoorden		= 2*count($this->klinkers)*count($this->medeklinkersDubbel)*2*count($this->medeklinkersEnkel)*count($this->medeklinkers);
	}

	public function genereerRandomWoord($amount = 1)
	{
		$woordenlijst = "";
		for($i=0;$i<$amount;$i++)
		{
			//Random generation
			$randomMedeklinker1 	= $this->medeklinkers[array_rand($this->medeklinkers)];
			$randomKlinker1 	= $this->klinkers[array_rand($this->klinkers)];
			$randomMedeklinker2 	= (rand(0,100) >= 50 ? $this->medeklinkersEnkel[array_rand($this->medeklinkersEnkel)] : 
							($keer2 = $this->medeklinkersDubbel[array_rand($this->medeklinkersDubbel)]).$keer2);
			$randomKlinker2 	= $this->klinkers[array_rand($this->klinkers)];
			
			$woordenlijst .= $randomMedeklinker1.$randomKlinker1.$randomMedeklinker2.$randomKlinker2."\n";
		}
		
		return $woordenlijst;
	}
	
	public function bruteForceCheck($wordToCheck = "", $output = true)
        {
		$i=0;
		$returned = false;
		for($a=0;$a<count($this->medeklinkers);$a++)
		{
			$woord = $this->medeklinkers[$a];

			for($b=0;$b<count($this->klinkers);$b++)
			{
				$woord2 = $woord;
				$woord2 .= $this->klinkers[$b];

				        for($c=0;$c<(count($this->medeklinkersDubbel)+count($this->medeklinkersEnkel));$c++)
					{
						$woord3 = $woord2;
						
						if(!$returned && $c >= count($this->medeklinkersDubbel))
						{
							$returned = true;
							$c = 0;
						}
						else
						{
							$medeklinker = $this->medeklinkers[$c];

							if($c < count($this->medeklinkersDubbel) && $returned)
								$medeklinker .= $medeklinker;
				
							$woord3 .= $medeklinker;
				
							for($d=0;$d<count($this->klinkers);$d++)
							{
								$woord4 = $woord3;
								$woord4 .= $this->klinkers[$d];
								$i++;
						
								if($wordToCheck == $woord4)
								{
									if($output)	echo "\nWe have found your word: ".$woord4." after ".$i." tries\n";
									return $woord4;
								
								}
							
							
								if($output) echo "\r ".round($i*100/$this->maximaalWoorden)."%";
							}
						}
					}
			}
		}
		
		return false;
	}
}

