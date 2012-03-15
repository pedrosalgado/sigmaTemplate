<?php
$this->load->view('sigma/header.php');
$this->load->view('sigma/sidecontent');
?>

<script type="text/javascript">
    
        function addForm() {
            var s = '<form id="addElem" action="<?php echo base_url().'index.php/'.$urlsuffix.'tables/do_add/'.$table?>" method="post"> <input type="text" name="name"/> <input type="submit" value="Inserir" nam="addBtn"/> </form><br/>';
            
            var OuterDiv = $('#addcol').append(s);
            $('mainCnt').append(OuterDiv);
           
            
        }
        $(document).ready(function() {
            $(".textarea").cleditor();
        })
</script>

<div id="mainCnt" class="adminBody" style="">

    <div id="adminMain" style="">
        <h2>Backoffice - Tables - <?php echo $table?></h2>
        <?php echo $results?>
        <br/>
        <?php echo '<a href="#" onclick="addForm();return false;">Adicionar Coluna</a>' ?>
    </div>
    <div id="addcol"></div>
</div>
<?php
$this->load->view('sigma/footer.php');
?>
