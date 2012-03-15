<?php
$this->load->view('sigma/header.php');
$this->load->view('sigma/sidecontent');
?>
<div id="mainCnt" class="adminBody" style="">

    <div class="adminMain" style="">
        <h2>Ficheiros</h2>
        <?php echo empty($error) ? '' : $error; ?>

        <?php $this->load->view('sigma/upload/upload_mod'); ?>
    </div>

</div>
<?php
$this->load->view('sigma/footer.php');
?>