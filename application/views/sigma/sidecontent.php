
<div id="sideCnt">
    <script type="text/javascript">

        function addElemTable() {
            var s = '<form class="addElemTable" action="<?php echo base_url() . 'index.php/' . $urlsuffix . 'tables/do_addTable' ?>" method="post"> <input type="text" name="name"/> <input type="submit" value="Inserir" nam="addBtn"/> </form><br/>';
            $('#addtable').append(s);
        }
    </script>

    <h2>SideContent</h2>

    <h3 class="actionBar"> 
        <!--<?php echo anchor($urlsuffix . 'indice', 'Backoffice'); ?>-->
        <span> <?php echo anchor('sessions/logout', 'Logout', 'class="logoutBtn"'); ?> </span>
    </h3>
    <div class="moduleBox">
        <h4> Páginas <span></h4>
        <div><ul>
                <li><?php echo anchor($urlsuffix . 'pages/listing', 'List'); ?></li>
                <li><?php echo anchor($urlsuffix . 'pages/add', 'Add'); ?></li>
            </ul></div>
    </div>
    <div class="moduleBox">
        <h4> Produtos </h4>
        <div><ul>
                <li><?php echo anchor($urlsuffix . 'products/listing', 'List'); ?></li>
                <li><?php echo anchor($urlsuffix . 'products/add', 'Add'); ?></li>
            </ul></div>
    </div>
    <div class="moduleBox">
        <h4> Categorias </h4>
        <div id="filesModBox"><ul>
                <!--            <li>Groups</li>-->
                <li><?php echo anchor($urlsuffix . 'categories/listing', 'List'); ?></li>
                <li><?php echo anchor($urlsuffix . 'categories/add', 'Add'); ?></li>

            </ul></div>
    </div>
<!--    <div class="moduleBox">
        <h4> Utilizadores </h4>
        <div><ul>
                <li><?php echo anchor($urlsuffix . 'users/listing', 'List'); ?></li>
                <li><?php echo anchor($urlsuffix . 'users/add', 'Add'); ?></li>
            </ul></div>
    </div>-->
    <div class="moduleBox">
        <h4> Ficheiros </h4>
        <div id="filesModBox"><ul>
                <!--            <li>Groups</li>-->
                <li><?php echo anchor($urlsuffix . 'upload/listing', 'List'); ?></li>
                <li><?php echo anchor($urlsuffix . 'upload', 'Add'); ?></li>

            </ul></div>
    </div>
    <div class="moduleBox">
        <h4> Tabelas </h4>
        <div id="tablesBox">
            <ul class="dbtables">
                <?php
                foreach ($tables ? $tables : array() as $table)
                    echo '<li>' .
                    anchor($urlsuffix . 'tables/index/' . $table, $table) . '<br/><p class="actionBar">' .
                    anchor($urlsuffix . $prefixAdd . '/' . $table, 'adicionar Record', 'class="addBtn" title="adicionar Record"') . ' - ' .
                    anchor($urlsuffix . $prefixEditTable . '/' . $table, 'editar Tabela', 'class="editBtn" title="editar Tabela"') . ' - ' .
                    anchor($urlsuffix . $prefixDelTable . '/' . $table, 'apagar Tabela', 'class="delBtn" title="apagar Tabela"') . '</p></li>'
                    ?>

                <?php echo '<a href="#" onclick="addElemTable();return false;">Adicionar Tabela</a>' ?>

            </ul>
            <div id="addtable"></div>
        </div>
    </div>
</div>