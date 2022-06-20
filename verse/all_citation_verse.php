<?php
//gets  citation string, returns hebcit,fulltext,url_output,engcit

include_once "get_citated_verse.php";
include_once "show_verse.php";
include_once "hebrewize.php";
include_once "shorteng_bookcode.php";
include_once "db_chapter.php";
include_once 'fix_peh_samach.php';


function all_citation_verse($osis) {
    //   global $url_output, $hebcit, $engcit, $fulltext, $highlight;
    //    global $quotedverse;
    global $highlight;
    $home_url = "https://hatanach.geulah.org.il/verse/citation.php";
    $output_1 = '<a target = ' . "'_self'" . ' href="';
    $output_2 = '"/>';
    $output_3 = "</a>";
    echo "<p debug='all_citation_verse called:";    print_r($osis);    echo "'></p>";
    $error = (strpos($osis, "EEE") > 0); // echo "Error identified";
    $range = (strpos($osis, "-") > 0); // echo "range identified";
    $multiple = (strpos($osis, ",") > 0); // echo "multiple requests identified";
    if ($error) {
        echo "<p debug='error identified'> </p>";
    } else {
        if ($multiple) {
            //recursive !
            echo "<p debug='multiple identified'> </p>";
            $pieces = explode(",", $osis);
            $m_hebcit = "";
            $m_pasuk = "";
            $m_url = "";
            $m_engcit = "";
            foreach ($pieces as $i => $v) {
                $i > 0;
                echo "<p debug=m: ".$i . ' ' . $v . ' ></p>';
                list($m1_hebcit, $m1_pasuk, $m1_url, $m1_engcit) = all_citation_verse($v);
                $m_hebcit = $m_hebcit . $m1_hebcit;
                $m_pasuk = $m_pasuk . $m1_pasuk;
                $m_url = $m_url . $m1_url;
                $m_engcit = $m_engcit . $m1_engcit;
            }
            //$quotedverse = $quotedverse. $m_pasuk;
            //echo "<p debug='multiple verse quotedverse:'>".$m_pasuk." ".$m_engcit." ".$quotedverse." </p>";
            return array(
                $m_hebcit,
                $m_pasuk,
                $m_url,
                $m_engcit
            );
        } else {
            if ($range) {
                echo "<p debug='range identified'> </p>";
                //definition of range has two parts show from start "-" finish
                $pieces = explode("-", $osis);
                if (count($pieces) == 2) { //a range that has 2 values a start and end
                    list($startbook, $startchapter, $startverse) = explode(".", $pieces[0]);
                    list($endbook, $endchapter, $endverse) = explode(".", $pieces[1]);
                    if ($startbook <> $endbook) {
                        echo "range unknown diffrent books";
                    } else {
                        $book = shorteng_bookcode($startbook);
                    }
                    /* get answer and loop it*/
                    include_once 'get_multi_citated_verses.php';
                    include_once 'convert_cit_key.php';
                    include_once 'show_book.php';
                    $stream = get_multi_citated_verses($book, $startchapter, $endchapter, $startverse, $endverse);
                    $streamengcit = show_book($book, 1) . $startchapter . ":" . $startverse . "-" . $endchapter . ":" . $endverse;
                    $streamhebcit = '(' . show_book($book, 2) . " " . number2hebrew($startchapter) . ":" . number2hebrew($startverse) . "-" . number2hebrew($endchapter) . ":" . number2hebrew($endverse) . ')';
                    echo '<h2><p dir="rtl" lang="he" class="source-text-area-title">' . $streamhebcit . "</p></h2>";
                    $streamverse = "";
                    for ($c_index = 0;$c_index < count($stream);$c_index++) {
                        $number_of_verses_in_chapter = $stream[$c_index][0];
                        for ($v_index = 1;$v_index <= $number_of_verses_in_chapter;$v_index++) {
                            $verse_answer = $stream[$c_index][$v_index];
                            list($book, $chapter_number, $verse_number, $fulltext, $key_number) = array(
                                $verse_answer['book'],
                                $verse_answer['ch'],
                                $verse_answer['vr'],
                                $verse_answer['verse'],
                                $verse_answer['id']
                            );
                            $fulltext=fix_peh_samach($fulltext);
                            $engcit = "(" . show_book($book, 1) . $chapter_number . ":" . $verse_number . ")";
                            $hebcit = '(' . hebrewize($book, $chapter_number, $verse_number) . ')';
                            $url_output = $home_url . '?verse=' . show_book($book, 1) . $chapter_number . ':' . $verse_number;
                            $url = '<h2><p dir="rtl" lang="he" class="source-text-area">' . $output_1 . $url_output . $output_2 . $hebcit . $output_3 . $fulltext . "</p></h2>";
                            echo $url . PHP_EOL;
                            $streamverse = $streamverse . $fulltext;
                        }
                        // next chapter echo PHP_EOL."----------------------".PHP_EOL;
                    }
                    $url_output = $home_url . '?verse=' . $streamengcit;
                    $engcit = '(' . $streamengcit . ')';
                    $hebcit = $streamhebcit;
                    //$quotedverse = $quotedverse. $streamverse;
                    //echo "<p debug='range verse quotedverse:'>".$streamverse." ".$streamengcit." ".$quotedverse." </p>";
                    return array(
                        $streamhebcit,
                        $streamverse,
                        ($home_url . '?verse=' . $streamengcit) ,
                        ('(' . $streamengcit . ')')
                    );
                    /* end of get answer and loop it */
                } else {
                    echo "range unknown " . count($pieces) . PHP_EOL;
                    print_r($pieces);
                }
            } else {
                $pieces = explode(".", $osis);
                switch (count($pieces)) {
                    case 3:
                        list($book, $chapter_number, $verse_number) = $pieces;
                        //echo "bcv identified";
                        $book_code = shorteng_bookcode($book);
                    break;
                    case 2:
                        list($book, $chapter_number) = $pieces;
                        //echo "bc identified";
                        $verse_number = 0;
                        $book_code = shorteng_bookcode($book);
                    break;
                    case 1:
                        list($book) = $pieces;
                        $verse_number = 0;
                        $chapter_number = 0;
                        //echo "b identified";
                        $book_code = shorteng_bookcode($book);
                    break;
                    default:
                        echo "Error: " . count($pieces);
                }
                //Bug in Obad as it is a single chapter book
                if  ($book_code == 31) $chapter_number = 1;
                $entire_chapter = ((($verse_number == "0") | (strlen($verse_number) == 0)) & (!(($chapter_number == "0") | (strlen($chapter_number) == 0))));
               
                if ($entire_chapter) {
                    echo "<p debug='entire_chapter identified'> </p>";
                    //chapter heading
                    echo '<h2><p dir="rtl" lang="he" class="source-text-area-title">(' . hebrewize($book_code, $chapter_number, 0) . ')</p></h2>';
                    $engcit = "(" . $book . $chapter_number . ")";
                    $hebcit = '(' . hebrewize($book_code, $chapter_number, 0) . ')';
                    $fulltext = "";
                    $url_output = $home_url . '?verse=' . $book . $chapter_number . '&highlight=' . $highlight;
                    $url = '<h2><p dir="rtl" lang="he" class="source-text-area">' . $output_1 . $url_output . $output_2 . $hebcit . $output_3 . "</p></h2>";
                    $loop = db_chapter($book_code, $chapter_number);
                    for ($x = 1;$x <= $loop;$x++) {
                        // echo "book:". $book_code. " c:".  $chapter_number. " v:". $x;
                        $value = get_citated_verse($book_code, $chapter_number, $x) [1];
                        if ($highlight == $value[2]) { //some check which remembers which verse should be higlighted even with chapter request
                            echo '<h2><p dir="rtl" lang="he" class="source-text-highlighted-area">(' . number2hebrew($value[2]) . ')' . $value[3] . "</p></h2>" . PHP_EOL;
                        } else {
                            echo '<h2><p dir="rtl" lang="he" class="source-text-area">(' . number2hebrew($value[2]) . ')' . $value[3] . "</p></h2>" . PHP_EOL;
                        }
                        $fulltext = $fulltext . $value[3];
                    }
                    //$quotedverse = $quotedverse.$fulltext;
                    //echo "<p debug='chapter verse quotedverse:'>".$fulltext." ".$engcit." ".$quotedverse." </p>";
                    return array(
                        $hebcit,
                        $fulltext,
                        $url_output,
                        $engcit
                    );
                } else if (!(($verse_number == "0") | (strlen($verse_number) == 0))) {
                    echo "<p debug='single verse identified'> </p>";
                    $value = get_citated_verse($book_code, $chapter_number, $verse_number) [1];
                    $engcit = "(" . $book . $chapter_number . ":" . $verse_number . ")";
                    $hebcit = '(' . hebrewize($value[0], $value[1], $value[2]) . ')';
                    $fulltext = $value[3];
                    $url_output = $home_url . '?verse=' . $book . $chapter_number . ':' . $verse_number;
                    $url = '<h2><p dir="rtl" lang="he" class="source-text-area">' . $output_1 . $url_output . $output_2 . $hebcit . $output_3 . $fulltext . "</p></h2>";
                    echo $url . PHP_EOL;
                    //$quotedverse = $quotedverse . $fulltext;
                    //echo "<p debug='single verse quotedverse:'>".$fulltext." ".$engcit." ".$quotedverse." </p>";
                    return array(
                        $hebcit,
                        $fulltext,
                        $url_output,
                        $engcit
                    );
                } else {
                    if (($chapter_number == "0") | (strlen($chapter_number) == 0)) {
                        //full book or empty request will be ignored
                        echo "empty or full book request ignored";
                    }
                }
            }
        }
    }
}


