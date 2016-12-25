<?php
/**
 * 读目录,只读取目录最外层
 * @param string $path
 */
function readDirectory($path){
    $arr = array();
    //打开指定目录
    $handle = opendir($path);
    //读目录
    while (($item = readdir($handle))!==false){
        //.和..这两个特殊目录
        if ($item!="." && $item!=".."){
            //判断是否是一个文件
            if (is_file($path."/".$item)){
                $arr['file'][] = $item;
            }
            if (is_dir($path."/".$item)){
                $arr['dir'][] = $item;
            }
        }
    }
    closedir($handle);
    return $arr;
}

/**
 * 得到文件夹大小
 * @param string $path
 * @return number
 */
function dirSize($path){
   $sum = 0;
   global $sum;//设为全局变量
   $handle = opendir($path);
   while (($item = readdir($handle)) !== false){
       if ($item != "." && $item != ".."){
           if (is_file($path."/".$item)){
               $sum += filesize($path."/".$item);//得到文件大小
           }
           if (is_dir($path."/".$item)){
               $func=__FUNCTION__;
               $func($path."/".$item);//递归，自己调自己
           }
       }
   }
   closedir($handle);
   return $sum;
}

/**
 *复制文件夹
 * @param unknown $src
 * @param unknown $dst
 * @return string
 */
function copyFolder($src, $dst){
    if (!file_exists($dst)){
        mkdir($dst,0777,true);
    }
    $handle = opendir($src);
    while (($item = readdir($handle))!==false){
        if ($item!='.' && $item != '..'){
            if (is_file($src."/".$item)){
                copy($src."/".$item, $dst."/".$item);
            }
            if (is_dir($src."/".$item)){
                $func = __FUNCTION__;
                $func($src."/".$item,$dst."/".$item);
            }
        }
    }
    closedir($handle);
    return '复制成功';
}
/**
 * 创建文件夹
 * @param string $dirname
 * @return string
 */
function createFolder($dirname){
    //检测文件夹名称的合法性
    if(checkFilename(basename($dirname))){
        //当前目录下是否存在同名文件夹名称
        if(!file_exists($dirname)){
            if(mkdir($dirname,0777,true)){
                $mes="文件夹创建成功";
            }else{
                $mes="文件夹创建失败";
            }
        }else{
            $mes="存在相同文件夹名称";
        }
    }else{
        $mes="非法文件夹名称";
    }
    return $mes;
}
/**
 * 重命名文件夹
 * @param string $oldname
 * @param string $newname
 * @return string
 */
function renameFolder($oldname,$newname){
    //检测文件夹名称的合法性
    if(checkFilename(basename($newname))){
        //检测当前目录下是否存在同名文件夹名称
        if(!file_exists($newname)){
            if(rename($oldname,$newname)){
                $mes="重命名成功";
            }else{
                $mes="重命名失败";
            }
        }else{
            $mes="存在同名文件夹";
        }
    }else{
        $mes="非法文件夹名称";
    }
    return $mes;
}
/**
 * 剪切文件夹
 * @param string $src
 * @param string $dst
 * @return string
 */
function cutFolder($src,$dst){
    //echo $src,"--",$dst;
    if(file_exists($dst)){
        if(is_dir($dst)){
            if(!file_exists($dst."/".basename($src))){
                if(rename($src,$dst."/".basename($src))){
                    $mes="剪切成功";
                }else{
                    $mes="剪切失败";
                }
            }else{
                $mes="存在同名文件夹";
            }
        }else{
            $mes="不是一个文件夹";
        }
    }else{
        $mes="目标文件夹不存在";
    }
    return $mes;
}

/**
 * 删除文件夹
 * @param string $path
 * @return string
 */
function delFolder($path){
    $handle=opendir($path);
    //读文件夹
    while(($item=readdir($handle))!==false){
        if($item!="."&&$item!=".."){
            if(is_file($path."/".$item)){
                unlink($path."/".$item);
            }
            //递归自己调运自己
            if(is_dir($path."/".$item)){
                $func=__FUNCTION__;
                $func($path."/".$item);
            }
        }
    }
    closedir($handle);
    rmdir($path);//删除文件夹
    return "文件夹删除成功";
}

?>

















