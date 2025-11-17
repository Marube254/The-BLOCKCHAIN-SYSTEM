<?php
// Updated avatar generator using DiceBear v3 API
// Make sure the folder "public/candidate-photos" exists before running this

$folder = __DIR__ . '/public/candidate-photos/';
if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

for ($i = 1; $i <= 20; $i++) {
    // ✅ New DiceBear API endpoint
    $url = "https://api.dicebear.com/7.x/thumbs/png?seed=candidate{$i}";
    $file = $folder . "candidate{$i}.png";

    echo "Downloading: candidate{$i}.png ... ";

    $image = file_get_contents($url);
    if ($image !== false) {
        file_put_contents($file, $image);
        echo "Done!\n";
    } else {
        echo "Failed!\n";
    }
}

echo "✅ All avatars generated successfully!\n";
