<?php

/**
 * View �����ѥ��饹
 *
 * @package ViewManager
 */
class XsnsViewManager
{
    /**
     * Ŭ�ڤ�View��¹Ԥ���
     *
     * @param &$context
     * @param $target_dir    View�ե�����Υǥ��쥯�ȥ�̾
     * @param $target        �оݤ�View̾
     * @return void
     */
    public static function dispatch(&$context, $target_dir = "", $target = "")
    {
        $args = array();
        if (!empty($target_dir)) {
            $args[] = $target_dir;
            $target_dir = $target_dir . '/';
        }

        // �о�View�η���
        if (empty($target)) {
            if (isset($_REQUEST[XSNS_ACTION_ARG])) {
                $target = preg_replace("/[^0-9a-zA-Z_]/", "", $_REQUEST[XSNS_ACTION_ARG]);
                $args[] = $target;
            } else {
                $target = XSNS_DEFAULT_VIEW;
            }
        } else {
            $args[] = $target;
        }

        // �о�View���饹̾���ե�����̾�����
        $viewFile = XSNS_VIEW_DIR . $target_dir . $target . "View.php";

        // �оݥե������ɤ߹���
        if (is_readable($viewFile) && is_file($viewFile)) {
            require_once($viewFile);
            $viewClass = "Xsns_" . ucfirst($target) . "_View";
            // �оݥ��饹���󥹥��󥹺���
            if (class_exists($viewClass)) {
                $o = new $viewClass($context, $args);
                // �оݥ��饹��dispatch�᥽�åɼ¹�
                if (method_exists($o, "dispatch")) {
                    $o->dispatch();
                    return;
                }
            }
        }
        header('Location: ' . XSNS_BASE_URL . '/index.php');
        exit();
    }
}
