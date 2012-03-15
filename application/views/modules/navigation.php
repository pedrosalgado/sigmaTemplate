
	<div class="top">
	<a href="" class="eng flag"></a>
	<a href="" class="pt flag"></a>
	</div>
	
	<ul class="nav">
                <li><span class="home"></span><a href="<?php echo base_url(); ?>" class="link_home">Home</a></li>
            <?php foreach($pages as $page) { ?>
                <li><span class="<?php echo $page->url;?>"></span><a href="<?php echo base_url().index_page(); ?>/page/id/<?php echo $page->url;?>" class="link_<?php echo $page->url;?>"> <?php echo $page->sigma_pages_name;?> </a></li>
            <?php } ?>
	</ul>	
	
