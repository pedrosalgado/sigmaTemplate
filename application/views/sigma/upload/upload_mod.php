
<form method="post" action="" id="upload_file" class="form">
    <?php
    echo form_fieldset('Ficheiros');
    echo '<div class="field">';
    echo form_label('Titulo', 'title');
    echo form_input('title','','id=title');
    echo '</div>';
    echo '<div class="field">';
    echo form_label('Ficheiro', 'ficheiro');
    ?>
    <input type="file" name="userfile" id="userfile" size="20" />
</div>
<input type="submit" name="submit" id="submit" />
</fieldset>
</form>

