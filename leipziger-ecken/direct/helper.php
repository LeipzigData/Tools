<?php

function addLiteral($a,$key,$value) {
  if (!empty($value)) { $a[]=" $key ".'"'.$value.'"'; }
  return $a;
}

function addMLiteral($a,$key,$value) {
  if (!empty($value)) { $a[]=" $key ".'"""'.$value.'"""'; }
  return $a;
}

function addResource($a,$key,$prefix,$value) {
  if (!empty($value)) { $a[]=" $key <".$prefix.$value.'>'; }
  return $a;
}
