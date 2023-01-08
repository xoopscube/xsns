<?php
// Based on xoopscodes.php,v 1.1 2007/05/15 02:34:18 minahito Exp $
/*
*  displayes xoopsCode buttons and target textarea to which xoopscodes are inserted
*  $textarea_id is a unique id of the target textarea
*/

function xsns_xoops_code_tarea($textarea_id, $cols = 60, $rows = 5, $suffix = null)
{
    if (version_compare(LEGACY_BASE_VERSION, '2.2', '>=')) {
        $params = array(
            'name' => $textarea_id,
            'class' => 'bbcode',
            'cols' => $cols,
            'rows' => $rows,
            'value' => $GLOBALS[$textarea_id] ?? null,
            'id' => $textarea_id
        );
        $html = '';
        XCube_DelegateUtils::call('Site.TextareaEditor.BBCode.Show', new XCube_Ref($html), $params);
        echo $html;

        return;
    }

    $hiddentext = isset($suffix) ? 'xoopsHiddenText' . trim($suffix) : 'xoopsHiddenText';
    echo "<a name='moresmiley'></a>\n";

    $sizearray = array("xx-small", "x-small", "small", "medium", "large", "x-large", "xx-large");
    echo "<select id='" . $textarea_id . "Size' onchange='setVisible(\"xoopsHiddenText\");setElementSize(\"" . $hiddentext . "\",this.options[this.selectedIndex].value);'>\n";
    echo "<option value='SIZE'>" . _SIZE . "</option>\n";
    foreach ($sizearray as $size) {
        echo "<option value='$size'>$size</option>\n";
    }
    echo "</select>\n";

    $fontarray = array("Arial", "Courier", "Georgia", "Helvetica", "Impact", "Verdana");
    echo "<select id='" . $textarea_id . "Font' onchange='setVisible(\"xoopsHiddenText\");setElementFont(\"" . $hiddentext . "\",this.options[this.selectedIndex].value);'>\n";
    echo "<option value='FONT'>" . _FONT . "</option>\n";
    foreach ($fontarray as $font) {
        echo "<option value='$font'>$font</option>\n";
    }
    echo "</select>\n";

    $colorarray = array("00", "33", "66", "99", "CC", "FF");
    echo "<select id='" . $textarea_id . "Color' onchange='setVisible(\"xoopsHiddenText\");setElementColor(\"" . $hiddentext . "\",this.options[this.selectedIndex].value);'>\n";
    echo "<option value='COLOR'>" . _COLOR . "</option>\n";
    foreach ($colorarray as $color1) {
        foreach ($colorarray as $color2) {
            foreach ($colorarray as $color3) {
                echo "<option value='" . $color1 . $color2 . $color3 . "' style='background-color:#" . $color1 . $color2 . $color3 . ";color:#" . $color1 . $color2 . $color3 . ";'>#" . $color1 . $color2 . $color3 . "</option>\n";
            }
        }
    }
    echo "</select><span id='" . $hiddentext . "'>" . _EXAMPLE . "</span>\n";

    echo "<br>\n";
    //Hack smilies move for bold, italic ...
    $areacontent = isset($GLOBALS[$textarea_id]) ? $GLOBALS[$textarea_id] : '';
    echo "<img src='" . XOOPS_URL . "/images/bold.gif' alt='bold' onmouseover='style.cursor=\"hand\"' onclick='setVisible(\"" . $hiddentext . "\");makeBold(\"" . $hiddentext . "\");'>&nbsp;"
    ."<img src='" . XOOPS_URL . "/images/italic.gif' alt='italic' onmouseover='style.cursor=\"hand\"' onclick='setVisible(\"" . $hiddentext . "\");makeItalic(\"" . $hiddentext . "\");'>&nbsp;"
    ."<img src='" . XOOPS_URL . "/images/underline.gif' alt='underline' onmouseover='style.cursor=\"hand\"' onclick='setVisible(\"" . $hiddentext . "\");makeUnderline(\"" . $hiddentext . "\");'>&nbsp;"
    ."<img src='" . XOOPS_URL . "/images/linethrough.gif' alt='linethrough' onmouseover='style.cursor=\"hand\"' onclick='setVisible(\"" . $hiddentext . "\");makeLineThrough(\"" . $hiddentext . "\");'>&nbsp;"
    ."<input type='text' id='" . $textarea_id . "Addtext' size='20'>&nbsp;"
    ."<input type='button' onclick='xoopsCodeText(\"$textarea_id\", \"" . $hiddentext . "\", \"" . htmlspecialchars(_ENTERTEXTBOX, ENT_QUOTES) . "\")' value='" . _ADD . "'>"
    ."<br><br>"
    ."<textarea id='" . $textarea_id . "' name='" . $textarea_id . "' onselect=\"xoopsSavePosition('" . $textarea_id . "');\" onclick=\"xoopsSavePosition('" . $textarea_id . "');\" onkeyup=\"xoopsSavePosition('" . $textarea_id . "');\" cols='$cols' rows='$rows'>" . $areacontent . "</textarea>"
    ."<br>\n";
    //Fin du hack
}

/*
*  Displays smilies image buttons used to insert smilies codes to a target textarea in a form
* $textarea_id is a unique of the target textarea
*/
function xsns_xoops_smilies($textarea_id)
{
    if (version_compare(LEGACY_BASE_VERSION, '2.2', '>=')) {
        return;
    }

    $ts =& XsnsTextSanitizer::sGetInstance();
    $smiles = $ts->getSmileys();
    if (empty($smiles)) {
        $db =& Database::getInstance();
        if ($result = $db->query('SELECT * FROM ' . $db->prefix('smiles') . ' WHERE display=1')) {
            while ($smile = $db->fetchArray($result)) {
                //hack smilies move for the smilies !!
                echo "<img src='" . XOOPS_UPLOAD_URL . "/" . htmlspecialchars($smile['smile_url']) . "' border='0' onmouseover='style.cursor=\"hand\"' alt='' onclick='xoopsCodeSmilie(\"" . $textarea_id . "\", \" " . $smile['code'] . " \");'>";
                //fin du hack
            }
        }
    } else {
        $count = count($smiles);
        for ($i = 0; $i < $count; $i++) {
            if ($smiles[$i]['display'] == 1) {
                // show smiley
                echo "<img src='" . XOOPS_UPLOAD_URL . "/" . htmlspecialchars($smiles[$i]['smile_url']) . "' border='0' onmouseover='style.cursor=\"hand\"' alt='' onclick='xoopsCodeSmilie(\"" . $textarea_id . "\", \" " . $smiles[$i]['code'] . " \");'>";
            }
        }
    }
    // more
    echo "&nbsp;[<a href='#moresmiley' onmouseover='style.cursor=\"hand\"' alt='' onclick='openWithSelfMain(\"" . XOOPS_URL . "/misc.php?action=showpopups&amp;type=smilies&amp;target=" . $textarea_id . "\",\"smilies\",300,475);'>" . _MORE . "</a>]";
}
