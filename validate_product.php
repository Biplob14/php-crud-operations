<?php
    $title = $product['title'];
    $description = $product['description'];
    $price = $product['price'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
    
        $image = $_FILES['image'] ?? null;
        $imagePath = '';
    
        if (!is_dir('images')) {
            mkdir('images');
        }
    
        if ($image && $image['tmp_name']) {
            if ($product['image']) {
                unlink($product['image']);
            }
            $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
        }