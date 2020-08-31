<?PHP
ini_set('memory_limit', '-1');
include '000condb.php';

$getQuery = mysqli_query($conn,"SELECT * FROM `itemurl` WHERE `checked` = 0");

while($row = mysqli_fetch_assoc($getQuery)){

    $dbtitle = "";
    $dbendtime = "";
    $dbimageurl = "";
    $dbsiteurl = "";
    $dbbidprice = "";
    $dbcasktype = "";
    $dbcountry = "";
    $dbregion = "";
    $dbstrength = "";
    $dbcondition = "";
    $dbfill_level = "";
    $n_a = false;


    //Get Product Details
    $url= $row['url'];
    $html=file_get_contents($url);
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);

    //  Get title:
    $title1=$xpath->query("//span[@class='lotName1 line-1']");
    $title2=$xpath->query("//span[@class='lotName2 line-2']");
    $title3=$xpath->query("//span[@class='lotName3 line-3']");
    $title = $title1[0]->textContent."-".$title2[0]->textContent."-".$title3[0]->textContent;
    $dbtitle = $title;
    //echo $dbtitle;

    //Get Endtime:
    $getEndTime=$xpath->query("//span[@class='auction-endtime']");
    $dbendtime = $getEndTime[0]->textContent;
    //echo $dbendtime;

    //Get imageURL:
    $getImage=$xpath->query("//div[@class='product-image-main']/img[@id='productImgMain']");
    $dbimageurl =  $getImage[0]->getAttribute('data-original');
    //print $img_src."\n";

    //Get siteURL:
    $dbsiteurl = $url;

    //Get Winning Bid Price:
    $getBidPrice=$xpath->query("//span[@class='winningBid']");
    $dbbidprice = $getBidPrice[0]->textContent;
    echo $dbbidprice;

    if ($dbbidprice == "£-1"){
        $n_a = true;
    }
    echo $n_a;

    // Get items:
    $getTitle=$xpath->query("//label[@class='waForm-label']");
    $item_counts = $getTitle->length;
    $title = $getTitle[0]->textContent;
    //echo $item_counts;
    //echo $title;

    // Get ProductDescription
    $getContent = $xpath->query("//div[@class='metawrap']/p");
    $node_counts = $getContent->length;
    $details = $getContent[0]->textContent;
    //echo $node_counts;
    //echo $details;

    for ($count = 0; $count < $item_counts; $count++){
        if($getTitle[$count]->textContent == "Cask Type"){
            $dbcasktype = $getContent[$count]->textContent;
            //print $dbcasktype."\n";
        }else if($getTitle[$count]->textContent == "Country"){
            $dbcountry = $getContent[$count]->textContent;
            //print $dbcountry."\n";
        }else if($getTitle[$count]->textContent == "Region"){
            $dbregion = $getContent[$count]->textContent;
            //print $dbregion."\n";
        }else if($getTitle[$count]->textContent == "Strength") {
            $dbstrength = $getContent[$count]->textContent;
            //print $dbstrength."\n";
        }else{

        }
    }
    /***
    // Get ProductDescription
    $getContent = $xpath->query("//p[@itemprop='description']");
    $node_counts = $getContent->length;
    $details = $getContent[0]->textContent;
    //echo $node_counts;
    //echo $details;
     ***/

    //Get product detail condition:
    $getCondiInfo = $xpath->query("//div[@class='product-detail-condition']/h4");
    $item_counts = $getCondiInfo->length;
    $details = $getCondiInfo[0]->textContent;
    //echo $item_counts;
    //echo $details;

    $getCondiFill_Level = $xpath->query("//div[@class='product-detail-condition']/p");
    $item_counts = $getCondiFill_Level->length;
    $details = $getCondiFill_Level[1]->textContent;
    //echo $item_counts;
    //echo $details;

    for ($count = 0; $count < $item_counts; $count++){
        if($getCondiInfo[$count]->textContent == "Condition"){
            $dbcondition = $getCondiFill_Level[$count]->textContent;
            //print $dbcondition."\n";
        }
        if($getCondiInfo[$count]->textContent == "Fill Level"){
            $dbfill_level = $getCondiFill_Level[$count]->textContent;
            //print $dbfill_level."\n";
        }
    }

    //Input the data into DB
    echo $dbtitle, $dbendtime, $dbimageurl, $dbsiteurl, $dbbidprice, $dbcasktype, $dbcountry, $dbregion, $dbstrength, $dbcondition, $dbfill_level;
    if ($n_a == true){
        print "Inputing Skipped! \n";
    }else{
        mysqli_query($conn,"INSERT INTO `aproduct` (`id`, `title`, `endtime`, `imgurl`, `siteurl`, `bidprice`, `casktype`, `country`, `region`, `strength`, `condition`, `filllevel`) VALUES (NULL, '".$dbtitle."', '".$dbendtime."', '".$dbimageurl."', '".$dbsiteurl."', '".$dbbidprice."', '".$dbcasktype."', '".$dbcountry."', '".$dbregion."', '".$dbstrength."', '".$dbcondition."', '".$dbfill_level."');");
        $id = $row['id'];
        mysqli_query($conn,"UPDATE `itemurl` SET `checked` = '1' WHERE `itemurl`.`id` = ".$id.";");
    }

    sleep(0);
}


