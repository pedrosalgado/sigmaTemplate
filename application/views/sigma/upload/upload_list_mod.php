<?php echo form_fieldset('Mediateca'); ?>
<ul class="fileList left">
    <?php $i = 0;
    foreach ($files ? $files : array() as $file) { ?>
        <li class="fileItem left">
            <div class="fileContent ">
                <?php if(!empty($file->raw_name)) { ?>
                <img src="<?php echo base_url() ?>uploads/<?php echo $file->raw_name . '_thumb' . $file->file_ext ?>" width="75px" height="50px" class="thumb"/>
                <?php } ?>
                <h5><?php echo $file->sigma_files_name ?></h5>
            </div>
            <p class="actionBar left">
                <?php
                $data = array('name' => 'checkbox' . $i++, 'value' => $file->id);
                foreach(!empty($text_files) ? $text_files : array() as $tf) {
                    $tf->sigma_files == $file->id ? $data['checked'] = TRUE : $data['checked'] = FALSE ;
                }
                
                echo
                anchor($urlsuffix . 'upload/edit/' . $file->id, 'editar Ficheiro', 'class="editBtn" title="editar Ficheiro"') . ' - ' .
                anchor($urlsuffix . 'upload/del/' . $file->id, 'apagar Ficheiro', 'class="delBtn" title="apagar Ficheiro"') . ' - ' .
                form_checkbox($data)
                ?>
            </p>
        </li><br class="clear"/>
    <?php } ?>
</ul><br class="clear"/>
</fieldset>

