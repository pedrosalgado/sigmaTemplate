<?php
$this->load->view('sigma/header.php');
$this->load->view('sigma/sidecontent');
?>

<div id="mainCnt" class="adminBody" style="">

    <div id="adminMain" style="">
        <h2>Backoffice - Records</h2>
        <?php echo $results?>

       
    </div>

</div>
<?php
$this->load->view('sigma/footer.php');
?>
