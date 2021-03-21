<?php
    require_once "functions.php";
    $pdo = require_once "database.php";
    
    $errors      = [];
    $title       = '';
    $price       = '';
    $description = '';
    $imagePath   = '';
    $product = [
        'title' =>'',
        'image' => ''
    ];

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title       = $_POST['title'];
        $description = $_POST['description'];
        $price       = $_POST['price'];
        $date        = date('Y-m-d H:i:S');
        
        if(!$title)
            $errors[] = 'Product title is required';
        
        if(!$price)
            $errors[] = 'Product price is required';
        // image uploading part
        if(!is_dir('images')) {
            mkdir('images');
        }



        if(empty($errors)){

            $image = $_FILES['image'] ?? null;
            
            if($image && $image['tmp_name']) {
                $imagePath = 'images/'.randomString(8).'/'.$image['name'];
                mkdir(dirname($imagePath));

                move_uploaded_file($image['tmp_name'], $imagePath);
            }

            // insert data on db when no error found
            $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                    VALUES (:title, :image, :description, :price, :date)");
                    
            $statement->bindValue(':title', $title);    
            $statement->bindValue(':image', $imagePath);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':date', $date);
            $statement->execute(); //this function is must to insert data into database 
            header('Location: index.php');
        }

        // echo '<pre>';
        // var_dump($errors);
        // echo '</pre>';

    }

?>

<?php include_once "views/partials/header.php"; ?>
    <p>
        <a href="index.php" class="btn btn-info">Back to products</a>
    </p>
    <h1>Create new product</h1>
    <?php include_once "views/products/form.php"; ?>
</body>
</html>