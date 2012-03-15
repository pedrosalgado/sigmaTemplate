<?php foreach ($prod as $p) { ?>
<div class="prodBox">
    <h3 class="prodTitle">
        <?= $p->title ?>
    </h3>
    <?php if ($p->raw_name) { ?>
        <img class="prodImg" src="<?php echo base_url() ?>uploads/<?php echo $p->raw_name . '_thumb' . $p->file_ext ?>" width="75px" height="50px"/>
    <?php } ?>
    <p class="prodDesc"><?= $p->body ?></p>
    <p class="actionBar"></p>
</div>
<?php } ?>