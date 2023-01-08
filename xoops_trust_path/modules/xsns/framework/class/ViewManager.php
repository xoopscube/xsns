<?php

/**
 * View Admin class
 *
 * @package ViewManager
 */
class XsnsViewManager
{
    /**
     * Run the appropriate View
     *
     * @param &$context
     * @param $target_dir    // View file directory name
     * @param $target        // Target View name
     * @return void
     */
    public static function dispatch(&$context, $target_dir = "", $target = "")
    {
        $args = array();
        if (!empty($target_dir)) {
            $args[] = $target_dir;
            $target_dir = $target_dir . '/';
        }

        // Determine the target view
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

        // Determine the target View class name and file name
        $viewFile = XSNS_VIEW_DIR . $target_dir . $target . "View.php";

        // Read the target file
        if (is_readable($viewFile) && is_file($viewFile)) {
            require_once($viewFile);
            $viewClass = "Xsns_" . ucfirst($target) . "_View";
            // Create target class instance
            if (class_exists($viewClass)) {
                $o = new $viewClass($context, $args);
                // Execute dispatch method of target class
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
