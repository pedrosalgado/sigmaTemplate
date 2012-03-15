<?php

$this->load->view('sigma/header.php');
$this->load->view('sidecontent');
?>


<div id="mainCnt" class="adminBody" style="">

    <div class="adminMain" style="">
        <h2>Admin</h2>
        <?php $i=0; foreach($resultsArray as $tablename => $results) { ?>
        <div class="tableBox">
        <h3><?php echo $tablename ?></h3>

        <table cellpadding="10" cellspacing="10" width="100%" style="margin-bottom: 20px;border: 1px solid silver">

            <thead style="margin-bottom: 15px;border: 1px solid silver">
                <?php 
                foreach($fields[$tablename] as $value)
                    echo '<th style="">'. $value.'</th>';
                echo '<th style="width:50px;">'.anchor($urlsuffix.$prefixAdd.'/'.$tablename,'add').'</th>';
                echo '<th style="width:50px"></th>';

                ?>
            </thead>

            <tbody>
                <?php
                
                foreach($results as $result) {
                    $id = '';
                    echo '<tr>';
                    foreach ($result as $key => $value) {
                        if($key == 'id') $id = $value;
                        echo '<td>'.(strlen($value) == 0  ? 'vazio' : (strlen($value) > 120  ? 'extenso' : $value)) .'</td>';

                    }
                    echo '<td>'.anchor($urlsuffix.$prefixEdit.'/'.$tablename.'/'.$id,'edit').'</td>';
                    echo '<td>'.anchor($urlsuffix.$prefixDel.'/'.$tablename.'/'.$id,'delete').'</td>';

                    echo '</tr>';
                }

                ?>
            </tbody>
        </table>
        </div>
        <?php $i++;} ?>
    </div>

</div>
<?php
$this->load->view('sigma/footer.php');
?>