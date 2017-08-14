<?php


// uso GDRIVE per deterimare dal portale CKAN Regionale l'ultimo CSV aggiornato e lo salvo in locale sul server ogni mezzanotte
$indirizzo ="https://docs.google.com/spreadsheets/d/1emMn4yXhQ1B1qvRkdVNoIg5voiMjW5UICJtPwjD-6c0/pub?gid=0&single=true&output=csv";
$homepage2 = file_get_contents($indirizzo);
$filecsv = '/usr/www/piersoft/dovedormireinbasilicatabot/db/ricettive.csv';

// scrivo il contenuto sul file locale.
file_put_contents($filecsv, $homepage2);
$inizio=1;
$homepage ="";

  $csv1 = array_map('str_getcsv', file('/usr/www/piersoft/dovedormireinbasilicatabot/db/ricettive.csv'));

  $count=0;
  foreach($csv1 as $csv11=>$data1){
    $count1 = $count1+1;


    if ($count1 >1){


//  echo "Conversion: " . $pointDest->toShortString() . " in WGS84<br><br>";
    $features[] = array(
            'type' => 'Feature',
            'geometry' => array('type' => 'Point', 'coordinates' => array((float)$data1[15],(float)$data1[14])),
            'properties' => array('nome_comune' => $data1[5],'denominazione_struttura' => $data1[1], 'indirizzo' => $data1[4],'prov' => $data1[5],'classificazione' => $data1[3],'categoria' => $data1[2],'camere' => "",'posti_letto' => $data1[13],'web' => $data1[10],'tel' => $data1[7],'email' => $data1[11],'perdiodi'=>$data1[12],'servizi_generali'=>$data1[22],'servizi_camera'=>$data1[23],'prezzo_alta_stagione_o_unica'=>$data1[24],'prezzo_bassa_stagione'=>$data1[25],'foto1'=>$data1[26])
            );
  }
}
  $allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
  $geostring=json_encode($allfeatures, JSON_PRETTY_PRINT);

//	$homepage1=str_replace(",",".",$homepage1); //le lat e lon hanno la , e quindi metto il .
//  $homepage1=str_replace(";",",",$homepage1); // converto il CSV da separatore ; a ,

  echo $geostring;
  $file = '/usr/www/piersoft/dovedormireinbasilicatabot/db/ricettive.json';

// scrivo il contenuto sul file locale.
  file_put_contents($file, $geostring);
//echo "finito";
?>
