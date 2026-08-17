<?php

if (!function_exists('debug')) {
    function debug($data)
    {
        echo '<pre>';
        print_r($data);
        die;
    }
}

if (!function_exists('upload_file')) {
    function upload_file($folder, $file)
    {
        $targetDir = PATH_ASSETS_UPLOADS . $folder;
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $cleanName = preg_replace('/[^a-zA-Z0-9._-]/', '', $file["name"]);
        $targetFile = $folder . '/' . time() . '-' . $cleanName;

        if (move_uploaded_file($file["tmp_name"], PATH_ASSETS_UPLOADS . $targetFile)) {
            return $targetFile;
        }

        throw new Exception('Upload file không thành công!');
    }
}

if (!function_exists('upload_multiple_files')) {
    function upload_multiple_files($folder, $files)
    {
        $uploaded = [];
        $targetDir = PATH_ASSETS_UPLOADS . $folder;
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        if (isset($files['name']) && is_array($files['name'])) {
            $count = count($files['name']);
            for ($i = 0; $i < $count; $i++) {
                if (!empty($files['name'][$i]) && ($files['error'][$i] ?? 1) === UPLOAD_ERR_OK) {
                    $cleanName = preg_replace('/[^a-zA-Z0-9._-]/', '', $files['name'][$i]);
                    $uniqueName = time() . '_' . $i . '_' . $cleanName;
                    $targetFile = $folder . '/' . $uniqueName;
                    if (move_uploaded_file($files['tmp_name'][$i], PATH_ASSETS_UPLOADS . $targetFile)) {
                        $uploaded[] = $targetFile;
                    }
                }
            }
        }
        return $uploaded;
    }
}

if (!function_exists('str_slug')) {
    function str_slug($text)
    {
        $text = mb_strtolower($text, 'UTF-8');
        $map = [
            'à'=>'a','á'=>'a','â'=>'a','ã'=>'a','ä'=>'a','å'=>'a',
            'ă'=>'a','ắ'=>'a','ặ'=>'a','ằ'=>'a','ẳ'=>'a','ẵ'=>'a',
            'â'=>'a','ấ'=>'a','ậ'=>'a','ầ'=>'a','ẩ'=>'a','ẫ'=>'a',
            'è'=>'e','é'=>'e','ê'=>'e','ë'=>'e',
            'ề'=>'e','ế'=>'e','ệ'=>'e','ể'=>'e','ễ'=>'e',
            'ì'=>'i','í'=>'i','î'=>'i','ï'=>'i',
            'ò'=>'o','ó'=>'o','ô'=>'o','õ'=>'o','ö'=>'o','ø'=>'o',
            'ồ'=>'o','ố'=>'o','ộ'=>'o','ổ'=>'o','ỗ'=>'o',
            'ơ'=>'o','ờ'=>'o','ớ'=>'o','ợ'=>'o','ở'=>'o','ỡ'=>'o',
            'ù'=>'u','ú'=>'u','û'=>'u','ü'=>'u',
            'ư'=>'u','ừ'=>'u','ứ'=>'u','ự'=>'u','ử'=>'u','ữ'=>'u',
            'ỳ'=>'y','ý'=>'y','ỵ'=>'y','ỷ'=>'y','ỹ'=>'y',
            'đ'=>'d',
            'ñ'=>'n',
        ];
        $text = strtr($text, $map);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', trim($text));
        return $text;
    }
}