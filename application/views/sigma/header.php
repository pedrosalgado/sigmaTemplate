
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8 "  />
        <meta name="author" content="Utilizador" />
        <meta name="description" content="<?php echo $desc ?>" />
        <meta name="keywords" content="<?php echo $keywords ?>" />
        <title>
            <?php echo $title; ?>
        </title>
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>-->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.cleditor.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery.cleditor.css" type="text/css" media="screen" />
        <script src="<?php echo base_url() ?>js/ajaxfileupload.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/sigmacss/reset.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/sigmacss/styles.css" type="text/css" media="screen" />
        <script type="text/javascript">
    
        
            $(document).ready(function() {
                if($(".textarea").length > 0 ) $(".textarea").cleditor();
                if($('#files').length > 0 ) refresh_files();
                if($('#upload_file').length > 0 )                                
                    $('#upload_file').submit(function(e) {
                        e.preventDefault();
                        $.ajaxFileUpload({
                            url         : '<?php echo base_url() . index_page(); ?>/sigma/upload/do_upload_mod',
                            fileElementId  :'userfile',
                            dataType    : 'json',
                            data        : {
                                'title'           : $('#title').val()
                            },
                            success  : function (data, status)
                            {
                                if(data.status != 'error')
                                {
                                    $('#files').html('<p>Reloading files...</p>');
                                    refresh_files();
                                    $('#title').val('');
                                }
                                alert(data.msg);
                            }
                        });
                        return false;
                    });
            })

            function refresh_files()
            {
                $.get('<?php echo base_url() . index_page(); ?>/sigma/upload/listing_mod/<?php echo (!empty($id_item) && !empty($table_name)) ? $table_name . '/' . $id_item : '' ?>')
                .success(function (data){
                    $('#files').html(data);
                });
            }
            jQuery.extend({
                handleError: function(s, xml, status, e) { alert(xml.responseText);}
            });
           
        </script>
    </head>

    <div id="header">
        <h1>&Sigma;9CMS </h1>
    </div>
    <body>
