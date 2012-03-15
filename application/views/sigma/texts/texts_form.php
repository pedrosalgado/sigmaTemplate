<?php
if ($obj) :
$t = $obj->title;
$b = $obj->body;
endif;

echo form_fieldset('Texto');
echo '<div class="field">';
echo form_label('Titulo', 'title');
echo form_input('title', !empty($t) ? $t : '');
echo '</div>';

echo '<div class="field">';
echo form_label('Corpo', 'body');
echo form_textarea('body', !empty($b) ? $b : '', 'class="textarea"');
echo '</div>';
echo '</fieldset>';


?>
