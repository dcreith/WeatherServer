<?php
session_start();
require_once("../inc/iReporting.php");
require_once("../inc/iConnect.php");
require_once("../inc/iQueries.php");
require_once("../inc/io/fHistoricalWeatherIO.php");
require_once("../inc/io/fSettingsIO.php");

$stationID='6100245999979349';
$nowUTC = gmdate("Y-m-d H:i:s");

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
unset($id);

// $rtn['expecting']=$expecting;
// $rtn['RawData']=$the_request;
// $rtn['xref']=$xref;
// $rtn['CleanData']=$input;

if (!array_key_exists('si',$the_request)) {$gtg=false;}else{$_id=$the_request['si'];}

if ($gtg===true) {
  if ($_id!=$stationID) {$gtg=false;$rtn['Status']=7;}
}

if ($gtg==true) {
  unset($data);
  $data=$querytable['historicalweatherLastEntryByStation'];
  $data['parm']=Array($_id);
  $gc=getHistoricalWeather($mysqli,$data);
  if (($gc['Status']==0) && ($gc['Count']>0)) {
    foreach ($gc['Rows'] as $key => $current) {}
  } else {
    $message='No Current Data For Station '. $_id;
    $rtn['Status']=3;

    $current=Array();
    $current['Temperature']=0;
    $current['ColdFrameTemperature']=Null;
    $current['Pressure']=0;
    $current['RelativeHumidity']=0;
    $current['DewPoint']=0;
    $current['Probe']='None';
    $current['StationLocalDate']='0000-00-00';
    $current['StationLocalTime']='00:00:00';
  }

  if (($gc['Status']==0) && ($gc['Count']>0)) {

    unset($data);
    $data=$querytable['SettingsByIDStatus'];
    $data['parm']=array($stationID,'Current');
    $gs=getSettings($mysqli,$data);
    if ($gs['Status']==0) {
      $rtn['ActionsSent']=$gs['Count'];
      if ($gs['Count']>0) {
        $sRows=$gs['Rows'];
        foreach ($sRows as $key => $value) {
          $rtn['Settings']=$value;
        }
      }
    }

    $rtn['Status']=0;

   //  check currency
    $to_time = strtotime($nowUTC);
    $from_time = strtotime($current['StationUTCDate'].' '.$current['StationUTCTime']);
    $lag=round(abs($to_time - $from_time) / 60,2);
    if ($lag>15) {$rtn['Currency']='Stale';}else{$rtn['Currency']='OK';}


    //  check probe
    if ($current['Probe']=='SenseHat') {$rtn['Accuracy']='Poor';}else{$rtn['Accuracy']='OK';}

    // overnight low
    unset($data);
    $data=$querytable['OvernightLowTemperatureByStation'];
    $data['parm']=Array($_id);
    $gonl=getMinMaxHistoricalWeather($mysqli,$data);
    if (($gonl['Status']==0) && ($gonl['Count']>0)) {
      foreach ($gonl['Rows'] as $key => $overnightlow) {}
    } else {
      $overnightlow['Minimum']=Null;
      $overnightlow['StationUTCTime']='00:00:00';
    }
    $current['OverNight']=$overnightlow['Minimum'];

    // daytime high
    unset($data);
    $data=$querytable['DaytimeHighTemperatureByHourByStation'];
    $data['parm']=Array($_id);
    $gdth=getMinMaxHistoricalWeather($mysqli,$data);
    if (($gdth['Status']==0) && ($gdth['Count']>0)) {
      foreach ($gdth['Rows'] as $key => $daytimehigh) {}
    } else {
      $daytimehigh['Maximum']=Null;
      $daytimehigh['StationUTCTime']='00:00:00';
    }
    $current['DayTime']=$daytimehigh['Maximum'];

    $rtn['Current']=$current;


    // init hour array
    for ($i=0; $i < 24 ; $i++) {
      $s=($i<10?'0'.$i:$i);
      $tday[$s]=Array();
    }
    $hr=Array();
    $today=Array();
    $yesterday=Array();
    // get yesterday's temperature chart data
    $comparativeTemperature=Array();
    unset($data);
    $data=$querytable['YesterdaysTemperatureMinMaxByHourByStation'];
    $data['parm']=Array($_id);
    $ghy=getMinMaxHistoricalWeather($mysqli,$data);
    if (($ghy['Status']==0) && ($ghy['Count']>0)) {
      foreach ($ghy['Rows'] as $key => $ht) {
        $hr[]=substr($ht['StationLocalTime'],0,2);
        $yesterday[]=$ht['Maximum'];
        // $tday[substr($ht['StationLocalTime'],0,2)]['YesterdaysTemperature']=$ht['Maximum'];
        // $comparativeTemperature['Yesterday'][substr($ht['StationLocalTime'],0,2)]=$ht['Maximum'];
      }
    }

    // get today's temperature chart data
    unset($data);
    $data=$querytable['TodaysTemperatureMinMaxByHourByStation'];
    $data['parm']=Array($_id);
    $ght=getMinMaxHistoricalWeather($mysqli,$data);
    if (($ght['Status']==0) && ($ght['Count']>0)) {
      foreach ($ght['Rows'] as $key => $ht) {
        $today[]=$ht['Maximum'];
        // $day[substr($ht['StationLocalTime'],0,2)]['TodaysTemperature']=$ht['Maximum'];
        // $comparativeTemperature['Today'][substr($ht['StationLocalTime'],0,2)]=$ht['Maximum'];
        // echo 'today=>' . substr($ht['StationLocalTime'],0,2).' max='.$ht['Maximum'].'<br/>';
      }
    }

    // get yesterday's coldframe data
    // $comparativeColdFrame=Array();
    // unset($data);
    // $data=$querytable['YesterdaysColdFrameMinMaxByHourByStation'];
    // $data['parm']=Array($_id);
    // $ghy=getMinMaxHistoricalWeather($mysqli,$data);
    // if (($ghy['Status']==0) && ($ghy['Count']>0)) {
    //   foreach ($ghy['Rows'] as $key => $ht) {
    //     $tday[substr($ht['StationLocalTime'],0,2)]['YesterdaysColdFrame']=$ht['Maximum'];
    //     $comparativeColdFrame['Yesterday'][substr($ht['StationLocalTime'],0,2)]=$ht['Maximum'];
    //   }
    // }
    unset($coldframe);
    if (!empty($current['ColdFrameTemperature'])) {
      $coldframe=Array();
      // get today's coldframe data
      unset($data);
      $data=$querytable['TodaysColdFrameMinMaxByHourByStation'];
      $data['parm']=Array($_id);
      $gcf=getMinMaxHistoricalWeather($mysqli,$data);
      if (($gcf['Status']==0) && ($gcf['Count']>0)) {
        foreach ($gcf['Rows'] as $key => $ht) {
          $coldframe[]=$ht['Maximum'];
          // $hr[]=substr($ht['StationLocalTime'],0,2)
          // $cf[]=$ht['Maximum'];
          // $tday[substr($ht['StationLocalTime'],0,2)]['TodaysColdFrame']=$ht['Maximum'];
          // $comparativeColdFrame['Today'][substr($ht['StationLocalTime'],0,2)]=$ht['Maximum'];
        }
      }
    }

    // build days array
    $y=Array();$t=Array();$c=Array();
    for ($i=0; $i < 24 ; $i++) {
      $s=($i<10?'0'.$i:$i);
      $thisHour=$tday[$s];
      if (array_key_exists('YesterdaysTemperature',$thisHour)) {$y[$s]=$thisHour['YesterdaysTemperature'];}else{$y[$s]=Null;}
      if (array_key_exists('TodaysTemperature',$thisHour)) {$t[$s]=$thisHour['TodaysTemperature'];}else{$t[$s]=Null;}
      if (array_key_exists('TodaysColdFrame',$thisHour)) {$c[$s]=$thisHour['TodaysColdFrame'];}else{$c[$s]=Null;}
    }

    unset($c);
    $c=Array();
    $c['Hours']=$hr;
    $c['Yesterday']=$yesterday;
    $c['Today']=$today;
    $c['ColdFrame']=$coldframe;
    $rtn['Graph']=$c;

    // get yesterday's pressure data
    $yesterdaysPressure=Array();
    unset($data);
    $data=$querytable['YesterdaysPressureMinMaxByHourByStation'];
    $data['parm']=Array($_id);
    $gyp=getMinMaxHistoricalWeather($mysqli,$data);
    if (($gyp['Status']==0) && ($gyp['Count']>0)) {
      foreach ($gyp['Rows'] as $key => $yp) {
        $yesterdaysPressure[substr($yp['StationLocalTime'],0,2)]=$yp['Maximum'];
      }
    }

    $rtn['YesterdaysPressure']=$yesterdaysPressure;

    // get last 7 days temperature data
    $low=Array();$high=Array();$dow=Array();
    unset($data);
    $data=$querytable['Last7DaysTemperatureMinMaxByStation'];
    $data['parm']=Array($_id);
    $ght=getMinMaxHistoricalWeather($mysqli,$data);
    if (($ght['Status']==0) && ($ght['Count']>0)) {
      foreach ($ght['Rows'] as $key => $ht) {
        $dow[]=substr(strftime("%A",strtotime($ht['StationLocalDate'])),0,1);
        $low[]=$ht['Minimum'];
        $high[]=$ht['Maximum'];
      }
    }

    unset($c);
    $c=Array();
    $c['DOW']=$dow;
    $c['Low']=$low;
    $c['High']=$high;
    $rtn['Last7Temperature']=$c;

    // get last 7 days coldframe data
    $low=Array();$high=Array();$dow=Array();
    unset($data);
    $data=$querytable['Last7DaysColdFrameMinMaxByStation'];
    $data['parm']=Array($_id);
    $ght=getMinMaxHistoricalWeather($mysqli,$data);
    if (($ght['Status']==0) && ($ght['Count']>0)) {
      foreach ($ght['Rows'] as $key => $ht) {
        $dow[]=substr(strftime("%A",strtotime($ht['StationLocalDate'])),0,1);
        $low[]=$ht['Minimum'];
        $high[]=$ht['Maximum'];
      }
    }
    $c=Array();
    $c['DOW']=$dow;
    $c['Low']=$low;
    $c['High']=$high;
    $rtn['Last7ColdFrame']=$c;

    // get last 7 days pressure data
    $low=Array();$high=Array();$dom=Array();
    unset($data);
    $data=$querytable['Last7DaysPressureMinMaxByStation'];
    $data['parm']=Array($_id);
    $ghp=getMinMaxHistoricalWeather($mysqli,$data);
    if (($ghp['Status']==0) && ($ghp['Count']>0)) {
      foreach ($ghp['Rows'] as $key => $hp) {
        $dom[]=substr($hp['StationLocalDate'],8,2);
        $low[]=$hp['Minimum'];
        $high[]=$hp['Maximum'];
      }
    }
    $c=Array();
    $c['DOM']=$dom;
    $c['Low']=$low;
    $c['High']=$high;
    $rtn['Last7Pressure']=$c;
  } else {
    $message='No Data For StationID '.$_id;
    $rtn['Status']=2;
  }
} else {
  $message='Failed Initiation';
  $rtn['Status']=1;
}

if (isset($message)) {$rtn['Message']=$message;}

echo json_encode($rtn);
?>
