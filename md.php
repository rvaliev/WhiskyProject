<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);


/*header('Content-Type: text/html; charset=utf-8');
ini_set('default_charset', 'UTF-8');
mb_internal_encoding("UTF-8");*/

?>

<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>





<?php


$word = "КАЖДОМУСВОЕ";
$sentenceLength = mb_strlen($word, 'UTF-8');
//echo strlen($word);
//echo mb_substr($word, 2, 1, 'utf-8');

//echo mb_internal_encoding();


$abc[1] = "А";
$abc[2] = "Б";
$abc[3] = "В";
$abc[4] = "Г";
$abc[5] = "Д";
$abc[6] = "Е";
$abc[7] = "Ё";
$abc[8] = "Ж";
$abc[9] = "З";
$abc[10] = "И";
$abc[11] = "Й";
$abc[12] = "К";
$abc[13] = "Л";
$abc[14] = "М";
$abc[15] = "Н";
$abc[16] = "О";
$abc[17] = "П";
$abc[18] = "Р";
$abc[19] = "С";
$abc[20] = "Т";
$abc[21] = "У";
$abc[22] = "Ф";
$abc[23] = "Х";
$abc[24] = "Ц";
$abc[25] = "Ч";
$abc[26] = "Ш";
$abc[27] = "Щ";
$abc[28] = "Ъ";
$abc[29] = "Ы";
$abc[30] = "Ь";
$abc[31] = "Э";
$abc[32] = "Ю";
$abc[33] = "Я";

for($i = 0; $i <= $sentenceLength; $i++)
{
    if(in_array(mb_substr($word, $i, 1, 'utf-8'), $abc))
    {
//        echo array_flip($abc)[mb_substr($word, $i, 1, 'utf-8')] . "<br>";
        $encryptedNumber = array_flip($abc)[mb_substr($word, $i, 1, 'utf-8')] - $sentenceLength;

        if ($encryptedNumber < 0)
        {
            $letter = mb_strtolower($abc[abs($encryptedNumber)], 'utf-8');
            echo "-" . $letter . " ";
        }
        else if ($encryptedNumber > 0)
        {
            $letter = mb_strtolower($abc[abs($encryptedNumber)], 'utf-8');
            echo $letter  . " ";
        }
        else
        {
            echo $abc[$encryptedNumber + $sentenceLength] . " ";
        }
    }
}




?>


</body>
</html>


