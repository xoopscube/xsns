/* p2 - ���ѥ쥹�֤�ݥåץ��åפ��뤿���JavaScript */
// isSafari?
// @return  boolean
function isSafari() {
	var ua = navigator.userAgent;
	if (ua.indexOf("Safari") != -1 || ua.indexOf("AppleWebKit") != -1 || ua.indexOf("Konqueror") != -1) {
		return true;
	} else {
		return false;
	}
}

//=============================
// ����
//=============================
cDelayShowSec = 0.1 * 1000;	// �쥹�ݥåץ��åפ�ɽ�������ٱ���֡�
cDelayHideSec = 0.3 * 1000;	// �쥹�ݥåץ��åפ���ɽ���ˤ����ٱ����

//=============================
// �����ѿ�
//=============================
// gPOPS -- ResPopUp ���֥������Ȥ��Ǽ��������
// ���� gPOPS �����ǿ��������������Ƥ��� ResPopUp ���֥������Ȥο��Ȥʤ롣
gPOPS = new Array(); 

gShowTimerIds = new Object();
gHideTimerIds = new Object();

gOnPopSpaceId = null;

zNum = 0;

//=============================
// �����ƥ��å��᥽�å����
//=============================

// ResPopUp ���֥������Ȥ��갷��
var ResPopUpManager = {

	// ���� gPOPS �˿��� ResPopUp ���֥������� ���ɲä���
	// @return  ResPopUp
	addResPopUp: function (popId) {
		zNum++;
		var aResPopUp = new ResPopUp(popId);
		// gPOPS.push(aResPopUp); Array.push ��IE5.5̤��̤�б��ʤΤ����ؽ���
		return gPOPS[gPOPS.length] = aResPopUp;
	},

	// ���� gPOPS ���� ����� ResPopUp ���֥������� ��������
	// @return  boolean
	rmResPopUp: function (popId) {
		for (i = 0; i < gPOPS.length; i++) {
			if (gPOPS[i].popId == popId) {
				gPOPS = arraySplice(gPOPS, i);
				return true;
			}
		}
		return false;
	},

	// ���� gPOPS �ǻ��� popId �� ResPopUp ���֥������Ȥ��֤�
	// @return  ResPopUp|false
	getResPopUp: function (popId) {
		for (i = 0; i < gPOPS.length; i++) {
	    	if (gPOPS[i].popId == popId) {
				return gPOPS[i];
			}
		}
		return false;
	}
}

//=============================
// ���饹���
//=============================

// ���饹 �쥹�ݥåץ��åס�̾���� ResPopup �ˤ�����������[Uu]��
function ResPopUp(popId)
{
	this.popId = popId;
	this.zNum = zNum;
	this.hideTimerID = 0;
	
	// IE��
	if (document.all) {
		this.popOBJ = document.all[this.popId];
	// DOM�б��ѡ�Mozilla��
	} else if (document.getElementById) {
		this.popOBJ = document.getElementById(this.popId);
	}
}

ResPopUp.prototype = {
	
	// �쥹�ݥåץ��åפΰ��֤򥻥åȤ���
	// @return  void
	setPosResPopUp: function (x, y)
	{
		var x_adjust = 10;	// x������Ĵ��
		var y_adjust = -68;	// y������Ĵ��
	
		if (document.all) { // IE��
			var body = (document.compatMode=='CSS1Compat') ? document.documentElement : document.body;
			//x = body.scrollLeft + event.clientX; // ���ߤΥޥ������֤�X��ɸ
			//y = body.scrollTop + event.clientY; // ���ߤΥޥ������֤�Y��ɸ
			this.popOBJ.style.pixelLeft  = x + x_adjust; //�ݥåץ��åװ���
			this.popOBJ.style.pixelTop  = y + y_adjust;
		
			if (this.popOBJ.offsetTop + this.popOBJ.offsetHeight > body.scrollTop + body.clientHeight) {
				this.popOBJ.style.pixelTop = body.scrollTop + body.clientHeight - this.popOBJ.offsetHeight -20;
			}
			if (this.popOBJ.offsetTop < body.scrollTop) {
				this.popOBJ.style.pixelTop = body.scrollTop -2;
			}
		
		} else if (document.getElementById) { // DOM�б��ѡ�Mozilla��
			//x = ev.pageX; // ���ߤΥޥ������֤�X��ɸ
			//y = ev.pageY; // ���ߤΥޥ������֤�Y��ɸ
			this.popOBJ.style.left = x + x_adjust + "px"; //�ݥåץ��åװ���
			this.popOBJ.style.top = y + y_adjust + "px";
		
			if ((this.popOBJ.offsetTop + this.popOBJ.offsetHeight) > (window.pageYOffset + window.innerHeight)) {
				this.popOBJ.style.top = window.pageYOffset + window.innerHeight - this.popOBJ.offsetHeight -20 + "px";
			}
			if (this.popOBJ.offsetTop < window.pageYOffset) {
				this.popOBJ.style.top = window.pageYOffset -2 + "px";
			}
		}
	},

	// �쥹�ݥåץ��åפ�ɽ������
	// @return  void
	showResPopUp: function (x, y)
	{
		if (this.popOBJ == null || this.popOBJ.style.visibility == "visible") {
			return;
		}
	
		this.popOBJ.style.zIndex = this.zNum;
		this.setPosResPopUp(x, y);
	
		this.opacity = 1;
		
		this.popOBJ.style.visibility = "visible"; // �쥹�ݥåץ��å�ɽ��
		this.popOBJ.onmouseout = function () {
			hideResPopUp(this.id)
		}
	},

	// �쥹�ݥåץ��åפ���ɽ�������ޡ�����
	// @return  void
	hideResPopUp: function ()
	{
		// �������ɽ��������ä�
		this.hideTimerID = setTimeout("doHideResPopUp('" + this.popId + "')", cDelayHideSec);
	},

	// �쥹�ݥåץ��åפ���ɽ���ˤ��� �����Ԥ�
	// @return  void
	doHideResPopUp: function ()
	{
		for (i = 0; i < gPOPS.length; i++) {
			// ��ʬ���ɽ����̤ι⤤�Τ�����С��ä��Τ��ٱ䤹��
			if (this.zNum < gPOPS[i].zNum) {
				// �������ɽ��������ä�
				this.hideTimerID = setTimeout("hideResPopUp('" + this.popId + "')", cDelayHideSec);
				return;
			}
		}
		this.nowHideResPopUp();
	},

	// �쥹�ݥåץ��åפ���ɽ���ˤ��� ¨
	// @return  void
	nowHideResPopUp: function ()
	{
		delete gHideTimerIds[this.popId];
		if(this.popOBJ != null){
			this.popOBJ.style.visibility = "hidden"; // �쥹�ݥåץ��å���ɽ��
		}
		ResPopUpManager.rmResPopUp(this.popId);
	}
}

//=============================
// �ؿ����
//=============================
/**
 * arraySplice
 *
 * anArray.splice(i, 1); Array.splice ��IE5.5̤��̤�б��ʤΤ����ؽ���
 * @return array
 */
function arraySplice(anArray, i)
{
	var newArray = new Array();
	
	for (j = 0; j < anArray.length; j++) {
		if (j != i) {
			newArray[newArray.length] = anArray[j];
		}
	}
	return newArray;
}

/**
 * �쥹�ݥåץ��åפ�ɽ�������ޡ�����
 *
 * ���ѥ쥹�֤� onMouseover �ǸƤӽФ����
 * [memo] ��������event���֥������Ȥˤ��������褤��������
 *
 * @param  boolean  onPopSpace  �ݥåץ��åץ��ڡ����ؤ�onmouseover�ǤθƤӽФ��ʤ顣��ʣ�ƤӽФ�����Τ��ᡣ
 */
function showResPopUp(popId, ev, onPopSpace)
{
	if (popId.indexOf("-") != -1) { return; } // Ϣ�� (>>1-100) �����б��ʤΤ�ȴ����
	
	if (document.all) { // IE��
		var body = (document.compatMode=='CSS1Compat') ? document.documentElement : document.body;
		var x = body.scrollLeft + event.clientX; // ���ߤΥޥ������֤�X��ɸ
		var y = body.scrollTop + event.clientY; // ���ߤΥޥ������֤�Y��ɸ
	} else if (document.getElementById) { // DOM�б��ѡ�Mozilla��
		var x = ev.pageX; // ���ߤΥޥ������֤�X��ɸ
		var y = ev.pageY; // ���ߤΥޥ������֤�Y��ɸ
	} else {
		return;
	}
	
	if(gPOPS.length == 0){
		zNum = 0;
	}
	
	var aResPopUp = ResPopUpManager.getResPopUp(popId);
	if (aResPopUp) {
		delete gHideTimerIds[popId];
		if (aResPopUp.hideTimerID) { clearTimeout(aResPopUp.hideTimerID); } // ��ɽ�������ޡ�����

		if (onPopSpace) {
			if (gOnPopSpaceId == popId) {
				return;
			} else {
				gOnPopSpaceId = popId;
			}
		}
		
		// ��ɽ������ zIndex ����
		if (aResPopUp.zNum < zNum) {
			aResPopUp.zNum = ++zNum;
			aResPopUp.popOBJ.style.zIndex = aResPopUp.zNum;
		}
		
		if (!onPopSpace) {
			// Safari�ǤϹ�®�ǥޥ��������С����ޥ��������Ȥ�ȯ�����ƥޥ����ˤĤ��Ƥ��Ƥ��ޤ��ʷ��ʻ��ͤ���
			if (!isSafari()) {
				aResPopUp.setPosResPopUp(x,y);
			}
		}
		
		return;
	}
	
	// doShowResPopUp(popId, ev);
	
	aShowTimer = new Object();
	aShowTimer.x = x;
	aShowTimer.y = y;
	
	// ������֤�����ɽ������
	aShowTimer.timerID = setTimeout("doShowResPopUp('" + popId + "')", cDelayShowSec);
	
	gShowTimerIds[popId] = aShowTimer;
}

/**
 * �쥹�ݥåץ��åפ�ɽ������
 */
function doShowResPopUp(popId)
{
	var x = gShowTimerIds[popId].x;
	var y = gShowTimerIds[popId].y;
	
	var aResPopUp = ResPopUpManager.getResPopUp(popId);
	if (aResPopUp) {
		if (aResPopUp.hideTimerID) { clearTimeout(aResPopUp.hideTimerID); } // ��ɽ�������ޡ�����
		return;
	}
	
	aResPopUp = ResPopUpManager.addResPopUp(popId); // �������ݥåץ��åפ��ɲ�

	aResPopUp.showResPopUp(x, y);
}

/**
 * �쥹�ݥåץ��åפ���ɽ�������ޡ�����
 *
 * ���ѥ쥹�֤��� onMouseout �ǸƤӽФ����
 */
function hideResPopUp(popId)
{
	if (popId.indexOf("-") != -1) { return; } // Ϣ�� (>>1-100) �����б��ʤΤ�ȴ����
	
	if (gShowTimerIds[popId].timerID) { clearTimeout(gShowTimerIds[popId].timerID); } // ɽ�������ޡ�����
	
	var aResPopUp = ResPopUpManager.getResPopUp(popId);
	if (aResPopUp) {
		aResPopUp.hideResPopUp();
	}
}

/**
 * �쥹�ݥåץ��åפ���ɽ���ˤ���
 */
function doHideResPopUp(popId)
{
	var aResPopUp = ResPopUpManager.getResPopUp(popId);
	if (aResPopUp) {
		aResPopUp.doHideResPopUp();
	}
}

/**
 * �쥹��񤯡ʥƥ����ȥ��ꥢ�˰��ѥ����ɤ�������
 */
function Xsns_addResCode(res_id)
{
	var tarea_id = 'body';
	var tarea = null;
	
	if (document.all) {
		tarea = document.all[tarea_id];
	}
	else if (document.getElementById) {
		tarea = document.getElementById(tarea_id);
	}
	else if ((navigator.appname.indexOf("Netscape") != -1) && parseInt(navigator.appversion == 4)) {
		tarea = document.layers[tarea_id];
	}
	else{
		return false;
	}
	
	tarea.value = tarea.value + "[res]" + res_id + "[/res] ";
	tarea.focus();
	return true;
}
