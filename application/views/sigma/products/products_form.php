
<?php
$this->load->view('sigma/header.php');
$this->load->view('sigma/sidecontent');
?>

<div id="mainCnt" class="adminBody" style="">

    <div class="adminMain" style="">
        
        <?php echo empty($error) ? '' : $error; ?>

        <?php
        $obj = null;
        if(!empty($prods) && $edit) { $obj = $prods[0]; }
        echo form_open_multipart($urlsuffix . 'products/'. ($edit ? ('do_edit/'. $obj->prod_id ) : 'do_add'));
        
        echo '<h2 class="left">Produto</h2>'; // TITULO DA PAGINA
        echo form_submit('Submit','Inserir','class="submitProd"'); 
        echo '<br class="clear"/>';
        
        echo form_fieldset('Atributos de Produto');
        echo '<div class="field">';
        echo form_label('nome', 'nome');
        echo form_input('nome', $obj ? $obj->sigma_products_name : '');
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
       
        <?php
        echo form_fieldset('Categorias');
        echo form_label('category', 'title');
        echo '</fieldset>';
        ?>
        
        <?php
        echo form_submit('Submit','Inserir','class="submitProd"');
        echo '</form>';
        ?>

    </div>

</div>

<?php
$this->load->view('sigma/footer.php');
?>