<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" >
<style>
table, th, td {
  border: 0.1px solid red ;
}
</style>
</head>
<body>


<?php
 
$curl = curl_init(); //
//curl -X GET "" -H "accept: application/json"
$url="https://ws-ext.it.auth.gr/open/getUnits/academic";
//https://ws-ext.it.auth.gr/open/getDiningModes
//https://ws-ext.it.auth.gr/open/getUnitsPeople
//https://ws-ext.it.auth.gr/open/getDeptStudiesProg/csd
//https://ws-ext.it.auth.gr/open/getUnits/academic


curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl,CURLOPT_HEADER,0);
$dataJSON = curl_exec($curl);

if($dataJSON == FALSE){
die("cURL Error: " . curl_error($curl));
}

curl_close($curl);


$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($dataJSON, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);




$w = 0;
$ww=0;
$col=1;
foreach ($jsonIterator as $key => $val) {
	$d = $jsonIterator->getDepth();
if($w==0){
	 if(is_array($val)) {
       //echo "$key   \n";              //take units
		$a[0][0]=$key;
     }
$w=$w+1;
}
if($d ==2 ){
	
	 $a[0][$col]=$key;
	 $col=$col+1;
	// echo $key;
	
	
	
}
 
if(is_array($val) && $d==1){
	
  if($ww ==1){
  break;
  }
  $ww=1;
}
}


$coun=0;
$coo=null;
$row=0;
$coll=1;

foreach ($jsonIterator as $key => $val) {
  $d = $jsonIterator->getDepth();
        
		
		
if(!($key==="units")){
if(is_array($val) && $d >= 2){
	
	
	
	        $coun = (count($val));
			//echo "leitourgia :: 1 ";
			//echo "$key =>$val \n";
			//echo "<br>";
			
             //$coll=$coll+1;
			$coo=null;
			
			
}elseif($coun > 0){
   
            $coo=$val."<br>".$coo;
	     	$coun=$coun-1;
           // echo "leitourgia :: 2 ";
			//echo "$key =>$val \n";
			//echo "<br>";
			
			 if((!($coo === null)) && ($coun == 0)){
	     	  //  echo "$coo";
				$a[$row][$coll]=$coo;
                $coll=$coll+1;
	            $coo=null;
	}
  

}elseif(is_array($val)){
	 //echo "leitourgia :: 3  ";
			//echo "$key =>$val \n";
		//	echo "<br>";
			$row=$row+1;
			$a[$row][0]=$key;
		//	echo $a[$row][0];
			$coll=1;
			
	
}else{
	
	      //  echo "   leitourgia :: 4  ";
			//echo "$key =>$val \n";
			//echo "<br>";
			 $a[$row][$coll]=$val;
			 //echo $a[$row][$coll];
             $coll=$coll+1;
			//$coo=null;
			
			}
}
}

echo "<table id='display'>";
for($r=0;$r<=$row;$r++){
	echo"<tr>";
for($c=0;$c<$col;$c++){
		echo"<td>";

	if (isset($a[$r][$c])){
    echo $a[$r][$c];    
} else {    
    echo null;
}
	
	
echo"<td>";
}
echo"</tr>";
}
echo "</table>"




 
?>


</body>
</html>