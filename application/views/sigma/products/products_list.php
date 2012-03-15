<?php
$this->load->view('sigma/header.php');
$this->load->view('sigma/sidecontent');
?>
<div id="mainCnt" class="adminBody page" style="">

    <div class="adminMain" style="">
        <h2>Produtos</h2>
        <?php echo empty($error) ? '' : $error; ?>

        <ul class="list">
            <?php $i = 0;
            foreach ($prods ? $prods : array() as $p) { ?>
                <li class="item">
                    <div class="content ">
                        <?php if(!empty($p->raw_name)) { ?>
                        <img src="<?php echo base_url() ?>uploads/<?php echo $p->raw_name . '_thumb' . $p->file_ext ?>" width="75px" height="50px" class="thumb"/>
                        <?php } ?>
                        <h5><?php echo $p->sigma_products_name ?></h5>
                        
                    </div>
                    
                    <p class="actionBar">
                        <?php
                        echo
                        anchor($urlsuffix . 'products/edit/' . $p->prod_id, 'editar Ficheiro', 'class="editBtn" title="editar Ficheiro"') . ' - ' .
                        anchor($urlsuffix . 'products/del/' . $p->prod_id, 'apagar Ficheiro', 'class="delBtn" title="apagar Ficheiro"');
                        ?>
                    </p>
                </li>
            <?php } ?>
        </ul><br class="clear"/>
    </div>

</div>
<?php
$this->load->view('sigma/footer.php');
?>