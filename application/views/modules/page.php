<div class="top"><h2>Associação dos Industriais Portugueses de Iluminação</h2></div>

<?php foreach ($content ? $content : array() as $c) { ?>

    <div class="dynamic">
        <h3><?php isset($c->title) ? (strlen($c->title) > 0 ? print_r($c->title) : '') : ''; ?></h3>
        <br>
        <?php if(!empty($c->sigma_files_name)) ?>
            <img src="<?php echo base_url().'uploads/'.$c->raw_name.'_thumb'.$c->file_ext?>" title="<?php echo $c->sigma_files_name ?>" />
        
        <p><?php isset($c->body) ? (strlen($c->body) > 0 ? print_r($c->body) : '') : ''; ?></p>
    </div>	
<?php } ?>
