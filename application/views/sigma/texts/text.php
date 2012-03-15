
<h2>Textos</h2>
<?php foreach ($texts ? $texts : array() as $p) { ?>
    <div class="textBox">
        <h3><?php isset($p->title) ? (strlen($p->title) > 0 ? print_r($p->title) : 'Titulo Vazio') : 'Sem Titulo'; ?></h3>
        <br>
        <p><?php isset($p->body) ? (strlen($p->body) > 0 ? print_r($p->body) : 'Corpo Vazio') : 'Sem Corpo'; ?></p>
    </div>	
<?php } ?>
