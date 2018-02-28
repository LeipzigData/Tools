<?php

include_once("helper.php");

function displayChanges() {
    $a=array();
    $nr=2000;
    foreach (array_reverse(preg_split("/\n/",getData())) as $row) {
        if (preg_match("/Akteur deaktiviert/", $row)) {
            $a[]=akteurDeaktiviert($row,$nr++);
            }
        else if (preg_match("/Akteur hat sich registriert/", $row)) {
                $a[]=akteurRegistriert($row,$nr++);
            }
        else if (preg_match("/Neue.*eingetragen/", $row)) {
                $a[]=neueAktivitaet($row,$nr++);
            }
        else { $a[]=processLine($row,$nr++); }
    }
    return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/Changes/> a owl:Ontology ;
    rdfs:comment "Changes zur Datenbank";
    rdfs:label "Nachhaltiges Leipzig - Changes" .

'.join("\n\n",$a);
}

function akteurDeaktiviert($row,$nr) {
    preg_match('|Akteur deaktiviert:\s+(.+)\s*\((.*),\s*(.*)\)\s*\s*\.\s*(.+)$|',$row,$matches);
    // print_r($matches);
    $akteur=trim($matches[1]); $ort=$matches[2]; $user=$matches[3]; $date=$matches[4];
    $a=array();
    $a[]='<http://nachhaltiges-leipzig.de/Data/ChangeEntry.'.$nr.'> a nl:ChangeEntry';
    $a=addLiteral($a,'nl:Akteur',$akteur);
    $a=addResource($a,'ld:proposedURI','http://leipzig-data.de/Data/Akteur/',fixOrgURI($akteur));
    $a=addLiteral($a,'nl:Kontakt',$user);
    $a=addLiteral($a,'nl:Aktivitaet', 'deactivated');
    $a=addLiteral($a,'dct:created', $date);
    return join(" ;\n ",$a)." . ";
}

function akteurRegistriert($row,$nr) {
    preg_match('/Akteur hat sich registriert. Name:\s+(.+)\s*\.\s*(.+)$/',$row,$matches);
    // print_r($matches);
    $user=fixQuotes(trim($matches[1])); $date=$matches[2];
    $a=array();
    $a[]='<http://nachhaltiges-leipzig.de/Data/ChangeEntry.'.$nr.'> a nl:ChangeEntry';
    $a=addLiteral($a,'nl:Akteur',$user);
    $a=addResource($a,'ld:proposedURI','http://leipzig-data.de/Data/Akteur/',fixOrgURI($user));
    $a=addLiteral($a,'nl:Aktivitaet', 'registered');
    $a=addLiteral($a,'dct:created', $date);
    return join(" ;\n ",$a)." . ";
}

function neueAktivitaet($row,$nr) {
    preg_match('|Neue Aktivität von\s*(.*)\s*eingetragen.\s*(.*)\s*(admin/users/.+)\.\s*(.+)\.\s*(.+)$|',$row,$matches);
    // print_r($matches);
    $akteur=trim($matches[1]); $rest=$matches[2]; $user=$matches[3];
    $action=$matches[4]; $date=$matches[5];
    $action=str_replace('actions/','http://nachhaltiges-leipzig.de/Data/Action.',$action);
    $action=str_replace('events/','http://nachhaltiges-leipzig.de/Data/Event.',$action);
    $action=str_replace('projects/','http://nachhaltiges-leipzig.de/Data/Projekt.',$action);
    $action=str_replace('services/','http://nachhaltiges-leipzig.de/Data/Service.',$action);
    $action=str_replace('stores/','http://nachhaltiges-leipzig.de/Data/Store.',$action);
    $user=str_replace('admin/users/','http://nachhaltiges-leipzig.de/Data/Akteur.',$user);
    $a=array();
    $a[]='<http://nachhaltiges-leipzig.de/Data/ChangeEntry.'.$nr.'> a nl:ChangeEntry';
    $a=addResource($a,'nl:User', '',$user);
    $a=addLiteral($a,'nl:Akteur',$akteur);
    $a=addResource($a,'ld:proposedURI','http://leipzig-data.de/Data/Akteur/',fixOrgURI($akteur));
    $a=addResource($a,'nl:linksTo', '', $action);
    $a=addLiteral($a,'dct:created', $date);
    if (!empty($rest)) { $a=addLiteral($a,'rdfs:comment',trim($rest)); }
    return join(" ;\n ",$a)." . ";
}

function processLine($row,$nr) {
    if (empty(trim($row))) { return; }
    preg_match('|(.*)(admin/users/.+)\.\s*(.+)\.\s*(.+)$|',$row,$matches);
    // print_r($matches);
    $rest=$matches[1]; $user=fixLiteral($matches[2]); $action=$matches[3]; $date=$matches[4];
    $a=array();
    $a[]='<http://nachhaltiges-leipzig.de/Data/ChangeEntry.'.$nr.'> a nl:ChangeEntry';
    $a=addLiteral($a,'nl:Akteur',$user);
    $a=addResource($a,'ld:proposedURI','http://leipzig-data.de/Data/Akteur/',fixOrgURI($user));
    $a=addLiteral($a,'nl:Aktivitaet', $action);
    $a=addLiteral($a,'dct:created', $date);
    if (!empty($rest)) { $a=addLiteral($a,'rdfs:comment',trim($rest)); }
    return join(" ;\n ",$a)." . ";
}

function getData() {
    // Data extracted from email notifications
    return 
'
Neue Aktivität von Ackerdemia e.V. eingetragen. admin/users/224. services/88. 2018-02-27
Akteur hat sich registriert. Name: Ackerdemia e.V. . 2018-02-26
Neue Aktivität von Delitzscher Land e.V eingetragen. admin/users/222. actions/67. 2018-02-26
Neue Aktivität von  ernte-mich eingetragen. admin/users/77. events/1124. 2018-02-25
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1123. 2018-02-25
Neue Aktivität von  ernte-mich eingetragen. admin/users/77. events/1122. 2018-02-25
Neue Aktivität von  ernte-mich eingetragen. admin/users/77. events/1121. 2018-02-25
Neue Aktivität von  ernte-mich eingetragen. admin/users/77. events/1120. 2018-02-25
Neue Aktivität von  ernte-mich eingetragen. admin/users/77. events/1119. 2018-02-25
Neue Aktivität von  ernte-mich eingetragen. admin/users/77. events/1118. 2018-02-25
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1117. 2018-02-24
Neue Aktivität von GeoWerkstatt Leipzig e.V. eingetragen. admin/users/168. events/1116. 2018-02-23
Neue Aktivität von GeoWerkstatt Leipzig e.V. eingetragen. admin/users/168. events/1115. 2018-02-23
Neue Aktivität von GeoWerkstatt Leipzig e.V. eingetragen. admin/users/168. events/1114. 2018-02-23
Akteur deaktiviert: Bio Tempel (Leipzig, Christel Wust) .  2018-02-23
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1113. 2018-02-23
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1112. 2018-02-23
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1111. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1110. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1109. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1108. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1107. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1106. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1105. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1104. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1103. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1102. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1101. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1100. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1099. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1098. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1097. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1096. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1095. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1094. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1093. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1092. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1091. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1090. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1089. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1088. 2018-02-22
Neue Aktivität von DGGL Sachsen  eingetragen. admin/users/179. events/1087. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1086. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1085. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1084. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1083. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1082. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1081. 2018-02-22
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1080. 2018-02-21
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1079. 2018-02-21
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1078. 2018-02-21
Neue Aktivität von Projekt "Lebendige Luppe" eingetragen. admin/users/78. events/1078. 2018-02-21
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. events/1077. 2018-02-21
Neue Aktivität von ANNALINDE gGmbH  eingetragen. admin/users/51. projects/118. 2018-02-21
Akteur hat sich registriert. Name: ANNALINDE Akademie  . 2018-02-21
Akteur deaktiviert: Carina Flores de Looß  (Leipzig, Carina Flores de Looß) .  2018-02-21
Neue Aktivität von Magistralenmanagement Georg-Schumann-Straße eingetragen. admin/users/220. events/1076. 2018-02-19
Neue Aktivität von Magistralenmanagement Georg-Schumann-Straße eingetragen. admin/users/220. events/1075. 2018-02-19
Neue Aktivität von Magistralenmanagement Georg-Schumann-Straße eingetragen. admin/users/220. events/1074. 2018-02-19
Akteur hat sich registriert. Name: Delitzscher Land e.V.  . 2018-02-19
Neue Aktivität von heldenküche eingetragen. admin/users/221. events/1073. 2018-02-19
Neue Aktivität von heldenküche eingetragen. admin/users/221. events/1072. 2018-02-19
Neue Aktivität von heldenküche eingetragen. admin/users/221. events/1071. 2018-02-19
';
}

function getData_01() {
    // Data extracted from email notifications
    return 
'Neue Aktivität von Blütenreich eingetragen. admin/users/208. projects/117. 2018-02-18
Akteur hat sich registriert. Name: heldenküche . 2018-02-18
Neue Aktivität von Blütenreich eingetragen. admin/users/208. projects/116. 2018-02-18
Neue Aktivität von Blütenreich eingetragen. admin/users/208. projects/115. 2018-02-18
Neue Aktivität von  Gemeinsam Wandeln eingetragen. admin/users/23. services/87. 2018-02-18
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/66. 2018-02-18
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/65. 2018-02-18
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1070. 2018-02-18
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/64. 2018-02-18
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1069. 2018-02-18
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1068. 2018-02-18
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1067. 2018-02-18
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1066. 2018-02-18
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1065. 2018-02-18
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. events/1064. 2018-02-18
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. events/1063. 2018-02-18
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. events/1062. 2018-02-18
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. events/1061. 2018-02-18
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. events/1060. 2018-02-18
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. events/1059. 2018-02-18
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. events/1058. 2018-02-18
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. events/1057. 2018-02-18
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. events/1056. 2018-02-18
Neue Aktivität von Blütenreich eingetragen. admin/users/208. events/1055. 2018-02-18
Neue Aktivität von Der Lindentaler eingetragen. admin/users/23. events/1054. 2018-02-18
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/63. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1053. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/62. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1052. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/61. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1051. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/60. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/59. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/58. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1050. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/57. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1049. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1048. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1047. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1046. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/56. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1045. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1044. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1043. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/55. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/54. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1042. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1041. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1040. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/53. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1039. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1038. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1037. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1036. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1035. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1034. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1033. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1032. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1031. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1030. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/52. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/51. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1029. 2018-02-17
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1028. 2018-02-17
Akteur deaktiviert: Nextleipzig (Leipzig, Peter Hartmann) .  2018-02-17
Akteur hat sich registriert. Name: Magistralenmanagement Georg-Schumann-Straße . 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. services/86. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. services/85. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. services/84. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. services/83. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. services/82. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. services/81. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. services/80. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. services/79. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. services/78. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. services/77. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. services/76. 2018-02-16
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/1027. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. services/76. 2018-02-16
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/1026. 2018-02-16
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/1025. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. actions/49. 2018-02-16
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/1024. 2018-02-16
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/1023. 2018-02-16
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/1022. 2018-02-16
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/1021. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. services/75. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. actions/48. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. events/1020. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. events/1019. 2018-02-16
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. events/1018. 2018-02-16
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1017. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/47. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/46. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1016. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/45. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1015. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1014. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1013. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1012. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1011. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1010. 2018-02-15
Neue Aktivität von Solidarische Feldwirtschaft eingetragen. admin/users/219. events/1009. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1008. 2018-02-15
Akteur hat sich registriert. Name: Solidarische Feldwirtschaft . 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/44. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1007. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1006. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1005. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1004. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/43. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1003. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. actions/42. 2018-02-15
Neue Aktivität von NABU-Regionalverband Leipzig eingetragen. admin/users/60. events/1002. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/1001. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/1000. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/999. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/998. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/997. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/996. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/995. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/994. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/993. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/992. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/991. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/990. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/989. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/988. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/987. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/986. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/985. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/984. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/983. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/982. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/981. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/980. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/979. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/978. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/977. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/976. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/975. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/974. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/973. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/972. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/971. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/970. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/969. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/968. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/967. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/966. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/965. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/964. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/963. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/962. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/961. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/960. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/959. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/958. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/957. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/956. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/955. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/954. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/953. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/952. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/951. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/950. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/949. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/948. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/947. 2018-02-15
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. events/946. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/945. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/944. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/943. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/942. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/941. 2018-02-15
Neue Aktivität von Stadt Leipzig Umweltinformationszentrum eingetragen. admin/users/185. events/940. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/939. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/938. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/937. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/936. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/935. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/934. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/933. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/932. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/931. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/930. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/929. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/928. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/927. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/926. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/925. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/924. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/923. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/922. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/921. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/920. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/919. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/918. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/917. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/916. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/915. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/914. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/913. 2018-02-15
Neue Aktivität von Zentrum für Fermentation eingetragen. admin/users/202. events/912. 2018-02-15
Neue Aktivität von Zentrum für Fermentation eingetragen. admin/users/202. events/911. 2018-02-15
Neue Aktivität von Zentrum für Fermentation eingetragen. admin/users/202. events/910. 2018-02-15
Neue Aktivität von Zentrum für Fermentation eingetragen. admin/users/202. events/909. 2018-02-15
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/908. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/907. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/906. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/905. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/904. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/903. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/902. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/901. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/900. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/899. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/898. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/897. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/896. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/895. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/894. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/893. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/892. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/891. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/890. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/889. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/888. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/887. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/886. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/885. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/884. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/883. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/882. 2018-02-15
Akteur hat sich registriert. Name: mobile- apfelquetsche . 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/881. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/880. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/879. 2018-02-15
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/878. 2018-02-15
Neue Aktivität von agra-Park eingetragen. admin/users/217. events/877. 2018-02-15
Akteur hat sich registriert. Name: agra-Park . 2018-02-15
Neue Aktivität von Verein der Freunde und Förderer des Wildparks  eingetragen. admin/users/149. services/74. 2018-02-15
Neue Aktivität von Verein der Freunde und Förderer des Wildparks  eingetragen. admin/users/149. services/73. 2018-02-15
Neue Aktivität von Verein der Freunde und Förderer des Wildparks  eingetragen. admin/users/149. services/72. 2018-02-15
Neue Aktivität von Verein der Freunde und Förderer des Wildparks  eingetragen. admin/users/149. events/876. 2018-02-15
Neue Aktivität von Verein der Freunde und Förderer des Wildparks  eingetragen. admin/users/149. events/875. 2018-02-15
Neue Aktivität von Verein der Freunde und Förderer des Wildparks  eingetragen. admin/users/149. events/874. 2018-02-15
Neue Aktivität von Verein der Freunde und Förderer des Wildparks  eingetragen. admin/users/149. events/873. 2018-02-15
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. events/872. 2018-02-15
Neue Aktivität von Verein der Freunde und Förderer des Wildparks  eingetragen. admin/users/149. events/871. 2018-02-15
Neue Aktivität von Verein der Freunde und Förderer des Wildparks  eingetragen. admin/users/149. events/870. 2018-02-15
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. events/869. 2018-02-15
Neue Aktivität von Verein der Freunde und Förderer des Wildparks  eingetragen. admin/users/149. events/868. 2018-02-15
Neue Aktivität von Verein der Freunde und Förderer des Wildparks  eingetragen. admin/users/149. events/867. 2018-02-15
Akteur deaktiviert: Konzeptwerk Neue Ökonomie (Leipzig, Susanne Brehm) . 2018-02-15
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. action/40. 2018-02-14
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. action/39. 2018-02-14
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. action/38. 2018-02-14
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. action/37. 2018-02-14
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. action/36. 2018-02-14
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. action/35. 2018-02-14
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. action/34. 2018-02-14
Neue Aktivität von Ölmühle Leipzig eingetragen. admin/users/216. action/33. 2018-02-14
Neue Aktivität von  Zoo Leipzig GmbH eingetragen. admin/users/214. events/866. 2018-02-14
Neue Aktivität von  Zoo Leipzig GmbH eingetragen. admin/users/214. events/865. 2018-02-14
Neue Aktivität von  Zoo Leipzig GmbH eingetragen. admin/users/214. events/864. 2018-02-14
Neue Aktivität von Wilde Leipziger  eingetragen. admin/users/204. events/863. 2018-02-14
Akteur hat sich registriert. Name: Ölmühle Leipzig  . 2018-02-14
Neue Aktivität von Ökolöwe - Umweltbund Leipzig e.V.  eingetragen. admin/users/69. events/861. 2018-02-14
Neue Aktivität von Ökolöwe - Umweltbund Leipzig e.V.  eingetragen. admin/users/69. events/860. 2018-02-14
Neue Aktivität von Cammerspiele Leipzig eingetragen. admin/users/215. events/859. 2018-02-14
Akteur hat sich registriert. Name: Cammerspiele Leipzig  . 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/858. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/857. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/856. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/855. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/854. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/853. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/852. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/851. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/850. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/849. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/848. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/847. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/846. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/845. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/844. 2018-02-14
Neue Aktivität von ADFC Leipzig eingetragen. admin/users/26. events/843. 2018-02-14
Neue Aktivität von Zoo Leipzig GmbH eingetragen. admin/users/214. events/842. 2018-02-14
Akteur hat sich registriert. Name: Zoo Leipzig GmbH  . 2018-02-14
Neue Aktivität von Food Assembly Leipzig eingetragen. admin/users/141. events/841. 2018-02-14
Neue Aktivität von Food Assembly Leipzig eingetragen. admin/users/141. events/840. 2018-02-14
Neue Aktivität von Food Assembly Leipzig eingetragen. admin/users/141. events/839. 2018-02-14
Neue Aktivität von Food Assembly Leipzig eingetragen. admin/users/141. events/838. 2018-02-14
Neue Aktivität von Food Assembly Leipzig eingetragen. admin/users/141. events/837. 2018-02-14
Neue Aktivität von Food Assembly Leipzig eingetragen. admin/users/141. events/836. 2018-02-14
Neue Aktivität von Food Assembly Leipzig eingetragen. admin/users/141. events/835. 2018-02-14
Neue Aktivität von Food Assembly Leipzig eingetragen. admin/users/141. events/834. 2018-02-14
Neue Aktivität von Food Assembly Leipzig eingetragen. admin/users/141. events/833. 2018-02-14
Neue Aktivität von Food Assembly Leipzig eingetragen. admin/users/141. events/832. 2018-02-13
Neue Aktivität von Food Assembly Leipzig eingetragen. admin/users/141. events/831. 2018-02-13
Neue Aktivität von Food Assembly Leipzig eingetragen. admin/users/141. events/830. 2018-02-13
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/829. 2018-02-13
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/828. 2018-02-13
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/827. 2018-02-13
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/826. 2018-02-13
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/825. 2018-02-13
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/824. 2018-02-13
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/823. 2018-02-13
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/822. 2018-02-13
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/821. 2018-02-13
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/820. 2018-02-13
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/819. 2018-02-13
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/818. 2018-02-13
Neue Aktivität von GRÜNE LIGA Kohrener Land eingetragen. admin/users/213. actopns/32. 2018-02-13
Akteur hat sich registriert. Name: GRÜNE LIGA Kohrener Land . 2018-02-13
Neue Aktivität von Galerie für Zeitgenössische Kunst eingetragen. admin/users/212. events/817. 2018-02-13
Akteur hat sich registriert. Name: Galerie für Zeitgenössische Kunst . 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. services/71. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. services/70. 2018-02-13
Neue Aktivität von GRASSI Museum für Angewandte Kunst eingetragen. admin/users/211. events/816. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. services/69. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. services/68. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. services/67. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/815. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/814. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/813. 2018-02-13
Neue Aktivität von GRASSI Museum für Angewandte Kunst eingetragen. admin/users/211. events/812. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/811. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/810. 2018-02-13
Neue Aktivität von Querbeet Leipzig e.V. eingetragen. admin/users/210. events/809. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/808. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/807. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/806. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/805. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/804. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/803. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/802. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/801. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/800. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/799. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/798. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/797. 2018-02-13
Neue Aktivität von GRASSI Museum für Angewandte Kunst eingetragen. admin/users/211. events/796. 2018-02-13
Neue Aktivität von GRASSI Museum für Angewandte Kunst eingetragen. admin/users/211. events/795. 2018-02-13
Neue Aktivität von GRASSI Museum für Angewandte Kunst eingetragen. admin/users/211. events/794. 2018-02-13
Neue Aktivität von GRASSI Museum für Angewandte Kunst eingetragen. admin/users/211. events/793. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/792. 2018-02-13
Neue Aktivität von GRASSI Museum für Angewandte Kunst eingetragen. admin/users/211. events/791. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/790. 2018-02-13
Neue Aktivität von GRASSI Museum für Angewandte Kunst eingetragen. admin/users/211. projects/114. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/789. 2018-02-13
Akteur hat sich registriert. Name: GRASSI Museum für Angewandte Kunst  . 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/788. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/787. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/786. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/785. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/784. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/783. 2018-02-13
Neue Aktivität von Querbeet Leipzig e.V. eingetragen. admin/users/210. events/782. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/781. 2018-02-13
Neue Aktivität von Querbeet Leipzig e.V. eingetragen. admin/users/210. events/780. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/779. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/778. 2018-02-13
Neue Aktivität von Querbeet Leipzig e.V. eingetragen. admin/users/210. events/777. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/776. 2018-02-13
Neue Aktivität von Zentrum für Fermentation eingetragen. admin/users/202. events/775. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/774. 2018-02-13
Neue Aktivität von Zentrum für Fermentation eingetragen. admin/users/202. events/773. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/772. 2018-02-13
Neue Aktivität von Botanischer garten der Universität Leipzig eingetragen. admin/users/188. events/771. 2018-02-13
Akteur hat sich registriert. Name: Querbeet Leipzig e.V. . 2018-02-13
Neue Aktivität von Notenspur Leipzig e.V. eingetragen. admin/users/209. events/770. 2018-02-12
Akteur hat sich registriert. Name: Notenspur Leipzig e.V. . 2018-02-12
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/769. 2018-02-11
Neue Aktivität von Blütenreich eingetragen. admin/users/208. projects/113. 2018-02-10
Akteur hat sich registriert. Name: Blütenreich . 2018-02-10
Neue Aktivität von Der Lindentaler eingetragen. admin/users/23. projects/112. 2018-02-10
Neue Aktivität von Konzeptwerk Neue Ökonomie eingetragen. admin/users/27. events/768. 2018-02-09
Neue Aktivität von Konzeptwerk Neue Ökonomie eingetragen. admin/users/27. events/767. 2018-02-09
Neue Aktivität von Konzeptwerk Neue Ökonomie eingetragen. admin/users/27. events/766. 2018-02-09
Neue Aktivität von Konzeptwerk Neue Ökonomie eingetragen. admin/users/27. events/765. 2018-02-09
Neue Aktivität von Cafe. Restaurant. Symbiose eingetragen. admin/users/207. stores/318. 2018-02-09
Akteur hat sich registriert. Name: Cafe. Restaurant. Symbiose  . 2018-02-09
Neue Aktivität von Stadt Delitzsch eingetragen. admin/users/205. events/764. 2018-02-08
Akteur hat sich registriert. Name: Stadt Delitzsch  . 2018-02-08
Akteur deaktiviert: Förderverein "Umweltinformationszentrum Leipzig - UiZ" e.V. (Leipzig, Annette Körner) . 2018-02-08
Akteur hat sich registriert. Name: Wilde Leipziger . 2018-02-07
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. action/31. 2018-02-07
Neue Aktivität von Anja Hümmer eingetragen. admin/users/190. events/763. 2018-02-07
Neue Aktivität von Anja Hümmer eingetragen. admin/users/190. events/762. 2018-02-07
Neue Aktivität von Anja Hümmer eingetragen. admin/users/190. events/761. 2018-02-07
Neue Aktivität von Anja Hümmer eingetragen. admin/users/190. events/760. 2018-02-07
Neue Aktivität von Hörspielsommer e.V. eingetragen. admin/users/203. events/759. 2018-02-07
Akteur hat sich registriert. Name: Hörspielsommer e.V.  . 2018-02-07
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/758. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/757. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/756. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/755. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/754. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/753. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/752. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/751. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/750. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/749. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/748. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/747. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/746. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/745. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/744. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/743. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/742. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/741. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. actions/30. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/740. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/739. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/738. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/737. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/736. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/735. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/734. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/733. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/732. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/731. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/730. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/729. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/728. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/727. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/726. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/725. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/724. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/723. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/722. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/721. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/720. 2018-02-06
Akteur hat sich registriert. Name: Zentrum für Fermentation  . 2018-02-06
Neue Aktivität von Vier Fährten  eingetragen. admin/users/176. actions/29. 2018-02-06
Neue Aktivität von Vier Fährten  eingetragen. admin/users/176. events/719. 2018-02-06
Neue Aktivität von Vier Fährten  eingetragen. admin/users/176. actions/28. 2018-02-06
Neue Aktivität von Vier Fährten  eingetragen. admin/users/176. actions/27. 2018-02-06
Neue Aktivität von Vier Fährten  eingetragen. admin/users/176. events/718. 2018-02-06
Neue Aktivität von Vier Fährten  eingetragen. admin/users/176. actions/26. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/717. 2018-02-06
Neue Aktivität von Botanischer Garten Großpösna-Oberholz eingetragen. admin/users/171. events/716. 2018-02-06
Neue Aktivität von Gohliser Verein zur Förderungen Kunst und Kultur eingetragen. admin/users/201. actions/25. 2018-02-06
Neue Aktivität von Gohliser Verein zur Förderungen Kunst und Kultur eingetragen. admin/users/201. events/715. 2018-02-06
Neue Aktivität von Gohliser Verein zur Förderungen Kunst und Kultur eingetragen. admin/users/201. events/714. 2018-02-06
Neue Aktivität von Gohliser Verein zur Förderungen Kunst und Kultur eingetragen. admin/users/201. events/713. 2018-02-06
Neue Aktivität von Gohliser Verein zur Förderungen Kunst und Kultur eingetragen. admin/users/201. events/712. 2018-02-06
Neue Aktivität von Gohliser Verein zur Förderungen Kunst und Kultur eingetragen. admin/users/201. actions/24. 2018-02-06
Akteur hat sich registriert. Name: Gohliser Verein zur Förderungen Kunst und Kultur e.V. . 2018-02-06
Neue Aktivität von Dt. Kleingärtnermuseum eingetragen. admin/users/198. events/711. 2018-02-05
Neue Aktivität von Dt. Kleingärtnermuseum eingetragen. admin/users/198. events/710. 2018-02-05
Neue Aktivität von Dt. Kleingärtnermuseum eingetragen. admin/users/198. events/709. 2018-02-05
Neue Aktivität von Dt. Kleingärtnermuseum eingetragen. admin/users/198. events/708. 2018-02-05
Neue Aktivität von Dt. Kleingärtnermuseum eingetragen. admin/users/198. events/707. 2018-02-05
Neue Aktivität von Dt. Kleingärtnermuseum eingetragen. admin/users/198. events/706. 2018-02-05
Neue Aktivität von Dt. Kleingärtnermuseum eingetragen. admin/users/198. events/705. 2018-02-05
Neue Aktivität von Dt. Kleingärtnermuseum eingetragen. admin/users/198. events/704. 2018-02-05
Neue Aktivität von Dt. Kleingärtnermuseum eingetragen. admin/users/198. projects/110. 2018-02-05
Neue Aktivität von Dt. Kleingärtnermuseum eingetragen. admin/users/198. events/703. 2018-02-05
Neue Aktivität von Dt. Kleingärtnermuseum eingetragen. admin/users/198. events/702. 2018-02-05
Neue Aktivität von Stadtverband Leipzig der Kleingärtner eingetragen. admin/users/200. events/701. 2018-02-05
Neue Aktivität von Dt. Kleingärtnermuseum eingetragen. admin/users/198. events/700. 2018-02-05
Akteur hat sich registriert. Name: Stadtverband Leipzig der Kleingärtner e.V. . 2018-02-05
Neue Aktivität von Michael Schaaf eingetragen. admin/users/199. events/699. 2018-02-05
Neue Aktivität von Dt. Kleingärtnermuseum eingetragen. admin/users/198. events/698. 2018-02-05
Akteur hat sich registriert. Name: Michael Schaaf . 2018-02-05
Neue Aktivität von Dt. Kleingärtnermuseum eingetragen. admin/users/198. projects/109. 2018-02-05
Akteur hat sich registriert. Name: Dt. Kleingärtnermuseum  . 2018-02-05
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/697. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/696. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/695. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/694. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/693. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/692. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/691. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/690. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/689. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/688. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/687. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/686. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/685. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/684. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/683. 2018-02-04
Neue Aktivität von Natur- und Wildnisschule eingetragen. admin/users/186. events/682. 2018-02-04
Neue Aktivität von Natur- und Wildnisschule eingetragen. admin/users/186. events/681. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/680. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/679. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/678. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/677. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/675. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/670. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/669. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/667. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/665. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/663. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/659. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/655. 2018-02-04
Neue Aktivität von erleb-bar eingetragen. admin/users/197. events/650. 2018-02-04
Akteur hat sich registriert. Name: erleb-bar . 2018-02-02
Akteur hat sich registriert. Name: Biomare II GmbH . 2018-02-02
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/649. 2018-02-02
Akteur hat sich registriert. Name: Dirk Scheffler . 2018-02-02
Akteur hat sich registriert. Name: Stadtverband Leipzig der Kleingärtner e.V. . 2018-02-02
Neue Aktivität von Park- und Stadtführerin Daniela Neumann eingetragen. admin/users/193. events/648. 2018-02-01
Akteur hat sich registriert. Name: Park- und Stadtführerin Daniela Neumann . 2018-02-01
Neue Aktivität von Natur- und Wildnisschule eingetragen. admin/users/186. events/647. 2018-02-01
Neue Aktivität von Natur- und Wildnisschule eingetragen. admin/users/186. events/646. 2018-02-01
Neue Aktivität von Natur- und Wildnisschule eingetragen. admin/users/186. events/645. 2018-02-01
Neue Aktivität von Natur- und Wildnisschule eingetragen. admin/users/186. events/644. 2018-02-01
Neue Aktivität von Winter Catherine eingetragen. admin/users/192. events/643. 2018-02-01
Neue Aktivität von Winter Catherine eingetragen. admin/users/192. events/642. 2018-02-01
Neue Aktivität von Winter Catherine eingetragen. admin/users/192. events/641. 2018-02-01
Akteur hat sich registriert. Name: Winter Catherine . 2018-02-01
Akteur hat sich registriert. Name: Fabian Sachsenröder . 2018-02-01
Neue Aktivität von Anja Hümmer eingetragen. admin/users/190. events/640. 2018-02-01
Akteur hat sich registriert. Name: Anja Hümmer . 2018-02-01
Neue Aktivität von Natur- und Wildnisschule eingetragen. admin/users/186. events/639. 2018-02-01
Neue Aktivität von Natur- und Wildnisschule eingetragen. admin/users/186. events/638. 2018-02-01
Neue Aktivität von Natur- und Wildnisschule eingetragen. admin/users/186. events/637. 2018-02-01
Neue Aktivität von Paula Hofmann eingetragen. admin/users/189. events/636. 2018-02-01
Akteur hat sich registriert. Name: Paula Hofmann . 2018-02-01
Akteur hat sich registriert. Name: Botanischer Garten der Universität Leipzig . 2018-02-01
Neue Aktivität von Bürgerverein Sellerhausen-Stünz eingetragen. admin/users/187. events/635. 2018-02-01
Neue Aktivität von Bürgerverein Sellerhausen-Stünz eingetragen. admin/users/187. events/64. 2018-02-01
Neue Aktivität von Verein der Freunde und Förderer des Wildparks eingetragen. admin/users/149. events/633. 2018-02-01
Neue Aktivität von Bürgerverein Sellerhausen-Stünz eingetragen. admin/users/187. events/632. 2018-02-01
Akteur hat sich registriert. Name: Bürgerverein Sellerhausen-Stünz . 2018-02-01
Neue Aktivität von Verein der Freunde und Förderer des Wildparks eingetragen. admin/users/149. events/631. 2018-02-01
Neue Aktivität von Verein der Freunde und Förderer des Wildparks eingetragen. admin/users/149. events/630. 2018-02-01
Neue Aktivität von Verein der Freunde und Förderer des Wildparks eingetragen. admin/users/149. events/629. 2018-02-01
Neue Aktivität von Natur- und Wildnisschule eingetragen. admin/users/186. events/628. 2018-01-31
Neue Aktivität von Natur- und Wildnisschule eingetragen. admin/users/186. events/627. 2018-01-30
Neue Aktivität von Natur- und Wildnisschule eingetragen. admin/users/186. events/626. 2018-01-29
Akteur hat sich registriert. Name: Natur- und Wildnisschule Leipzig GbR  . 2018-01-29
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/625. 2018-01-27
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/624. 2018-01-27
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/623. 2018-01-27
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/622. 2018-01-27
Akteur hat sich registriert. Name: Stadt Leipzig Umweltinformationszentrum . 2018-01-25
Neue Aktivität von Lebendige Luppe eingetragen. admin/users/78. events/621. 2018-01-24
Neue Aktivität von Lebendige Luppe eingetragen. admin/users/78. events/620. 2018-01-24
Neue Aktivität von Lebendige Luppe eingetragen. admin/users/78. events/619. 2018-01-24
Neue Aktivität von Lebendige Luppe eingetragen. admin/users/78. events/618. 2018-01-24
Neue Aktivität von Lebendige Luppe eingetragen. admin/users/78. events/617. 2018-01-24
Neue Aktivität von Fanö-Mode eingetragen. admin/users/178. stores/317. 2018-01-22
Neue Aktivität von Gartenfreunde Süd e.V. eingetragen. admin/users/184. events/616. 2018-01-21
Akteur hat sich registriert. Name: Gartenfreunde Süd e.V. . 2018-01-21
Neue Aktivität von Araki Verlag eingetragen. admin/users/86. actions/23. 2018-01-18
Akteur hat sich registriert. Name: Luise Neugebauer Schmuck . 2018-01-17
Akteur hat sich registriert. Name: Matthias Schmidt . 2018-01-15
Akteur hat sich registriert. Name: Orang-Utans in Not . 2018-01-15
Neue Aktivität von Stefan Härtel eingetragen. admin/users/180. events/615. 2018-01-11
Neue Aktivität von Stefan Härtel eingetragen. admin/users/180. events/614. 2018-01-11
Akteur hat sich registriert. Name: Stefan Härtel . 2018-01-11
Neue Aktivität von Leipzig Grün eingetragen. admin/users/179. events/613. 2018-01-08
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/612. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/611. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/610. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/609. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/608. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/607. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/606. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/605. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/604. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/603. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/602. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/601. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/600. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/599. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/598. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/597. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/596. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/595. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/594. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/593. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/592. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/591. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/590. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/589. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/588. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/587. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/586. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/585. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/584. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/583. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/582. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/581. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/580. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/579. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/578. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/577. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/576. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/575. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/574. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/573. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/572. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/571. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/570. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/569. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/568. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/567. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/566. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/565. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/564. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/563. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/562. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/561. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/560. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/559. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/558. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/557. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/556. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/555. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/554. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/553. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/552. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/551. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/550. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/549. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/548. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/547. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/546. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/545. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/544. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/543. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/542. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/541. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/540. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/539. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/538. 2018-01-05
Akteur hat sich registriert. Name: DGGL Sachsen . 2018-01-05
Neue Aktivität von Fanö-Mode eingetragen. admin/users/178. events/537. 2018-01-05
Neue Aktivität von Vier Fährten eingetragen. Mit Tieren verbunden. admin/users/176. actions/22. 2018-01-05
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/536. 2018-01-05
Akteur deaktiviert: Kollektiv Lastenrad Leipzig (Leipzig, Juliana Klengel) . 2017-12-30
Akteur hat sich registriert. Name: Fanö-Mode . 2017-12-26
Akteur deaktiviert: Sylke Nissen (Leipzig, Sylke Nissen) . 2017-12-22
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/535. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/534. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/533. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/532. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/531. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/530. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/529. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/528. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/527. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/526. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/525. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/524. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/523. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/522. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/521. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/520. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/519. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/518. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/517. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/516. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/515. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/514. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/513. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/512. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/511. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/510. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/509. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/508. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. Kindergruppe Waldgeister. admin/users/73. services/66. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. Kindergruppe BUNDspechte. admin/users/73. services/65. 2017-12-19
Akteur deaktiviert: Kati Magyar (Leipzig, Kati Magyar) . 2017-12-18
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/507. 2017-12-10
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/506. 2017-12-10
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/505. 2017-12-10
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/504. 2017-12-10
Neue Aktivität von Vier Fährten eingetragen. Die Baumkinder im Winter. admin/users/176. actions/21. 2017-12-10
Akteur deaktiviert: Batzentauschring e.V. (Schkeuditz, Jürgen Weidemann) . 2017-11-28
Neue Aktivität von oikos Leipzig e.V. eingetragen. admin/users/21. events/503. 2017-11-13
Neue Aktivität von LUXAA eingetragen. LUXAA. admin/users/177. stores/316. 2017-11-13
Akteur hat sich registriert. Name: LUXAA . 2017-11-13
Akteur deaktiviert: Social Impact Lab (Leipzig, Jennifer Pauli) . 2017-11-10
Akteur deaktiviert: Querbeet (Leipzig, Marius Brauer) . 2017-11-01
Akteur deaktiviert: about source UG (Leipzig, Maria Hunger) . 2017-10-28
Neue Aktivität von BUND Leipzig eingetragen. Grünes Klassenzimmer. admin/users/73. services/64. 2017-10-26
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/502. 2017-10-23
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/501. 2017-10-23
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/500. 2017-10-23
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/499. 2017-10-23
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/498. 2017-10-23
Akteur hat sich registriert. Name: Vier Fährten . 2017-10-15
Akteur deaktiviert: Familienbüro Leipzig (Leipzig, Thomas Kujawa) . 2017-10-14
Neue Aktivität von Freiwilligen-Agentur Leipzig e. V. eingetragen. admin/users/87. events/498. 2017-10-11
Akteur deaktiviert: kunZstoffe – urbane Ideenwerkstatt e.V. (Leipzig, Christin Bauer) . 2017-10-05';
}

// zum Testen
echo displayChanges();


?>
