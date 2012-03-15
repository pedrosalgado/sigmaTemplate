
<?php
$this->load->view('sigma/header.php');
$this->load->view('sigma/sidecontent');
?>

<div id="mainCnt" class="adminBody" style="">

    <div class="adminMain" style="">
        <h2>Página</h2>
        <?php foreach ($pages ? $pages : array() as $p) { ?>
            <div class="pageBox">
                <h3><?php isset($p->title) ? (strlen($p->title) > 0 ? print_r($p->title) : 'Titulo Vazio') : 'Sem Titulo'; ?></h3>
                <br>
                <p><?php isset($p->body) ? (strlen($p->body) > 0 ? print_r($p->body): 'Corpo Vazio') : 'Sem Corpo'; ?></p>
            </div>	
        <?php } ?>
    </div>

</div>
<?php
$this->load->view('sigma/footer.php');
?>