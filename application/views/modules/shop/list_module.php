<ul class="prodModuleList">
    <?php foreach ($prods as $p) { ?>
        <li>
            <div class="prodModuleBox">
                <?php if(!empty($p->raw_name)) { ?>
                <a href="<?php echo base_url().  index_page().'/product/id/'.$p->id ?>" title="<?= $p->title ?>">
                    <img src="<?php echo base_url(). 'uploads/'. $p->raw_name . '_thumb' . $p->file_ext ?>" width="75px" height="50px" alt="<?= $p->title ?>"/>
                </a>
                <?php } ?>
            </div>
        </li>
    <?php } ?>
</ul>	
