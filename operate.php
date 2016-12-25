<?php
function showContent($filename,$redirect){
//查看文件内容
    $content = file_get_contents($filename);
    //echo "<textArea cols = '100' rows = '10'>{$content}</textArea>";
    //高亮显示php代码
    //高亮显示字符串中的php代码
    if (strlen($content)){
    $newContent = highlight_string($content,true);
    //高亮显示文件中的php代码
    //highlight_file($filename);
    $str=<<<EOF
    <table width='100%' bgcolor="pink" cellpadding='5' cellspacing='0'>
        <tr>
        <td>{$newContent}</td>
        </tr>
    </table>
EOF;
    echo $str;
    }else {
        alertMes('文件内容为空，请编辑在查看', $redirect);
    }
}

/**
 * 编辑文件内容
 * @param unknown $filename
 */
function editContent($filename){
    $content = file_get_contents($filename);
    $str=<<<EOF
    <form action="index.php?act=doEdit" method = 'post'>
        <textarea name='content' cols='190' rows='10'>{$content}</textarea><br />
        <input type="hidden" name = 'filename' value='{$filename}' />
        <input type="submit" value="修改文件内容"/>
    </form>
EOF;
    echo $str;
}

/**
 * 修改文件内容
 * @param unknown $content
 */
function doEdit($content,$filename,$redirect){
    //写入文件
    if (file_put_contents($filename,$content)){
        $mes = '文件修改成功';
    }else {
        $mes = '文件修改失败';
    }
    alertMes($mes, $redirect);
}

function renameFile($filename){
    $str=<<<EOF
    <form action="index.php?act=doRename" method='post'>
        请填写新文件名:<input type="text" name="newname" placeholder="重命名"/>
        <input type="hidden" name='filename' value='{$filename}' />
        <input type="submit" value="重命名"/>
    </form>
EOF;
    echo $str;
}

function copyFolders($path,$dirname){
    $str=<<<EOF
	<form action="index.php?act=doCopyFolder" method="post">
	将文件夹复制到：<input type="text" name="dstname" placeholder="将文件夹复制到"/>
	<input type="hidden" name="path" value="{$path}" />
	<input type='hidden' name='dirname' value='{$dirname}' />
	<input type="submit" value="复制文件夹"/>
	</form>
EOF;
    echo $str;
}

function renamedir($path,$dirname){
    $folder = basename($dirname);
    $str=<<<EOF
			<form action="index.php?act=doRenameFolder" method="post">
	请填写新文件夹名称:<input type="text" name="newname" placeholder="重命名" value="{$folder}"/>
	<input type="hidden" name="path" value="{$path}" />
	<input type='hidden' name='dirname' value='{$dirname}' />
	<input type="submit" value="重命名"/>
	</form>
EOF;
    echo $str;
}

function cutDir($path,$dirname){
    $str=<<<EOF
	<form action="index.php?act=doCutFolder" method="post">
	将文件夹剪切到：<input type="text" name="dstname" placeholder="将文件剪切到"/>
	<input type="hidden" name="path" value="{$path}" />
	<input type='hidden' name='dirname' value='{$dirname}' />
	<input type="submit" value="剪切文件夹"/>
	</form>
EOF;
    echo $str;
}

function cutfiles($path,$filename){
    $str=<<<EOF
	<form action="index.php?act=doCutFile" method="post">
	将文件剪切到：<input type="text" name="dstname" placeholder="将文件剪切到"/>
	<input type="hidden" name="path" value="{$path}" />
	<input type='hidden' name='filename' value='{$filename}' />
	<input type="submit" value="剪切文件"/>
	</form>
EOF;
    echo $str;
}

function copFile($path,$filename){
    $str=<<<EOF
	<form action="index.php?act=doCopyFile" method="post">
	将文件复制到：<input type="text" name="dstname" placeholder="将文件复制到"/>
	<input type="hidden" name="path" value="{$path}" />
	<input type='hidden' name='filename' value='{$filename}' />
	<input type="submit" value="复制文件"/>
	</form>
EOF;
    echo $str;
}
?>