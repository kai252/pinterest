<?php
/*
 * author: Jayaseelan Gabriel
* Run: getproductlist.php?userid=ID&boardname=BOARDNAME
*example: http://localhost/<appname>/getproductlist.php?userid=rockey_nebhwani&boardname=value-clocks
*/
require_once 'simple_html_dom.php';

function getTextBetweenTags($string) {
	//"totalPages": 7
	$pattern = "/totalPages\": (\d)/";
	preg_match($pattern, $string, $matches);
	if(count($matches)>0){
		return str_replace('"',"",$matches[0]);
	}
	return '';
}

$id=trim($_GET['id']);
$explodeArray=explode("/", $id);
//print_r($explodeArray);
$userid= $explodeArray[1];
$boardname=$explodeArray[2];
$url = "http://pinterest.com/$userid/$boardname/";
$html = file_get_html($url);
$totalnumberofpage='';
// Check for total number of pages.
foreach($html->find('script') as $e){
	$x=getTextBetweenTags($e);
	if($x!=''){
		$totalnumberofpage=$x;
	}
}
if($totalnumberofpage!=''){
	$arr=explode(":",$totalnumberofpage);
	$totalPages= trim($arr[1]);
}else{
	$totalPages=1;
}

$rs = array();
$productName='';
$productURL='';
$productDomain='';
$productImageURL='';
$data_id='';
$ii=0;
for($i=1;$i<=$totalPages;$i++){
	$url = "http://pinterest.com/$userid/$boardname/?page=".$i;
	$html = file_get_html($url);
	foreach($html->find('div[class=pin]') as $pin){
		$productName=$pin->find('p[class=description]',0)->plaintext;
		$productURL=$pin->find('p[class=NoImage] a',0)->href;
		$productDomain=$pin->find('p[class=NoImage] a',0)->plaintext;
		$productImageURL=$pin->find('img[class=PinImageImg]',0)->src;
		$data_id=$pin->getAttribute('data-id'); 
		//PinImageImg
		$rs[$ii++]=array($productName,$productDomain,$productURL,$productImageURL,$data_id);
	}
}
//header('Content-type: application/json');
//echo json_encode($rs);
//print_r($rs); 
/* $rss = new SimpleXMLElement('http://api-product.skimlinks.com/query?q=url:"http://www.target.com/p/Keurig-V700-Vue-Brewer/-/A-14007156"&key=0108d30aa31f2c12266dc8560193a93b&format=xml', null, true);
echo "<br>----Status:".$rss->status;
echo "<br>----Price :".$rss->products->product->price;
echo "<br>----Merchant: ".$rss->products->product->merchant;
echo "<br>----Merchant ID: ".$rss->products->product->merchantId;
echo "<br>----Product ID: ".$rss->products->product->productId;
echo "<br>----Num Found: " . $rss->numFound;
*/
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Value Clocks</title>
        
        <link rel="icon" href="http://passets-cdn.pinterest.com/images/favicon.png" type="image/x-icon" />
        <link rel="apple-touch-icon-precomposed" href="http://passets-cdn.pinterest.com/images/ipad_touch_icon.png" />
        <link rel="stylesheet" href="http://passets-cdn.pinterest.com/css/pinboard_a38aaafa.css" type="text/css" media="all"/>
        <!--[if (gt IE 6)&(lt IE 9)]><link rel="stylesheet" href="http://passets-cdn.pinterest.com/css/ie7-and-up_83d98ccb.css" type="text/css" media="all" /><![endif]-->
        <script type="text/javascript">var _sf_startpt=(new Date()).getTime()</script>
        <script type="text/javascript">if (!window.console) { window.console = {log: function(){}} };</script>
        <script type="text/javascript">window.repinExperiment = "";</script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="http://passets-cdn.pinterest.com/js/bundle_pin_4d500df1.js" type="text/javascript" charset="utf-8"></script>

    </head>
    
<body>

	

<div id="Header">
    <div class="LiquidContainer HeaderContainer">
        
<a href="/" id="Pinterest"><img src="http://passets-cdn.pinterest.com/images/LogoRed.png" width="100" height="26" alt="Pinterest Logo" /></a>


<ul id="Navigation">
    
    
    <li>
        <a href="/about/" class="nav">About<span></span></a>
        <ul>
            <li><a href="/about/help/">Help</a></li>
            <li class="divider"><a href="/about/terms/">Terms of Service</a></li>
            <li><a href="/about/privacy/">Privacy Policy</a></li>
            <li><a href="/about/copyright/">Copyright</a></li>
            <li><a href="/about/trademark/">Trademark</a></li>
        </ul>
    </li>
    
        <li><a href="#" class="nav LoginNav">Login</a></li>
    
</ul>



 

    </div>
</div>

	

	<div id="wrapper" class="BoardLayout">

	
	    
		    <script type="text/javascript">
    $(document).ready(function() {
        Nag.setup('UnauthCallout');
    });
</script>

		
    

		<div id="BoardTitle">
			<h1 class="serif"><strong>Value Clocks<span id="BoardLikeButton"><fb:like href="http://pinterest.com/rockey_nebhwani/value-clocks/" layout="button_count" show_faces="false" width="90" action="like" font="lucida grande" colorscheme="light"></fb:like></span></strong></h1>
			
			<div id="BoardMeta">
				<div id="BoardUsers">
					
						<a href="#/<?php echo $userid;?>/" class="ImgLink"></a>
						<span id="BoardUserName"><?php echo $userid;?></span>
					
				</div>

				<div id="BoardStats"> <strong>Products</strong></div>

				<div id="BoardButton">
					
				</div>
			</div><!-- #BoardMeta -->

		</div><!-- #BoardTitle -->

		<div id="ColumnContainer" style="margin-top: 16px;">
        <?php 
        foreach ($rs as $r){
       	?>
    
    <div class="pin" data-id="<?php echo $r[4];?>" data-width="600" data-height="800">
        <div class="PinHolder">
            <div class="actions">
                <div class="right">
                    
                </div>
                <div class="left">
                               <a href="#" class="Button Button11 WhiteButton">
                                    <strong><em></em>Add to Alert</strong><span></span>
                                </a>
                </div>
            </div>
            <a href="/pin/<?php echo $r[4];?>/" class="PinImage ImgLink">
                	<img src="<?php echo $r[3];?>" alt="Stylish red clock" class="PinImageImg" style="height: 256px;" />
            </a>
        </div>
        <p class="description"><?php echo $r[0];?></p>
        <p class="stats colorless">
                <span class="RepinsCount">
                1 repin
                &nbsp;&nbsp;</span>
            
        </p>
        <div class="convo attribution clearfix">
                    <p class="NoImage">
                            <a href="<?php echo $r[2];?>" target="_blank" rel="nofollow"><?php echo $r[1];?></a></p>
        </div>
    </div>


    
<?php
 }
 ?>

  
		</div> <!-- #ColumnContainer -->

		<div id="fb-root"></div>

		<!-- Paginator -->
		
			<a class="MoreGrid Button WhiteButton Button18" href="?page=2" style="display:none"><strong>More Pins</strong><span></span></a>
		

		<!-- Infinite scroll loading indicator -->
		
			<div id="LoadingPins"><img src="http://passets-cdn.pinterest.com/images/BouncingLoader.gif" alt="Pin Loader Image" /><span>Fetching pins&hellip;</span></div>
		

	</div><!-- #wrapper.BoardLayout -->

</body>
<script type="text/javascript">

    var board = 56084026548592326;

    BoardLayout.setup();

    $.pageless.settings.complete = function() {
        
            if ($.pageless.settings.currentPage == 10) {
                $(".MoreGrid").css('display', 'block');
            }
        

        BoardLayout.newPins();
    };

    $(document).ready(function() {

        // Show user / collaborator names on :hover
        $('.collaborator').tipsy();

        $('#ColumnContainer').pageless({
            "totalPages": 1,
            "currentPage": 1,
            "loader": "LoadingPins",
            "distance": 3000
        });

        if (50 > 8) {
            $('#LoadingPins').hide();
        }

        

        

        // Prevent click-jacking
        if (top != self) {
            $('body').html('<h1>Unauthorized</h1>')
        }

        
    });

</script>
<script type="text/javascript">
    window.fbAsyncInit = function() {
        FB.init({
            appId: '274266067164',
            status: true,
            cookie: true,
            xfbml: true
        });
    };
    (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
        '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
    } ());
</script>

    <div id="SearchAutocompleteHolder"></div>
    <script type="text/javascript">
    function trackGAEvent(category, action, label, value) {
    _gaq = _gaq || []


        // Event
    _gaq.push(['_trackEvent', category, action, label, value]);

    // Virtual Page
        virtual_page = '_event_';
    virtual_page += "/" + category;

    if(!action) action = '_';
        virtual_page+="/" + action;
    if(label) virtual_page+= "/" + label;

    _gaq.push(['_trackPageview', virtual_page]);

        
    }

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-12967896-1']);
    _gaq.push(['_setCustomVar', 1, 'is_logged_in', 'logged out', 2]);
    _gaq.push(['_setCustomVar', 2, 'page_name', 'board', 1]);

    

    
    
        trackGAEvent('board_view', 'viewed');
        _gaq.push(['_trackPageview', '/board/?name=Value Clocks']);
    

    (function() {
      var ga = document.createElement('script'); ga.type='text/javascript'; ga.async=true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
    })();

</script>


    
<script type="text/javascript">
    var autoLoginFbook = function(response) {
        if (response.status !== 'connected') {
            return;
        }
        var uid = response.authResponse.userID;
        var accessToken = response.authResponse.accessToken;
        $.post("/login/facebook/", {
            access_token: accessToken,
            fb_id: uid},
            function(resp) {
            
                if (resp.status === "success") {
                    window.location.reload()
                }
            
            });
    };
    window.fbAsyncInit = function() {
        FB.init({
            appId: 274266067164,
            cookie: true
        });
        FB.getLoginStatus(autoLoginFbook);
    };
    (function() {
        var e = document.createElement('script');
        e.async = true;
        e.src = document.location.protocol +
        '//connect.facebook.net/en_US/all.js';
        var scriptTag = document.getElementsByTagName('script')[0];
        scriptTag.parentNode.appendChild(e);
    } ());
</script>


</html>