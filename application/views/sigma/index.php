<?php
$this->load->view('sigma/header.php');
$this->load->view('sigma/sidecontent');

?>



<div id="mainCnt" class="adminBody" style="">

    <div class="adminMain" style="">
        <h2>Backoffice</h2>
        <?php $this->load->view('controllers/tabelas');?>

    </div>

</div>

<?php
$this->load->view('sigma/footer.php');
?>