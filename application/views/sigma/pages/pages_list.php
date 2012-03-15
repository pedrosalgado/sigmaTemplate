<?php
$this->load->view('sigma/header.php');
$this->load->view('sigma/sidecontent');
?>
<div id="mainCnt" class="adminBody page" style="">

    <div class="adminMain" style="">
        <h2>Páginas</h2>
        <?php echo empty($error) ? '' : $error; ?>

        <ul class="list">
            <?php $i = 0;
            foreach (!empty($pages) ? $pages : array() as $p) { ?>
                <li class="item">
                    <div class="content ">
                        <?php if(!empty($p->raw_name)) { ?>
                        <img src="<?php echo base_url() ?>uploads/<?php echo $p->raw_name . '_thumb' . $p->file_ext ?>" width="75px" height="50px" class="thumb"/>
                        <?php } ?>
                        <h5><?php echo $p->sigma_pages_name ?></h5>
                        
                    </div>
                    
                    <p class="actionBar">
                        <?php
                        echo
                        anchor($urlsuffix . 'pages/edit/' . $p->page_id, 'editar Página', 'class="editBtn" title="editar Ficheiro"') . ' - ' .
                        anchor($urlsuffix . 'pages/del/' . $p->page_id, 'apagar Página', 'class="delBtn" title="apagar Ficheiro"');
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