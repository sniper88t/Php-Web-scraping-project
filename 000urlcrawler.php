<?PHP
include '000condb.php';


//Get Items From Page

$url="https://whisky.auction/auctions";
$html=file_get_contents($url);
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($html);
$xpath = new DOMXPath($dom);
foreach ($xpath->query("//div[@class='auctionentry-detail']/a/@href") as $href){
    $itemurl = $href->textContent;

    if($itemurl == NULL){

    }else{
        $midurl = "https://whisky.auction".$itemurl;
        insertfulurl($midurl);
        //echo $midurl;
    }
}

sleep(1);

function insertfulurl($urlparam) {
    //connect to MySQL Database
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $db = "paserpast";

    // Create connection
    $conn = new mysqli($hostname, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else{
        echo "DB Connected!";
    }
    /* select db */
    mysqli_select_db($conn, $db);

    //Get Product fulurls
    $url= $urlparam;
    $html=file_get_contents($url);
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);

    $nodelist = $xpath->query("//a[@class='lnkPage']");
    $page_counts = $nodelist->length; // count how many nodes returned
    echo $nodelist[2]->textContent;
    $page_allcount = $nodelist[2]->textContent;

    for ($count = 0; $count < $page_allcount; $count++) {

        $itemurl = $url . "?src=&pageIndex=" . $count . "&pageSize=30&sort=Price&dir=desc&type=&category=&filter=all";
        //echo $itemurl;
        $htmlnode = file_get_contents($itemurl);
        $domnode = new DOMDocument();
        libxml_use_internal_errors(true);
        $domnode->loadHTML($htmlnode);
        $xpath = new DOMXPath($domnode);

        $listprod = $xpath->query("//div[@class='lot-detail']/a/@href");
        $prod_counts = $listprod->length; // count how many nodes returned
        //echo $listprod[0]->textContent;
        echo $prod_counts;
        foreach ($xpath->query("//div[@class='lot-detail']/a/@href") as $href){
            $itemurl = $href->textContent;

            if($itemurl == NULL){

            }else{
                $fullurl = "https://whisky.auction".$itemurl;
                echo $fullurl;
                //insertdata($fullurl);
                mysqli_query($conn,"INSERT INTO `itemurl` (`id`, `url`, `checked`) VALUES (NULL, '".$fullurl."', '0');");
            }
        }
    }
    sleep(1);
}