<?php
//   
//
//
function parseTags($data, $delim='/') {
  $rtn=Array();
  if (strlen($data)>0) {
    $rtn=explode($delim,$data);
    foreach ($rtn as $key => $value) {
      $rtn[$key]=trim($value);
    }
  }
  return $rtn;
}
function buildAnchor ($input) {
  $buildAnchor='';
  $parms='';$datastring='';
  if (is_array($input)) {
    if (array_key_exists('rowmember',$input)) {
      if (empty($input['rowmember'])) {$input['rowmember']=0;}
    } else {$input['rowmember']=0;}
    if (array_key_exists('anchor',$input)) {
      if (empty($input['anchor'])) {$input['anchor']="#";}
    } else {$input['anchor']="#";}
    if (array_key_exists('parms',$input)) {
      if (is_array($input['parms'])) {
        $d='';
        foreach ($input['parms'] as $key => $value) {
          $parms.=$d.$key.'='.$value;
          $d='&';
        }
        $datastring='?'.$parms;
      }
    }
    if (array_key_exists('tab',$input)) {
      if (empty($input['text'])) {$input['tab']="";}
    } else {$input['tab']="";}
    if (array_key_exists('text',$input)) {
      if (empty($input['text'])) {$input['text']="Link";}
    } else {$input['text']="Link";}
    if (array_key_exists('class',$input)) {
      if (empty($input['text'])) {$input['class']="";}
    } else {$input['class']="";}
    if (array_key_exists('target',$input)) {
      if (empty($input['text'])) {$input['target']="_self";}
    } else {$input['target']="_self";}

    // if (pA('detail',$_a)) {
    //   $buildAnchor='<a href="'.$input['anchor'].$datastring.$input['tab'].'" ';
    //   $buildAnchor.=' target="'.$input['target'].'" ';
    //   $buildAnchor.=' class="'.$input['class'].'" ';
    //   $buildAnchor.='>';
    //   $buildAnchor.=$input['text'];
    //   $buildAnchor.='</a>';
    // } else {
    //   if ((pA('selfmanage',$_a))
    //     && ($_SESSION['MemberID']>0)
    //     && ($input['rowmember']>0)
    //     && ($input['rowmember']==$_SESSION['MemberID'])) {
    //       $buildAnchor='<a href="'.$input['anchor'].$datastring.$input['tab'].'" ';
    //       $buildAnchor.=' target="'.$input['target'].'" ';
    //       $buildAnchor.=' class="'.$input['class'].'" ';
    //       $buildAnchor.='>';
    //       $buildAnchor.=$input['text'];
    //       $buildAnchor.='</a>';
    //   } else {
    //     $buildAnchor=$input['text'];
    //   }
    // }
  }
return $buildAnchor;
}
function ajaxBuild ($fld,$java,$id=Null) {
  $rtn='';
  if ($id!=Null) {$fld.=$id;}
  $rtn='$("#'.$fld.'").change(function(){'.$java.'("'.$fld.'");});';
  return $rtn;
}
function tableCell($value,$attr,$descriptors,$responsive,$prefix=Null,$append=Null) {
  Global $__Constants;
  // requires
  //    $value -> $row (table row)
  //    $attr -> field/column to show
  //    $descriptors -> titles and alignment
  //    $responsive -> classes for responsiveness
  //    $prefix -> any value to prefix
  //    $append -> any value to append
  $rtn='<td class="text-'.$descriptors[$attr]['align'].' '.$responsive[$attr].'">';
  $rtn.=($prefix!=Null ? (!empty($value[$attr]) ? $prefix :'') : '');
  $rtn.=($attr=='Seniority' ? ($value[$attr]==$__Constants['MaxSeniority'] ? '' : $value[$attr]) : $value[$attr]);
  $rtn.=($append!=Null ? '<br/>'.$append : '');
  $rtn.='</td>';
  return $rtn;
}
function validate_post_data($data) {
  // cleans a string
 $data = trim($data);
 $data = stripslashes($data);
 // $data = htmlentities($data);
 return $data;
}

function ajaxRefresh ($row,$fld,$val) {
  global $__Constants;
  $refresh['ReturnCode']=90;
  switch ($fld) {
    case 'Description':
      $refresh['Description']=$val;
      $refresh['ReturnCode']=0;
      break;
  }
  return $refresh;
}

?>
