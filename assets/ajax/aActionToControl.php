<?php
session_start();
require_once("../inc/iReporting.php");
require_once("../inc/iConnect.php");
require_once("../inc/iQueries.php");
require_once("../inc/io/fActionsIO.php");
require_once("../inc/io/fControlIO.php");

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

// this is temporary
$the_request['_sid']=$stationID;

unset($message);
unset($id);

// $rtn['expecting']=$expecting;
// $rtn['RawData']=$the_request;
// $rtn['xref']=$xref;
// $rtn['CleanData']=$input;

if (!array_key_exists('_id',$the_request)) {$gtg=false;}
if (!array_key_exists('_sid',$the_request)) {$gtg=false;}

if ($gtg===true) {
  if (is_numeric($the_request['_id'])) {
    $_id=$the_request['_id'];
  } else {
    $gtg=false;
  }
  $_sid=$the_request['_sid'];
}

if ($gtg===true) {
  unset($data);
  $data=$querytable['ActionByID'];
  $data['parm']=Array($_id);
  $ga=getActions($mysqli,$data);
  if (($ga['Status']==0) && ($ga['Count']>0)) {
    // $rtn['GA']=$ga;
    $row=$ga['Rows'][$_id];
    unset($input);$input=Array();
    $input['ControlID']=$row['ControlID'];
    $input['ActionID']=$row['ActionID'];
    $input['ParameterType']=$row["ParameterType"];
    $input['ParameterInt']=$row["ParameterInt"];
    $input['ParameterChar']=$row["ParameterChar"];
    $input['StationID']=$_sid;
    unset($data);
    $data=$input;
    $ac=addControl($mysqli,$data);
    // $rtn['AC']=$ac;
    if ($ac['Status']==0) {
      // $id=$ac['ID'];
      $rtn['Status']=0;
      // $rtn['ID']=$ac['ID'];
      $message ='Control Entry Added';
    }
  } else {
    $rtn['Status']=2;
  }
} else {
  $rtn['Status']=1;
}

if (isset($message)) {$rtn['Message']=$message;}

echo json_encode($rtn);
?>
