<?php

class Xsns_Image_View extends Xsns_Admin_View
{

    function dispatch()
    {
        require XSNS_FRAMEWORK_DIR . '/global.php';
        xoops_cp_header();

        include $mytrustdirpath . '/mymenu.php';

        $image_list = $this->context->getAttribute('image_list');
        $pager = $this->context->getAttribute('pager');

        echo "<h2>" . _AM_XSNS_TITLE_IMAGE_CONFIG . "</h2>";

        if (count($image_list) > 0) {

            $header_list = array(
                _AM_XSNS_IMAGE,
                _AM_XSNS_IMAGE_SIZE,
                _AM_XSNS_POST_DATE,
                _AM_XSNS_IMAGE_AUTHOR,
                _AM_XSNS_IMAGE_REF,
                _AM_XSNS_IMAGE_DELETE,
            );
            $header_count = count($header_list);


            echo '<table class="outer">';
            echo '<form action="index.php" method="post">' .
                '<input type="hidden" name="' . XSNS_ACTION_ARG . '" value="image_del_exec">';

            echo "<colgroup style='width:90px;'></colgroup>" .
                "<colgroup style='width:150px;'></colgroup>" .
                "<colgroup style='width:120px;'></colgroup>" .
                "<colgroup style='text-align:left;'></colgroup>" .
                "<colgroup style='width:40px;'></colgroup>" .
                "<colgroup style='width:40px;'></colgroup>";

            $pager_html = $this->getPageSelector($pager, $header_count);

            echo '<thead><tr>';
            foreach ($header_list as $header) {
                echo '<th>' . $header . '</th>';
            }
            echo '</tr></thead>';

            foreach ($image_list as $image) {
                echo '<tbody><tr style="text-align:center;">' .
                    '<td><a href="' . $image['url'] . '" target="_blank"><img src="' . $image['link'] . '" alt=""></a></td>' .
                    '<td>' . $image['width'] . ' x ' . $image['height'] . '<br><br>' . $image['size'] . ' bytes</td>' .
                    '<td>' . $image['time'] . '</td>' .
                    '<td>' . $image['author'] . '</td>' .
                    '<td>' . $image['ref_link'] . '</td>' .
                    '<td><input type="checkbox" name="delete[]" value="' . $image['id'] . '"></td>' .
                    '</tr></tbody>';
            }
            echo $pager_html;

            $token_handler = new XoopsMultiTokenHandler();
            $token =& $token_handler->create('IMAGE_DELETE');

            echo '<tfoot><tr>' .
                '<td colspan="' . $header_count . '" style="text-align:center; padding:15px 0 15px 0;">' .
                '<input class="ui-button" type="submit" value="' . _SUBMIT . '">' .
                $token->getHtml() .
                '</td>' .
                '</tr></tfoot>';

            echo '</form>';
            echo '</table>';
            echo '</div>';
        } else {

        }

        xoops_cp_footer();
    }

}
