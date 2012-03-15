<ul class="prodListFull">
    <?php foreach ($prods as $p) { ?>
        <li>
            <div class="prodBox">
                <?php if(!empty($p->raw_name)) { ?>
                <img class="prodImg" src="<?php echo base_url() ?>uploads/<?php echo $p->raw_name . '_thumb' . $p->file_ext ?>" width="75px" height="50px" alt="<?= $p->title ?>"/>
                <?php } ?>
                <p class="prodTitle"><a href="<?php echo base_url().  index_page().'/product/id/'.$p->sigma_products ?>"><?= $p->title ?></a></p>
                <p class="actionBar"></p>
            </div>
        </li>
    <?php } ?>
</ul>	
<ul class="prodListHalf">
    <?php foreach ($prods as $p) { ?>
        <li>
            <div class="prodBox">
                <?php if(!empty($p->raw_name)) { ?>
                <img class="prodImg" src="<?php echo base_url() ?>uploads/<?php echo $p->raw_name . '_thumb' . $p->file_ext ?>" width="75px" height="50px" alt="<?= $p->title ?>"/>
                <?php } ?>
                <p class="prodTitle"><a href="<?php echo base_url().  index_page().'/product/id/'.$p->sigma_products ?>"><?= $p->title ?></a></p>
                <p class="actionBar"></p>
            </div>
        </li>
    <?php } ?>
</ul>
<ul class="prodListHalf">
    <?php foreach ($prods as $p) { ?>
        <li>
            <div class="prodBox">
                <?php if(!empty($p->raw_name)) { ?>
                <img class="prodImg" src="<?php echo base_url() ?>uploads/<?php echo $p->raw_name . '_thumb' . $p->file_ext ?>" width="75px" height="50px" alt="<?= $p->title ?>"/>
                <?php } ?>
                <p class="prodTitle"><a href="<?php echo base_url().  index_page().'/product/id/'.$p->sigma_products ?>"><?= $p->title ?></a></p>
                <p class="actionBar"></p>
            </div>
        </li>
    <?php } ?>
</ul>
<br style="clear:both" />