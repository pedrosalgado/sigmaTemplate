<?php
$this->load->view('sigma/header.php');
$this->load->view('sigma/sidecontent');
?>


<div id="mainCnt" class="adminBody" style="">

    <div class="adminMain" style="">
        <h3>Your file was successfully uploaded!</h3>

        <ul>
            <?php foreach ($upload_data as $item => $value): ?>
                <li><?php echo $item; ?>: <?php echo $value; ?></li>
            <?php endforeach; ?>
        </ul>

        <p><?php echo anchor($urlsuffix.'upload', 'Upload Another File!'); ?></p>

    </div>

</div>
<?php
$this->load->view('sigma/footer.php');
?>
p>
