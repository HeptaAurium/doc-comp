<?php

namespace App\Traits;

trait Aspose
{
    public function compareDocs($docs)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.draftable.com/v1/comparisons");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'left.file_type' => pathinfo($docs[0], PATHINFO_EXTENSION),
            'left.file' => public_path('uploads/' . $docs[0]),
            'right.file_type' => pathinfo($docs[1], PATHINFO_EXTENSION),
            'right.file' => public_path('uploads/' . $docs[1]),
            'public' => 'true',
        ]);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Token bd21b4b9c5d960f85b5183bfeb8d853f',
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            dd("Error: " . curl_error($ch));
        } else {
            dd("Comparison result: " . $response);
        }

        // Close the cURL resource
        curl_close($ch);
    }

    public function example($docs)
    {
        $token = 'bd21b4b9c5d960f85b5183bfeb8d853f';
        $account_id = 'Isfxkm-test';

        $opts = [
            "http" => [
                "method" => "POST",
                "header" => "Accept: application/json
" .
                    "Authorization: Token " . $token . "
"
            ],
            "left" => [
                "source" => public_path('uploads/' . $docs[0]),
                "fileType" => pathinfo($docs[0], PATHINFO_EXTENSION)
            ],

            "right" => [
                "source" => public_path('uploads/' . $docs[1]),
                "fileType" => pathinfo($docs[1], PATHINFO_EXTENSION)
            ],

        ];
        $context = stream_context_create($opts);

        // Get a list of all comparisons
        $comparisons = file_get_contents('https://api.draftable.com/v1/comparisons', false, $context);
        dd($comparisons);

        // Create a signed viewer URL which expires next week.
        $valid_until = time() + (7 * 24 * 60 * 60); // Timestamp one week in the future.
        $identifier = 'VctsMUfX'; // Take a specific comparison you want to view.

        $signature = hash_hmac('sha256', '{"account_id":"' . $account_id . '","identifier":"' . $identifier . '","valid_until":' . $valid_until . '}', $token);
        $signed_url =  'https://api.draftable.com/v1/comparisons/viewer/' . $account_id . '/' . $identifier . '?valid_until=' . $valid_until . '&signature=' . $signature;
        echo $signed_url;
    }
}
