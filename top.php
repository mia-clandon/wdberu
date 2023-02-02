<?php
require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');
$wishlist_count=0;
$cat_res=mysqli_query($con, "select * from categories where status=1 order by categories asc");
$cat_arr=array();
while ($row=mysqli_fetch_assoc($cat_res)) {
    $cat_arr[]=$row;
}

$obj=new add_to_cart();
$totalProduct=$obj->totalProduct();

if (isset($_SESSION['USER_LOGIN'])) {
    $uid=$_SESSION['USER_ID'];

    if (isset($_GET['wishlist_id'])) {
        $wid=get_safe_value($con, $_GET['wishlist_id']);
        mysqli_query($con, "delete from wishlist where id='$wid' and user_id='$uid'");
    }

    $wishlist_count=mysqli_num_rows(mysqli_query($con, "select product.name,product.image,product.price,product.mrp,wishlist.id from product,wishlist where wishlist.product_id=product.id and wishlist.user_id='$uid'"));
}

$script_name=$_SERVER['SCRIPT_NAME'];
$script_name_arr=explode('/', $script_name);
$mypage=$script_name_arr[count($script_name_arr) - 1];

$meta_title="Osma market";
$meta_desc="Osma market";
$meta_keyword="Osma market";
if ($mypage == 'product.php') {
    $product_id=get_safe_value($con, $_GET['id']);
    $product_meta=mysqli_fetch_assoc(mysqli_query($con, "select * from product where id='$product_id'"));
    $meta_title=$product_meta['meta_title'];
    $meta_desc=$product_meta['meta_desc'];
    $meta_keyword=$product_meta['meta_keyword'];
}
if ($mypage == 'contact.php') {
    $meta_title='Contact Us';
}

?>
<!doctype html>
<html class="no-js" lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $meta_title ?></title>
    <meta name="description" content="<?php echo $meta_desc ?>">
    <meta name="keywords" content="<?php echo $meta_keyword ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/index/assets/css/index/index.css">
    <link rel="stylesheet" href="assets/slider/slider.css">
    <link rel="stylesheet" href="assets/index/assets/css/index/modal_windows.css">
    <!--    <link rel="stylesheet" href="assets/custom/multilevel_menu.css">-->
    <link rel="stylesheet" href="assets/index/assets/css/catalog_products.css">
    <script src="assets/index/assets/js/index/modal_windows.js"></script>
<!--    <link rel="stylesheet" href="assets/bootstrap.min.css">-->
    <link
            rel="stylesheet"
            href="https://unpkg.com/swiper/swiper-bundle.min.css"
    />
</head>
<body>
<header>
    <?php
    require('components/chooseCity/choose_city.php');
    ?>
    <?php
    require('components/headerTabs/header_tabs.php');
    ?>
</header>
<?php
require('components/navbar/navbar.php');
?>
<div class="catalog">
    <?php
    require('components/catalogTab/catalog_tab.php');
    ?>
    <ul>
        <li><a href="catalog.php">Одежда и обувь</a></li>
        <li><a href="catalog.php">Товары для дома</a></li>
        <li><a href="catalog.php">Электроника</a></li>
        <li><a href="catalog.php">Детские товары</a></li>
        <li><a href="catalog.php">Новинки</a></li>
        <li><a href="catalog.php">Скидки</a></li>
        <li><a href="catalog.php">%Акции</a></li>
    </ul>
</div>
