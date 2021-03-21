<?php
    $pdo = require_once "database.php";

    $search = $_GET['search'] ?? '';
    if($search) {
        $statement = $pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC');
        $statement->bindValue(':title', "%$search%");
    } else {
        $statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
    }
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    
?>

<?php include_once "views/partials/header.php"; ?>
    <h1>Products CRUD</h1>
    <p>
        <a href="create.php" class="btn btn-success">Create Product</a>
    </p>


    <form action="">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Product search... " name='search' value="<?php echo $search?>">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </div>
    </form>
    

    <table class="table">
        <thead>
            <tr>
            <th scope="col">Index</th>
            <th scope="col">Image</th>
            <th scope="col">Title</th>
            <th scope="col">Price</th>
            <th scope="col">Create Date</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($products as $i=>$product): ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td class="product-img">
                            <img src="<?php echo $product['image']; ?>" alt="" class=''>
                        </td>
                        <td><?php echo $product['title']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $product['create_date']; ?></td>
                        <td>
                            <a href="update.php?id=<?php echo $product['id']; ?>" class="btn btn-info btn-sm">Edit</a>
                            <!-- through get method -->
                            <!-- <a href="delete.php?id=<?php echo $product['id']; ?>" type="button" class="btn btn-danger btn-sm">Delete</a> -->
                            <!-- form is used to send id in a secure way through post method -->
                            <!-- through post method -->
                            <form action="delete.php" method="post" style="display: inline-block;">
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>