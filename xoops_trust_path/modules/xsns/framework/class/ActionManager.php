<?php

/**
 * Action �����ѥ��饹
 *
 * @package ActionManager
 */
class XsnsActionManager
{
	/**
	 * Ŭ�ڤ�Action��¹Ԥ���
	 * 
	 * @param &$context
	 * @param $target_dir	Action�ե�����Υǥ��쥯�ȥ�̾
	 * @return string		View��̾��
	 */
	public static function dispatch(&$context, $target_dir="")
	{
		// �о�Action�η���
		if(isset($_REQUEST[XSNS_ACTION_ARG])){
			$target = preg_replace("/[^0-9a-zA-Z_]/", "", $_REQUEST[XSNS_ACTION_ARG]);
		}
		else{
			$target = XSNS_DEFAULT_ACTION;
		}
		
		if(!empty($target_dir)){
			$target_dir = $target_dir.'/';
		}
		
		// �о�Action���饹̾���ե�����̾�����
		$actionFile  = XSNS_ACTION_DIR. $target_dir. $target. "Action.php";
		
		// �оݥե������ɤ߹���
		if (is_readable($actionFile) && is_file($actionFile)) {
			require_once($actionFile);
			$actionClass = "Xsns_".ucfirst($target)."_Action";
			// �оݥ��饹���󥹥��󥹺���
			if (class_exists($actionClass)) {
				$o = new $actionClass($context);
				// �оݥ��饹��dispatch�᥽�åɼ¹�
				if (method_exists($o, "dispatch")) {
					return $o->dispatch();
				}
			}
		}
		header('Location: '. XSNS_BASE_URL.'/index.php');
		exit();
	}
}
