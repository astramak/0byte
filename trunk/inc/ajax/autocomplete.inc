<?php
if (request::get_get('code',0)) { //get autocompletion to code hightliting template
    $array=array("4cs","abap","actionscript","actionscript3","ada","apache","applescript","apt_sources","asm","asp","autohotkey","autoit","avisynth","awk","bash","basic4gl","bf","bibtex","blitzbasic","bnf","boo","c","c_mac","caddcl","cadlisp","cfdg","cfm","cil","clojure","cloocmake","cobol","cpp-qt","cpp","csharp","css","d","dcs","delphi","diff","div","dos","dot","eiffel","email","erlang","fo","fortran","freebasic","fsharp","gambas","gdb","genero","gettext","glsl","gml","gnuplot","groovy","haskell","hq9plus","html4strict","idl","ini","inno","intercal","io","java","java5","javascript","jquery","kixtart","klonec","klonecpp","latex","lisp","locobasic","logtalk","lolcode","lotusformulas","lotusscript","lscript","lsl2","lua","m68k","make","mapbasic","matlab","mirc","modula3","mpasm","mxml","mysql","newlisp","nsis","oberon2","objc","ocaml-brief","ocaml","oobas","oracle11","oracle8","pascal","per","perl","php-brief","php","pic16","pixelbender","plsql","povray","powerbuilder","powershell","progress","prolog","properties","providex","purebasic","python","qbasic","rails","rebol","reg","robots","rsplus","ruby","sas","scala","scheme","scilab","sdlbasic","smalltalk","smarty","sql","systemverilog","tcl","teraterm","text","thinbasic","tsql","typoscript","vb","vbnet","verilog","vhdl","vim","visualfoxpro","visualprolog","whitespace","whois","winbatch","xml","xorg_conf","xpp","z80");
//    $array=get_lang_array();//get templates list
    $array=preg_grep('/^'.request::get_get('query').'/si',$array); //grep needs
    array_splice($array,5);
    $prefix="code";
//} else if (request::get_get('tag')) { //get autocomplete
//    $tag_part=preg_replace("/(.*?),/s", "", $query); //get clean start of new tag
//    $query=str_replace($tag_part, '', $query); //get data before new tag
//    $array=get_tags_array($tag_part,5,$query); //get array of full tag string with variant of completion new tag
//}
}
echo json_encode(array('elements' => $array, 'length' => count($array),'prefix'=>$prefix));//print answer in json
?>