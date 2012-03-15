<?php
$this->load->view('sigma/header.php');
$this->load->view('sigma/sidecontent');
?>
<div id="mainCnt" class="adminBody" style="">

    <div class="adminMain" style="">
        <?php $this->load->view('sigma/upload/upload_list_mod'); ?>

    </div>

</div>
<?php
$this->load->view('sigma/footer.php');
?>