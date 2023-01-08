<?php

class Xsns_Access_View extends Xsns_Admin_View
{
    function dispatch()
    {
        require XSNS_FRAMEWORK_DIR . '/global.php';
        xoops_cp_header();

        include $mytrustdirpath . '/mymenu.php';

        echo '<h2>' . _AM_XSNS_TITLE_ACCESS_LOG . '</h2>';

        echo '<div layout="row center-justify" class="control-action">
                <div class="control-view">
                <a href="#" class="ui-btn ui-btn-small"><{$smarty.const._EDIT}></a>
                <a href="#category_access" class="ui-btn ui-btn-small">CATEGORY PERMISSIONS</a>
                <a href="#makecategory" class="ui-btn ui-btn-small">MAKE</a>
                <a href="#makecontent>" class="ui-btn ui-btn-small">MAKE CONTENT</a>
                <a href="#" class="ui-btn ui-btn-small">CATEGORY INDEX</a>
                <button class="help-admin ui-btn" type="button" data-module="xsns" data-help-article="#help-version" title="Help">
                <span class="ui-icon ui-icon-help"></span>
                </button>
                </div>
             </div>';

        $access_log = $this->context->getAttribute('access_log');

        if (count($access_log) > 0) {

            $pager = $this->context->getAttribute('pager');


            echo '<table class="outer">';

            $header_list = array(
                _AM_XSNS_ACCESS_DATE,
                _AM_XSNS_ACCESS_COMMU,
                _AM_XSNS_ACCESS_USER,
            );
            $header_count = count($header_list);

            $pager_html = $this->getPageSelector($pager, $header_count);

            echo $pager_html;

            echo '<thead><tr>';
            foreach ($header_list as $header) {
                echo '<th>' . $header . '</th>';
            }
            echo '</tr></thead>';

            echo "<colgroup style='text-align:center; width:20%;'></colgroup>" .
                "<colgroup span='2' style='text-align:left; width:35%;'></colgroup>";

            foreach ($access_log as $access) {
                echo '<tr class="even">' .
                    '<td>' . date('Y-m-d H:i:s', $access['time']) . '</td>' .
                    '<td><a href="index.php?' . XSNS_ACTION_ARG . '=access&cid=' . $access['commu_id'] . '">' . $access['commu_name'] . '</a></td>' .
                    '<td><a href="index.php?' . XSNS_ACTION_ARG . '=access&uid=' . $access['member_id'] . '">' . $access['member_name'] . '</a></td>' .
                    '</tr>';
            }
            echo $pager_html;

            echo '</table>';
//            echo '</div>';
        }

        xoops_cp_footer();
    }

}
