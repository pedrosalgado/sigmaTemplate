
<head>
	<meta charset="utf-8" />
	<title>AIPI</title>
	<link rel="StyleSheet" href="<?php echo base_url(); ?>css/reset.css" >
	<link rel="StyleSheet" href="<?php echo base_url(); ?>css/style.css" >
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	

	<script type="text/javascript" >
	/*var scrollSpeed = 600;
	var scrollEffect = "easeInOutExpo";
		
		$(document).ready(function() {
			var offset = $('#wrapper ').offset();
			$('html,body').animate({
				scrollTop: offset.top,
				scrollLeft: offset.left,				
		}, scrollSpeed, scrollEffect); 	
		});*/

		$(document).ready(function() {
    
                    resetBG();
                    
//                    $(".nav li a").slideToggle(300);
                    $("#loginForm").slideToggle(300);
                    
//                    $("span.home").click(function (e) {
//                        $(".link_home").slideToggle(300);
//                    });
//                    <?php if(count($pages) > 0) { ?>
//                        <?php foreach($pages as $page) { ?>
//                            $("span.<?php echo $page->url;?>").click(function (e) {
//                                $(".link_<?php echo $page->url;?>").slideToggle(300);
//                            });
//                        <?php } ?>
//                    
//                    <?php } else { ?> 
//                        $(".nav").append("<li><span onclick='history.back();'> <center><strong> < </strong></center> </span></li>");
//                    <?php } ?>
                    
		});
                
                function resetBG() {
                    var w = $(document).width();
                    var h = $(document).height();
                    $(".background").css('width',w);
                    $(".background").css('height',h);
                }
                function showLogin() {
                    $("#loginForm").slideToggle(800);
                }
	</script>

</head>