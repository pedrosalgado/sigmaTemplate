<?php $i=0;
foreach($resultsArray as $tablename => $results) { ?>

<h3><?php echo $tablename ?></h3>
<div class="tableBox">

<table cellpadding="10" cellspacing="10" width="100%" border="3">

    <thead>
            <?php
            foreach($fields[$tablename] as $value)
                echo '<th style="">'. $value.'</th>';
            echo '<th class="actionTH">'.anchor($urlsuffix.$prefixAdd.'/'.$tablename,'adicionar','class="addBtn" title="adicionar"').'</th>';
            echo '<th class="actionTH"></th>';
            //echo '<th class="actionTH"></th>';

    ?>
    </thead>

    <tbody>
            <?php

            foreach($results as $result) {
                $id = '';
                echo '<tr>';
                foreach ($result as $key => $value) {
                    if($key == 'id') {
                        $id = $value;
                        $id_name = $key;
//                            echo '<td>'.anchor($suffix.$prefixConsult.'/'.$tablename.'/'.$value,$value).'</td>';
                    }
                    echo '<td>'.(strlen($value) == 0  ? 'vazio' : (strlen($value) > 120  ? 'extenso' : $value)) .'</td>';

                }
                //echo '<td class="actionTD">'.anchor($urlsuffix.$prefixConsult.'/'.$tablename.'/'.$id,'consultar','class="consultBtn" title="consultar"').'</td>';
                echo '<td class="actionTD">'.anchor($urlsuffix.$prefixEdit.'/'.$tablename.'/'.$id,'editar','class="editBtn" title="editar"').'</td>';
                echo '<td class="actionTD">'.anchor($urlsuffix.$prefixDel.'/'.$tablename.'/'.$id_name.'/'.$id,'apagar','class="delBtn" title="apagar"').'</td>';

                echo '</tr>';
            }

    ?>
    </tbody>
</table>
    </div>
    <?php $i++;
} ?>
