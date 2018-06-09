<?php
//   
//
// requires
//    $db with sql connect object ($mysqli)
//
function panelInput($fld,$row,$descriptors,$type,$placeholder) {
  $id=$fld;
  $dataVal='';
  $form='<div id="fg'.$id.'" class="form-group">';
  $form.='<label for="'.$id.'">'.$descriptors[$fld]['label'].'</label>';
  $form.='<input type="'.$type.'" '.$dataVal.' class="form-control text-'.$descriptors[$fld]['align'].'" id="'.$id.'" data-VAL="'.$row[$fld].'" placeholder="'.$placeholder.'" value="'.$row[$fld].'">';
  $form.='<small id="help_'.$id.'" class="form-text text-muted"></small>';
  $form.='</div>';
return $form;
}

function panelSelect($fld,$row,$descriptors,$options) {

  $thisOne=$row[$fld];
  $id=$fld;
  $dataVal='';

  $form='';
  $form.='<label for="'.$id.'">'.$descriptors[$fld]['label'].'</label>';
  $form.='<div id="fg'.$id.'" class="form-group">';
  $form.='<select class="custom-select select_full text-'.$descriptors[$fld]['align'].'" id="'.$id.'" '.$dataVal.' data-VAL="'.$row[$fld].'">';
  foreach ($options as $key => $value) {
    $selected='';
    if ($key==$thisOne) {$selected=' selected ';}
    $form.='<option '.$selected.' value="'.$key.'">';
    $form.=$value;
    $form.='</option>';
  }
  $form.='</select>';
  $form.='<small id="help_'.$id.'" class="form-text text-muted"></small>';
  $form.='</div>';
return $form;
}

function panelInputGroup($fld,$checkbox,$row,$descriptors,$type,$placeholder) {
  $id=$fld;
  $dataVal='';
  $checked='';
  if ($row[$checkbox]=='Yes') {$checked=' checked ';}

  $form='<label for="'.$id.'">'.$descriptors[$fld]['label'].'</label>';
  $form.='<div id="fg'.$id.'" class="input-group">';
  $form.='<input type="'.$type.'" '.$dataVal.' class="form-control text-'.$descriptors[$fld]['align'].'" id="'.$id.'" data-VAL="'.$row[$fld].'" placeholder="'.$placeholder.'" value="'.$row[$fld].'">';
  $form.='<span class="input-group-addon">';
  $form.='<input type="checkbox" data-VAL="'.$row[$checkbox].'" id="'.$checkbox.'" '.$checked.'">';
  $form.='</span>';
  $form.='<small id="help_'.$id.'" class="form-text text-muted"></small>';
  $form.='</div>';

return $form;
}
function projectPanel($member,$descriptors,$options) {
  $panel='';
  // $panel.='<form>';
  $panel.='<div class="row justify-content-center">';
  $panel.='<div class="col-10">';
  $panel.=panelInput('Description',$member,$descriptors,'text','Description...');
  $panel.='</div>';
  $panel.='<div class="col-2">';
  $panel.=panelSelect('Status',$member,$descriptors,$options['Status']);
  $panel.='</div>';
  $panel.='</div>';

  $panel.='<div class="row justify-content-center">';
  $panel.='<div class="col-2">';
  $panel.=panelInput('Backed',$member,$descriptors,'date','');
  $panel.='</div>';
  $panel.='<div class="col-2">';
  $panel.=panelInput('Expected',$member,$descriptors,'date','');
  $panel.='</div>';
  $panel.='<div class="col-2">';
  $panel.=panelInput('Revised',$member,$descriptors,'date','');
  $panel.='</div>';
  $panel.='<div class="col-2">';
  $panel.=panelInput('Received',$member,$descriptors,'date','');
  $panel.='</div>';
  $panel.='<div class="col-2">';
  $panel.=panelInput('Confidence',$member,$descriptors,'text','8');
  $panel.='</div>';
  $panel.='<div class="col-2">';
  $panel.=panelSelect('Include',$member,$descriptors,$options['Include']);
  $panel.='</div>';
  $panel.='</div>';

  $panel.='<div class="row justify-content-center">';
  $panel.='<div class="col-2">';
  $panel.=panelInput('CDN',$member,$descriptors,'numeric','0.00');
  $panel.='</div>';
  $panel.='<div class="col-2">';
  $panel.=panelInput('Base',$member,$descriptors,'numeric','0.00');
  $panel.='</div>';
  $panel.='<div class="col-2">';
  $panel.=panelSelect('Currency',$member,$descriptors,$options['Currency']);
  $panel.='</div>';
  $panel.='<div class="col-3">';
  $panel.=panelSelect('Country',$member,$descriptors,$options['Country']);
  $panel.='</div>';
  $panel.='<div class="col-3">';
  $panel.=panelInput('Classification',$member,$descriptors,'text','Classification...');
  $panel.='</div>';
  $panel.='</div>';

  $panel.='<div class="row justify-content-center">';
  $panel.='<div class="col-3">';
  $panel.=panelInput('Backer',$member,$descriptors,'numeric','0');
  $panel.='</div>';
  $panel.='<div class="col-3">';
  $panel.=panelInput('Backers',$member,$descriptors,'numeric','0');
  $panel.='</div>';
  $panel.='<div class="col-3">';
  $panel.=panelInput('Goal',$member,$descriptors,'numeric','0');
  $panel.='</div>';
  $panel.='<div class="col-3">';
  $panel.=panelInput('Pledged',$member,$descriptors,'numeric','0');
  $panel.='</div>';
  $panel.='</div>';

  $panel.='<div class="row justify-content-center">';
  $panel.='<div class="col-12">';
  $panel.=panelInput('Notes',$member,$descriptors,'text','Notes...');
  $panel.='</div>';
  $panel.='</div>';

  // $panel.='<div class="col-2">';
  // $panel.=panelInput('Updates',$member,$descriptors,'text','0');
  // $panel.='</div>';
  // $panel.='<div class="col-2">';
  // $panel.=panelInput('Spam',$member,$descriptors,'text','0');
  // $panel.='</div>';

return $panel;
}
function projectAjax() {
  $java='projectUpdate';
  $ajax='';
  $ajax.=ajaxBuild('Description',$java);
  $ajax.=ajaxBuild('Status',$java);
  $ajax.=ajaxBuild('Include',$java);
  $ajax.=ajaxBuild('Backed',$java);
  $ajax.=ajaxBuild('Expected',$java);
  $ajax.=ajaxBuild('Revised',$java);
  $ajax.=ajaxBuild('Received',$java);

  $ajax.=ajaxBuild('CDN',$java);
  $ajax.=ajaxBuild('USD',$java);
  $ajax.=ajaxBuild('Base',$java);
  $ajax.=ajaxBuild('Currency',$java);
  $ajax.=ajaxBuild('Confidence',$java);
  $ajax.=ajaxBuild('Updates',$java);
  $ajax.=ajaxBuild('Spam',$java);
  $ajax.=ajaxBuild('Notes',$java);
  $ajax.=ajaxBuild('Classification',$java);
  $ajax.=ajaxBuild('Country',$java);
  $ajax.=ajaxBuild('Backer',$java);
  $ajax.=ajaxBuild('Backers',$java);
  $ajax.=ajaxBuild('Goal',$java);
  $ajax.=ajaxBuild('Pledged',$java);

return $ajax;
}

function memberForm($action='None') {
  global $__Constants;
  $addButton='';
  if (pA('addboat',$_a)) {
    $addButton='<button id="addButton" class="btn btn-block btn-danger" onClick="newMember(\'0\')" >';
    $addButton.='Add Member';
    $addButton.='</button>';
  }
  $panel='';
  switch ($action) {
    case 'save':
      $panel.='<div class="row">';
      $panel.='<div class="col-12">';
      $panel.=$addButton;
      $panel.='</div>';
      $panel.='</div>';
      break;
    case 'form':
      $panel.='<div class="row">';
      break;
  }
return $panel;
}

?>
