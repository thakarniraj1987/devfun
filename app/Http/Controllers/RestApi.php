<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class RestApi extends Controller
{
	public function getteen20LastResult($casino)
    {
    	if($casino == 'ab20'){
    		$url='http://143.244.135.148/json/andar_bahar/last_result.json';	
    	}elseif($casino == 'teen20'){
    		$url='http://143.244.135.148/json/20teenpati/last_result.json';	
    	}elseif($casino == 'dt202'){
    		$url='http://143.244.135.148/json/dragontiger2/last_result.json';	
    	}elseif($casino == 'baccarat'){
    		$url='http://143.244.135.148/json/baccarat/last_result.json';	
    	}elseif($casino == '32card'){
    		$url='http://143.244.135.148/json/32cardsb/last_result.json';	
    	}
    		
		try
		{
			$client = new Client();
				$alldata=$client->request('GET',$url,[
					'headers'=>[
					'Content-Type' => 'application/json',
				]
		   ]);
			$data=json_decode($alldata->getBody(), true);				
			return $data;
		}
		catch (\Guzzle\Http\Exception\ConnectException $e) {
			return 0;
		}
		catch (Exception $e)
		{
			
			return 0;
		}
    }
    public function Get32cardvideo()
    {
    	$client = new Client();
		$alldata=$client->request('GET','http://143.244.135.148/json/32cardsb/32_cards_b.json',[
			'headers'=>[
			'Content-Type' => 'application/json',
			]
	   ]);
   	   $data=json_decode($alldata->getBody(), true);
	   return $data;
    }
	public function GetTeen20Data($casino)
    {    	
    	if($casino == 'ab20'){
    		$url='http://143.244.135.148/json/andar_bahar/andar_bahar.json';	
    	}elseif($casino == 'teen20'){
    		$url='http://143.244.135.148/json/20teenpati/20teenpati.json';
    	}elseif($casino == 'baccarat'){
    		$url='http://143.244.135.148/json/baccarat/baccarat.json';
    	}elseif($casino == '32card'){
    		$url='http://172.105.253.130/json/32cardsb/odd.json';
    	}elseif($casino == 'dt202'){
    		$url='http://143.244.135.148/json/dragontiger2/dragon_tiger_2.json';
    	}
    		
		try
		{
			$client = new Client();
				$alldata=$client->request('GET',$url,[
					'headers'=>[
					'Content-Type' => 'application/json',
				]
		   ]);
			$data=json_decode($alldata->getBody(), true);				
			return $data;
		}
		catch (\Guzzle\Http\Exception\ConnectException $e) {
			return 0;
		}
		catch (Exception $e)
		{
			
			return 0;
		}
    }
	public function GetMatchOdds($marketid)
    {
		$url='http://3.7.102.54/listMarketBookBetfair/'.$marketid;
		try {
			$client = new Client();
			$alldata=$client->request('GET',$url,[
				'headers'=>[
				'Content-Type' => 'application/json',
				]
			]);
			$data=json_decode($alldata->getBody(), true);
			return $data;
		}
		catch (\Guzzle\Http\Exception\ConnectException $e) {
			return 0;
		}
		catch (Exception $e)
		{
			return 0;
		}	
	}
	public function DetailCall($eventId,$matchId,$matchtype)
	{
		
		if($matchtype==1)
		{
			$url='http://3.7.102.54/listMarketBookBetfair/'.$eventId;
			try {
				$client = new Client();
					$alldata=$client->request('GET',$url,[
						'headers'=>[
						'Content-Type' => 'application/json',
					]
			   ]);
				$data=json_decode($alldata->getBody(), true);
				return $data;
			}
			catch (\Guzzle\Http\Exception\ConnectException $e) {
				return 0;
			}
			catch (Exception $e)
			{
				return 0;
			}
		}
		else
		{
			$url='http://69.30.238.2:3644/odds/multiple?ids='.$eventId;
			try {
				$client = new Client();
					$alldata=$client->request('GET',$url,[
						'headers'=>[
						'Content-Type' => 'application/json',
					]
			   ]);
				
				$data=json_decode($alldata->getBody(), true);
				return $data;
			}
			catch (\Guzzle\Http\Exception\ConnectException $e) {
				return 0;
			}
			catch (Exception $e)
			{
				return 0;
			}
		}
	}
	public function GetAllMatch()
    {
		$client = new Client();
		$alldata=$client->request('GET','http://3.7.102.54/oddslist',[
			'headers'=>[
			'Content-Type' => 'application/json',
			]
	    ]);
   		$data=json_decode($alldata->getBody(), true);
		return $data;
	}
	public function Fancy_and_Bookmaker_DetailCall($eventId,$matchId,$matchtype)
	{
		$url='http://3.7.102.54/DaimondApi/'.$eventId;
		try 
		{
			$client = new Client();
				$alldata=$client->request('GET',$url,[
					'headers'=>[
					'Content-Type' => 'application/json',
				]
		   ]);
			$data=json_decode($alldata->getBody(), true);
			return $data;
		}
		catch (\Guzzle\Http\Exception\ConnectException $e) {
			return 0;
		}
		catch (Exception $e)
		{
			
			return 0;
		}
	}
}