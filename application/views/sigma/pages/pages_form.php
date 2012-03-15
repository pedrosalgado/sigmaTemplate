
<?php
$this->load->view('sigma/header.php');
$this->load->view('sigma/sidecontent');
?>

<div id="mainCnt" class="adminBody" style="">

    <div class="adminMain" style="">
       
        <?php echo empty($error) ? '' : $error; ?>

        <?php
        $obj = null;
        if(!empty($pages) && $edit) { $obj = $pages[0]; }

        echo form_open_multipart($urlsuffix . 'pages/'. ($edit ? ('do_edit/'. $obj->page_id ) : 'do_add'));
        echo '<h2 class="left">Página</h2>';
        
        echo form_submit('Submit','Inserir','class="submitPage"');
        echo '<br class="clear"/>';
        
        echo form_fieldset('Atributos de Página');
        echo '<div class="field">';
        echo form_label('Nome', 'nome');
        echo form_input('nome', $obj ? $obj->sigma_pages_name : '');
        echo '</div>';
        echo '<div class="field">';
        echo form_label('URL', 'url');
        echo form_input('url', $obj ? $obj->url : '');
        echo '</div>';
        echo '<div class="field">';
        echo form_label('Peso', 'weight');
        echo form_input('weight', $obj ? $obj->weight : '');
        echo '</div>';
        echo '</fieldset>';
        ?>
        
        <?php 
        $data = array('obj' => $obj);
        $this->load->view('sigma/texts/texts_form',$data);
        
        echo '<div id="files"></div>';
        echo '</form>';
        ?>
        
        <?php
        $this->load->view('sigma/upload/upload_mod');
        ?>
        
    </div>

</div>
<?php
$this->load->view('sigma/footer.php');
?>