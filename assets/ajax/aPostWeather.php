<?php
session_start();
require_once("../inc/iReporting.php");
require_once("../inc/iConnect.php");
require_once("../inc/iQueries.php");
require_once("../inc/io/fHistoricalWeatherIO.php");
require_once("../inc/io/fControlIO.php");
require_once("../inc/io/fSettingsIO.php");
// require_once("../inc/io/fStationsIO.php");

$stationID='6100245999979349';

$rtn=array();
$rtn['Status']=9;

$gtg=true;
$gtg_settings=true;

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

// build input array of all table columns set to default values
$xref=Array();
$input=Array();
$expecting=$tableDefinitions['HistoricalWeather'];
foreach ($expecting as $col) {
  if (array_key_exists($col,$definitions)) {
    $lowerkey=(empty($definitions[$col]['short'])?strtolower($col):$definitions[$col]['short']);
    $xref[$lowerkey]['column']=$col;
    // $xref[$lowerkey]['value']=$definitions[$col]['default'];
    $xref[$lowerkey]['required']=$definitions[$col]['required'];
  }
}
// $the_request is lower case attributes
// overwrite default values with request values
foreach ($the_request as $key => $value) {
  if (array_key_exists($key,$xref)) {
      $xref[$key]['required']='Found';
      $xref[$key]['value']=$value;
  }
}
// flatten xref table and set column keys to table column names
foreach ($xref as $key => $value) {
  if ($value['required']==='Found') {
    $input[$value['column']]=$value['value'];
  } elseif ($value['required']==='yes') {
    $gtg=false; // missing a required attribute
    $rtn['Status']=8;
  }
}

// build input array of all table columns set to default values
$xref=Array();
$settings=Array();
$expecting=$tableDefinitions['Settings'];
foreach ($expecting as $col) {
  if (array_key_exists($col,$definitions)) {
    $lowerkey=(empty($definitions[$col]['short'])?strtolower($col):$definitions[$col]['short']);
    $xref[$lowerkey]['column']=$col;
    // $xref[$lowerkey]['value']=$definitions[$col]['default'];
    $xref[$lowerkey]['required']=$definitions[$col]['required'];
  }
}
// $the_request is lower case attributes
// overwrite default values with request values
foreach ($the_request as $key => $value) {
  if (array_key_exists($key,$xref)) {
      $xref[$key]['required']='Found';
      $xref[$key]['value']=$value;
  }
}
// flatten xref table and set column keys to table column names
foreach ($xref as $key => $value) {
  if ($value['required']==='Found') {
    $settings[$value['column']]=$value['value'];
  } elseif ($value['required']==='yes') {
    $rtn['REQ'][]=$value['column'];
    $gtg_settings=false; // missing a required attribute
  }
}

$rtn['expecting']=$expecting;
$rtn['RawData']=$the_request;
// $rtn['xref']=$xref;
// $rtn['CleanData']=$input;
$rtn['SettingData']=$settings;

if ($gtg===true) {
  if ($input['StationID']!=$stationID) {$gtg=false;$rtn['Status']=7;}
}

if ($gtg==true) {
  unset($data);
  $data=$input;
  $am=addHistoricalWeather($mysqli,$data);
  if ($am['Status']==0) {
    $id=$am['ID'];
    $rtn['Status']=0;
    $rtn['ID']=$am['ID'];
    $message ='Entry Added';
    // $rtn['Status']=1;$rtn['PiServerUploadInterval']=3;
    $rtn['GTGSettings']=$gtg_settings;
    if ($gtg_settings==true) {
      $rtn['DEBUG'][]='A';
      unset($data);
      $data['StationID']=$stationID;
      $rs=removeSettings($mysqli,$data);
      $rtn['DEBUG'][]='B';
      if ($rs['Status']==0) {
        $rtn['DEBUG'][]='C';
        $rtn['StatusRemoved']=$rs['Count'];
      }
      unset($data);
      $data=$settings;
      $rtn['DEBUG'][]='D';
      $as=addSettings($mysqli,$data);
      $rtn['DEBUG'][]='E';
      $rtn['DEBUG'][]=$as['Status'];
      if ($as['Status']==0) {
        $rtn['DEBUG'][]='F';
        $rtn['StatusMessage']='Settings Added';
      }
    }

    unset($data);
    $data=$querytable['ControlByStationID'];
    $data['parm']=array($stationID);
    $gc=getControl($mysqli,$data);
    if ($gc['Status']==0) {
      $rtn['ActionsSent']=$gc['Count'];
      if ($gc['Count']>0) {
        $cRows=$gc['Rows'];
        foreach ($cRows as $key => $value) {
          $rtn['Status']=1;
          $rtn[$value['ControlID']]=($value['ParameterType']=='I'?$value['ParameterInt']:$value['ParameterChar']);
        }
        unset($data);
        $data=$querytable['ControlByStationID'];
        $data['StationID']=$stationID;
        $rc=removeControlStation($mysqli,$data);
        if ($rc['Status']==0) {
          $rtn['ActionsRemoved']=$rc['Count'];
        }
      }
    }
  } else {
    $message='Unable To Add Entry';
  }
} else {
  $rtn['Status']=1;
}

if (isset($message)) {$rtn['Message']=$message;}

echo json_encode($rtn);
?>
