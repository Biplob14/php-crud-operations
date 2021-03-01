<?php
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=product_crud', 'root', '');
    // if theres any issue with currection will throw error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $errors      = [];
    $title       = '';
    $price       = '';
    $description = '';
    $imagePath   = '';

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

        // create image name from random stringing
        function randomString($n) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $str = '';
            for($i = 0; $i < $n; $i++) {
                $index = mt_rand(0, strlen($characters) - 1); // mt_rand function works 10 times faster than rand
                $str .= $characters[$index];
            }
            return $str;
        }

        if(!$errors) {
            
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Crud</title>
    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- custom css -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Create new product</h1>
    <?php if($errors): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
        <div><?php echo $error; ?></div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <form action="" method="POST" enctype = "multipart/form-data">
        <div class="form-group">
            <label>Product Image:</label><br>
            <input type="file" placeholder="" name="image">
        </div>
        <div class="form-group">
            <label>Product Title</label>
            <input type="text" class="form-control" placeholder="Title of product" name="title" value=<?php print $title; ?>>
        </div>
        <div class="form-group">
            <label>Product Description</label>
            <textarea id="" cols="30" rows="3" class="form-control" placeholder="Describe about product" name="description"><?php echo $description; ?></textarea>
        </div>
        <div class="form-group">
            <label>Product Price</label>
            <input type="number" class="form-control" step=".01" placeholder="The price of product" name="price" value = <?php echo $price; ?>>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>
</html>