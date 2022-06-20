<html dir="rtl" lang="he">
<head>
  <link rel="stylesheet" href="debug.css" type="text/css">
  <link rel="stylesheet" href="SBLHebrew-webfont.css" type="text/css">
  <link rel="stylesheet" href="EzraSIL-webfont.css" type="text/css">
  <link rel="stylesheet" href="CharisSIL-webfont.css" type="text/css">
  <link rel="stylesheet" href="FHACondensedFrench-webfont.css" type="text/css">
  <link rel="stylesheet" href="Garamond-webfont.css" type="text/css">
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">
</head>
<body>

</br>

<?php
      global     $high_pasuk,$high_url,$high_hebcit,$high_engcit, $sed_cit;
global $keyvalue_index, $hebchap_index, $hebverse_index, $book_index, $bookname_index, $ch_index, $vr_index;
include_once '../show_book.php';
include_once '../show_verse.php';
include_once '../show_sedarim.php';
include_once '../gematria.php';
include_once '../hebrewize.php';
include_once '../random_key.php';
include_once '../show_key.php';
//$k = random_key();
$k = 51980;
//echo "key:".$k."</br>".PHP_EOL;


//works//
$ss=show_fullsedarim($k);
//works//$ss=show_sedarim($k);

////$ss=show_key($k);
//print_r($ss);
//$sedar=show_sedarim($k)[1];
//echo "Sedar:".$ss[0].PHP_EOL;
//

include_once '../all_sedarim_verse.php';

//
/*all_sedarim_verse($ss, $k, false, false, true, false,
         false, true, true, false, false,
         false, false, true);
*/
//echo "kuku".$sed_cit."<br>";
/*all_sedarim_verse($ss, $k, false, true, false, false,
         false, false, false, false, false,
                  false, false, false,false,false,false);
*/
include_once "../button_wrap.php";
//print_r(array( $high_pasuk,$high_url,$high_hebcit,$high_engcit));

//echo "all true</br>";
all_sedarim_verse($ss, $k, true, true, false,false,
                  false, false, false, false, false,
         true, false, false, false, false, false);
button_wrap($high_hebcit,$high_pasuk,$high_url,$high_engcit);
/*
function all_sedarim_verse($verse_stream, $highlight_key=0, $heb_citation=false,  $sedarim_citation=false,$hebcitation_url=false, $key_url=false,
                  $citation_url=false, $comment_display=false, $editor_display=false, $hebrew_display=false, $trans_display=false,
                           $verse_call=false,$key_call=false,$random_call=false,$eng_trans=false,$french_trans=false,$russian_trans=false){

    
*/

?>
</body></html>






