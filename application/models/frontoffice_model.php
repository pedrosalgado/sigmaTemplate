<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of news_model
 *
 * @author Cego
 */
class Frontoffice_model extends CI_Model {
   
    function __construct() {
        parent::__construct();
    }

    function getPages() {
       
        $query = $this->db->get('sigma_pages');
        return $query->num_rows() > 0 ? $query->result() : false;
    }

    function getNews() {
        $this->db->orderby('id desc');
        $query = $this->db->get('soma_posts');
        $i = 0;
        if ($query->num_rows() > 0) {
            $output = '';
            foreach ($query->result() as $function_info) {
                $output .=
                        '
                   <div class="noticia">
                        <h3 class="titulo">' . $function_info->titulo . '<span class="date">data:' . $function_info->data . '</span></h3>
                        <h4 class="subtitulo">' . $function_info->subtitulo . '</h4>
                        <p class="body">' . $function_info->body . '</p>
                        <p class="actionsBar">
                        <a href="comentarios/index/' . $function_info->id . '">[Comentários]</a>
                        </p>
                    </div>
                
                </li>';
            }
            $output .= '</ul>';
            return $output;
        } else {
            return '<p>Sorry, no results returned.</p>';
        }
    }

    function getOneNews($id) {
        $this->db->orderby('id');
        $this->db->where('id', $id);
        $query = $this->db->get('soma_posts');
        if ($query->num_rows() > 0) {
            $output = '<ul class="newsList">';
            $i = 0;
            foreach ($query->result() as $function_info) {
                $output .=
                        '<li class="newsItem">
                    <div class="singleNews">
                        <h3 class="newsTitle hidden">' . $function_info->title . '</h3>
                        <p class="date hidden">' . $function_info->modified . '</p>
                        <img title="' . $function_info->title . '" align="top" src="' . base_url() . 'images/uploads/' . $function_info->imagepath . '" class="imgTitle" />
                        <p class="newsBody">' . $function_info->body . '</p>
                        <p class="actionsBar">
                        
                        </p>
                    </div>
                </li>';
            }
            $output .= '</ul>';
            return $output;
        } else {
            return '<p>Sorry, no results returned.</p>';
        }
    }

    function getCommentsCount($id) {
        $this->db->where('idsoma_posts', $id);
        $query = $this->db->get('soma_comments');
        return $query->num_rows();
    }

    function getComments($id) {

        $this->db->orderby('idsoma_comments');
        $this->db->where('idsoma_posts', $id);
        $query = $this->db->get('soma_comments');

        if ($query->num_rows() > 0) {
            $output = '<ul class="commentsList">';
            foreach ($query->result() as $function_info) {
                $output .=
                        '<li class="commentsItem">
                            <div class="singleComment">
                                <h4 class="commentTitle">Título: ' . $function_info->title . '</h4>
                                <h5 class="commentAuthor">Autor: ' . $function_info->author . '</h5>
                                <p class="newsBody">Comentário: ' . $function_info->body . '</p>
                            </div>
                        </li>';
            }
            $output .= '</ul>';

            $output .='
                    <div class="commentsForm" id="commentsForm0">
                    <h3>Adicionar Comentário</h3>
                        <form class="commentForm" name="commentForm" action="' . base_url() . 'index.php/posts/commentSave/' . $id . '" method="post">
                        <p><label for="author">Autor</label><input type="text" name="author" /></p><br/>
                        <p><label for="title">Título</label><input type="text" name="title" /></p><br/>
                        <label for="body">Comentário</label><textarea name="body" value="" ></textarea>
                    <br style="clear:both"/>';
            $output .= recaptcha();

            $output .= '<br style="clear:both"/>
                    <input type="submit" class="btnSubmit" style="margin-top:5px"/>
                    <br style="clear:both"/>
                    </form>
                </div>';
            return $output;
        } else {
            $output = '<p>Sem Comentários</p>';
            $output .='
                    <div class="commentsForm" id="commentsForm0">
                    <h3>Adicionar Comentário</h3>
                        <form class="commentForm" name="commentForm" action="' . base_url() . 'index.php/posts/commentSave/' . $id . '" method="post">
                        <p><label for="author">Autor</label><input type="text" name="author" /></p><br/>
                        <p><label for="title">Título</label><input type="text" name="title" /></p><br/>
                        <label for="body">Comentário</label><textarea name="body" value="" ></textarea>
                    <br style="clear:both"/>';
            $output .= recaptcha();

            $output .= '<br style="clear:both"/>
                    <input type="submit" class="btnSubmit" style="margin-top:5px"/>
                    <br style="clear:both"/>
                    </form>
                </div>';
            return $output;
        }
    }

    function commentSave($id, $post) {
        $this->db->set('id', $id);
        $this->db->insert('soma_comentarios', $post);
    }

    function setNewsLetter($post) {
        $this->db->set();
        $this->db->insert('soma_newsletter', $post);
    }

    public function getTextos($codigo) {
        $this->db->where('nome', $codigo);
        $query = $this->db->get('sigma_pages');
        foreach ($query->result() as $function_info) {
            $this->db->where('sigma_pages', $function_info->id);
        }
        $query = $this->db->get('textos');
        return $query->num_rows() > 0 ? $query->result() : false;
    }

}

?>
