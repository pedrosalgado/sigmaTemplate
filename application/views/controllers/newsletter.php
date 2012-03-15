<form id="" action="<?php echo base_url()?>index.php/controllers/newsletter/submit" method="post">
<?php
$output = '';

$output .= form_label('nome');
$output .= form_input('nome').'<br/>';
$output .= form_label('email');
$output .= form_input('email').'<br/>';
$output .= form_submit('btnNL','Subscrever');

echo $output;
?>
</form>
