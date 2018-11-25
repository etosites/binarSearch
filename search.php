<?php
Class fileString
{
	private $str;
	function __construct ($str)
	{
		
		if(strlen($str)!==0)
		{
			$this->str = $str;
		}
		else
		{
			throw new \Exception('Empty String');
		}

	}
	function getKey()
	{
		return explode("\t",$this->str)['0'];
	}
	
	function getValue()
	{
		return explode("\t",$this->str)['1'];
	}
	
	
}

Class FileSearcher
{
	private $file; 
	function __construct($fileName)
	{
		$this->file = new \SplFileObject($fileName, 'r');

	}
	 
	function getLeinght()
	{
		$this->file->seek(PHP_INT_MAX);
		$this->count = $this->file->key();
		return $this->count;
	}
	

	
	private function goToString(int $string)
	{
		$this->file->seek($string-1);
	}
		
	function getString(int $string)
	{
		$this->goToString($string);
		return $this->file->current();
	}
	function GetLastString()
	{
		return $this->getString($this->getLeinght());
	}
	static function firstUp($searchKey,$key)
	{
		$arrBefore = $arr = [$searchKey,$key];
		sort($arr);
		if($arrBefore['0']===$arr['1']){return true;}
		else if($arrBefore['0']===$arr['0']){return false;}
		else throw new \Exception('Something went wrong');
	}
	

	function binarySearch($searchKey, $start=0, $end)
	{ 
		if ($end < $start) //если стартовый ключ выше поискового
        return 'undef';
		$midle =  floor(($end + $start)/2); //ищем середину
		$nowString = New FileString($this->getString($midle));//получаем строку середины поскового диапазона
		$nowKey = $nowString->getKey();//ключ текущей строки
 
		
		if($searchKey==$nowKey)
			{
				return 'for key: '.$nowString->getKey().' found value: '.$nowString->getValue();
				
			}
		else if($this->firstUp($nowKey, $searchKey))
		{
			return FileSearcher::binarySearch($searchKey, $start, $midle-1);
		}
		else if($this->firstUp($searchKey, $nowKey))
		{
			return FileSearcher::binarySearch($searchKey, $midle+1, $end);
		}

	} 

} 
$fileName = 'binarSearch10gb.txt';
$searchKey = '02e6b5e5781';
function search($fileName, $searchKey)
{
	$file = New FileSearcher($fileName);
	$laststring = New FileString($file->getLastString());//получаем последнюю строку
	echo $file->getLeinght();
	echo $file->binarySearch($searchKey, 0 ,$file->getLeinght());
	
	//$str=New fileString($file->getString(5566));
	//echo $str->getKey();
}
search($fileName, $searchKey);





?>
