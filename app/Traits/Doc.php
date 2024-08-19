<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait Doc
{
    function files_are_equal($docs)
    {

        $file1 = $docs[0];
        $file2 = $docs[1];

        if (Storage::size(public_path('uploads/' . $file1)) !== Storage::size(public_path('uploads/' . $file2))) {
            return false;
        }
        $handle1 = fopen($file1, 'rb');
        $handle2 = fopen($file2, 'rb');
        $result = true;
        while (!feof($handle1)) {
            if (fread($handle1, 8192) !== fread($handle2, 8192)) {
                $result = false;
                break;
            }
        }
        fclose($handle1);
        fclose($handle2);
        return $result;
    }

    function get_similarity($paths)
    {
        $similarity = 0;
        $criteria = ['file_size', 'word_count', 'string_count'];

        foreach ($criteria as $key => $val) {
            if ($paths[0][$val] == $paths[1][$val]) {
                $similarity += (100 / count($criteria));
            }
        }

        return $similarity;
    }
}
