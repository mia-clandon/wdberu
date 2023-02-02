<?php
require('connection.inc.php');
require('functions.inc.php');
if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required='';
    $id=get_safe_value($con, $_GET['id']);
    $res=mysqli_query($con, "select * from product where id='$id'");
    $check=mysqli_num_rows($res);
    if ($check > 0) {
        $row=mysqli_fetch_assoc($res);
        $article=$row['article'];
        $categories_id=$row['categories_id'];
        $seller_id=$row['seller_id'];
        $name=$row['name'];
        $manufacturer=$row['manufacturer'];
        $model=$row['model'];
        $mrp=$row['mrp'];
        $price=$row['price'];
        $qty=$row['qty'];
        $image=$row['image'];
        $short_desc=$row['short_desc'];
        $description=$row['description'];
        $best_seller=$row['best_seller'];
        $meta_title=$row['meta_title'];
        $meta_desc=$row['meta_desc'];
        $meta_keyword=$row['meta_keyword'];
    } else {
        header('location:product.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    echo('Я тут');
//ДОДЕЛАТЬ СИСТЕМУ АРТИКУЛЕЙ
    $article=get_safe_value($con, $_POST['categories_id']);
    $categories_id=get_safe_value($con, $_POST['categories_id']);
    $seller_id=get_safe_value($con, $_POST['seller_id']);
    $name=get_safe_value($con, $_POST['name']);
    $manufacturer=get_safe_value($con, $_POST['manufacturer']);
    $model=get_safe_value($con, $_POST['model']);
    $mrp=get_safe_value($con, $_POST['mrp']);
    $price=get_safe_value($con, $_POST['price']);
    $qty=get_safe_value($con, $_POST['qty']);
    $short_desc=get_safe_value($con, $_POST['short_desc']);
    $description=get_safe_value($con, $_POST['description']);
    $best_seller=get_safe_value($con, $_POST['best_seller']);
    $meta_title=get_safe_value($con, $_POST['meta_title']);
    $meta_desc=get_safe_value($con, $_POST['meta_desc']);
    $meta_keyword=get_safe_value($con, $_POST['meta_keyword']);

    $res=mysqli_query($con, "select * from product where article='$article'");
    if (!$res) {
        die("Невозможно добавить");
    }
    $check=mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $getData=mysqli_fetch_assoc($res);
            if ($id == $getData['id']) {

            } else {
                $msg="Такой товар уже есть";
            }
        } else {
            $msg="Такой товар уже есть";
        }
    }

    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            if ($_FILES['image']['name'] != '') {
                $image=rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image);
                $update_sql="update product set categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',manufacturer='$manufacturer' ,short_desc='$short_desc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword',image='$image',best_seller='$best_seller',sub_categories_id='$sub_categories_id' where id='$id'";
            } else {
                $update_sql="update product set categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',model='$model',short_desc='$short_desc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword',best_seller='$best_seller',sub_categories_id='$sub_categories_id' where id='$id'";
            }
            mysqli_query($con, $update_sql);
        } else {
            $image=rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image);
            mysqli_query($con, "insert into product(article, categories_id, seller_id, name, manufacturer, model, mrp, price, qty, short_desc, description, best_seller, meta_title, meta_desc, meta_keyword)
values('$article', '$categories_id', '$seller_id', '$name', '$manufacturer', '$model', '$mrp', '$price', '$qty', '$short_desc', '$description', '$best_seller', '$meta_title', '$meta_desc', '$meta_keyword')");

        }
        header('location:product.php');
        die();
    }
