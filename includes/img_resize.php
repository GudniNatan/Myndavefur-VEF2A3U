<?php
/**
* Make thumbs from JPEG, PNG, GIF source file
*
* $tmpname = $_FILES['source']['tmp_name'];   
* $size - max width size
* $save_dir - destination folder
* $save_name - tnumb new name
* $maxisheight - is max for width (if not is for height)
*
* Author:  David Taubmann http://www.quidware.com (edited from LEDok - http://www.citadelavto.ru/)
*/

/*/    // And now how using this function fast:
if ($_POST[pic])
    {
    $tmpname  = $_FILES['pic']['tmp_name'];
    @img_resize( $tmpname , 600 , "../album" , "album_".$id.".jpg");
    @img_resize( $tmpname , 120 , "../album" , "album_".$id."_small.jpg");
    @img_resize( $tmpname , 60 , "../album" , "album_".$id."_maxheight.jpg", 1);
    }
    else
    echo "No Images uploaded via POST";
/**/

function img_resize( $tmpname, $size, $save_dir, $save_name, $maxisheight = 0 )
    {
    $save_dir     .= ( substr($save_dir,-1) != "/") ? "/" : "";
    $gis        = getimagesize($tmpname);
    $type        = $gis[2];
    switch($type)
        {
        case "1": $imorig = imagecreatefromgif($tmpname); break;
        case "2": $imorig = imagecreatefromjpeg($tmpname);break;
        case "3": $imorig = imagecreatefrompng($tmpname); break;
        default:  $imorig = imagecreatefromjpeg($tmpname);
        }

        $x = imagesx($imorig);
        $y = imagesy($imorig);
        
        $woh = (!$maxisheight)? $gis[0] : $gis[1] ;    
        
        if($woh <= $size)
        {
        $aw = $x;
        $ah = $y;
        }
            else
        {
            if(!$maxisheight){
                $aw = $size;
                $ah = $size * $y / $x;
            } else {
                $aw = $size * $x / $y;
                $ah = $size;
            }
        }   
        $im = imagecreatetruecolor($aw,$ah);
    if (imagecopyresampled($im,$imorig , 0,0,0,0,$aw,$ah,$x,$y))
        if (imagejpeg($im, $save_dir.$save_name))
            return true;
            else
            return false;
    }
?>