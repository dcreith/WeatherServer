<?php
session_start();
require_once("../inc/iReporting.php");
require_once("../inc/iConnect.php");
require_once("../inc/iQueries.php");
require_once("../inc/io/fHistoricalWeatherIO.php");
require_once("../inc/io/fHourlyWeatherIO.php");
require_once("../inc/io/fDailyWeatherIO.php");
require_once("../inc/io/fMonthlyWeatherIO.php");

$stationID='6100245999979349';

$rtn=array();
$rtn['Status']=9;

$gtg=true;

// $rtn['HTML']='';
// $rtn['json']=;
// $rtn['info']=;

switch($_SERVER['REQUEST_METHOD'])
{
  case 'GET': $the_request = &$_GET;break;
  case 'POST': $the_request = &$_POST;break;
  default: $the_request = array();
}

unset($message);

// $rtn['expecting']=$expecting;
// $rtn['RawData']=$the_request;
// $rtn['xref']=$xref;
// $rtn['CleanData']=$input;

if (!array_key_exists('_sid',$the_request)) {$gtg=false;}

if ($gtg===true) {
  if ($the_request['_sid']!=$stationID) {$gtg=false;}
}

if ($gtg===true) {
  unset($data);
  $data['query']=$updatetable['InsertHourly'];
  $ih=insertHourlyWeather($mysqli,$data);
  if (($ih['Status']==0) && ($ih['Count']>0)) {
    $rtn['InsertedHourly']=$ih['Count'];

    unset($data);
    $data['query']=$updatetable['UpdateHourly'];
    $uh=markHistoricalWeather($mysqli,$data);
    if (($uh['Status']==0) && ($uh['Count']>0)) {
      $rtn['MarkedHourly']=$uh['Count'];
    }
  } else {
    $rtn['InsertedHourlyStatus']=$ih['Status'];
    $rtn['InsertedHourly']=0;
  }

  unset($data);
  $data['query']=$updatetable['InsertDaily'];
  $id=insertDailyWeather($mysqli,$data);
  if (($id['Status']==0) && ($id['Count']>0)) {
    $rtn['InsertedDaily']=$id['Count'];
    unset($data);
    $data['query']=$updatetable['UpdateDaily'];
    $ud=markHistoricalWeather($mysqli,$data);
    if (($ud['Status']==0) && ($ud['Count']>0)) {
      $rtn['MarkedDaily']=$ud['Count'];
    }
  } else {
    $rtn['InsertedDailyStatus']=$id['Status'];
    $rtn['InsertedDaily']=0;
  }

  unset($data);
  $data['query']=$updatetable['InsertMonthly'];
  $im=insertMonthlyWeather($mysqli,$data);
  if (($im['Status']==0) && ($im['Count']>0)) {
    $rtn['InsertedMonthly']=$im['Count'];
    unset($data);
    $data['query']=$updatetable['UpdateMonthly'];
    $um=markHistoricalWeather($mysqli,$data);
    if (($um['Status']==0) && ($um['Count']>0)) {
      $rtn['MarkedMonthly']=$ud['Count'];
    }
  } else {
    $rtn['InsertedMonthlyStatus']=$im['Status'];
    $rtn['InsertedMonthly']=0;
  }

  unset($data);
  $data['query']=$updatetable['RemoveHourlyDaily'];
  $rm=removeMarkedHistoricalWeather($mysqli,$data);
  if (($rm['Status']==0) && ($rm['Count']>0)) {
    $rtn['Removed']=$rm['Count'];
  } else {
    $rtn['Removed']=0;
  }

  $rtn['Status']=0;

} else {
  $rtn['Status']=8;
}

if (isset($message)) {$rtn['Message']=$message;}

echo json_encode($rtn);
?>
