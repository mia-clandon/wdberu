<?php
require('top.inc.php');

if (isset($_GET['type']) && $_GET['type'] != '') {
    $type=get_safe_value($con, $_GET['type']);
    if ($type == 'status') {
        $operation=get_safe_value($con, $_GET['operation']);
        $id=get_safe_value($con, $_GET['id']);
        if ($operation == 'active') {
            $status='1';
        } else {
            $status='0';
        }
        $update_status_sql="update product set status='$status' where id='$id'";
        mysqli_query($con, $update_status_sql);
    }

    if ($type == 'delete') {
        $id=get_safe_value($con, $_GET['id']);
        $delete_sql="delete from product where id='$id'";
        mysqli_query($con, $delete_sql);
    }
}

$sql="select product.*,categories.categories, sellers.name_shop from product,categories, sellers where product.categories_id=categories.id and product.seller_id=sellers.id order by product.id desc";
$res=mysqli_query($con, $sql);
?>
    <style>

        .catalog_page {
            padding: 0 5%;
        }

        .catalog_page, .catalog_products {
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
        }

        .catalog_products {
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-content: center;
            border: 1px solid rgba(197, 197, 197, 0.32);
            width: 250px;
            padding: 20px;
        }

        .main_img_product {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-content: center;
        }

        .main_img_product img {
            width: 200px;
        }

        .block_price {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-content: baseline;
        }

        .price {
            color: #202020;
            font-size: 28px;
            text-align: center;
            font-weight: bold;
            font-family: sans-serif;
            margin: 20px 0;
        }

        .old_price {
            text-decoration: line-through;
            font-size: 16px;
            margin-left: 5px;
            color: red;
        }

        .new_price {
            color: #12897C;
        }

        h1 {
            margin: 1%;
            width: 90%;
        }

        span a {
            text-decoration: none;
            color: #202020;
            font-family: Droid Sans, Merriweather, Montserrat;
            font-style: normal;
            font-weight: normal;
            font-size: 18px;
            line-height: 26px;
        }


        .rating {
            color: #12897C;
            padding: 5px;
        }

        .rating span:last-child {
            margin-left: 5px;
        }

        .reviews, .reviews ul {
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            padding: 0;
            margin: 0;
        }

        .reviews ul li {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: baseline;
            padding-left: 5px;
            list-style-type: none;
            text-align: center;
        }

        .reviews ul li span {
            font-family: sans-serif;
            font-size: 18px;
        }

        .buy {
            display: flex;
            flex-direction: row;
            justify-content: center;
            flex-wrap: wrap;
            width: 100%;
        }

        .buy input {
            width: 100%;
            margin-top: 20px;
        }

        .btn_bye {
            background-color: #BD0246;
            color: white;
            border: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
            width: 100%;
            padding: 10px 0;
            border-radius: 8px;
        }

        .btn_bye:hover {
            background-color: #BD0246;
            cursor: pointer;
        }

        .btn_bye_now {
            background-color: white;
            color: #202020;
            border: 3px solid #BD0246;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
            width: 100%;
            padding: 10px 0;
            border-radius: 8px;
            margin-bottom: 50px;
        }

        .btn_bye_now:hover {
            background-color: #BD0246;
            color: white;
            cursor: pointer;
        }

    </style>
    <div class="content pb-0">
        <div class="catalog_products">
            <?php
            $i=1;
            while ($row=mysqli_fetch_assoc($res)) {
                ?>
                <div class="card">
                    <div class="reviews">
                        <ul>
                            <li class="rating"><span>&#9734;</span><span>4.8</span></li>
                        </ul>
                    </div>
                    <div class="main_img_product">
                        <img src="../assets/index/assets/img/orig.jfif" alt="Фото товара">
                    </div>
                    <span class="price"><?php if ($row['status'] == 1) {
                            echo $row['price'];
                        } ?>&nbsp;₽</span>
                    <span>
                                                 <a href="#">
                                               <?php echo $row['name'] ?>
                                                </a>
                    </span>
                    <?php
                    if ($row['status'] == 0) {
                        echo "<span class='badge badge-pending'>Товара нет в наличии</span>&nbsp;";
                    } else {
                        echo "      <div class='buy'>
                        <input type='button' value='Добавить в корзину' class='btn_bye'>
                        <input type='button' value='Купить сейчас' class='btn_bye_now'>
                    </div>";
                    }
                    ?>

                </div>
                <!--                                        <tr>-->
                <!--                                            <td class="serial">--><?php //echo $i++ ?><!--</td>-->
                <!--                                            <td>--><?php //echo $row['article'] ?><!--</td>-->
                <!--                                            <td>--><?php //echo $row['categories'] ?><!--</td>-->
                <!--                                            <td>--><?php //echo $row['name_shop'] ?><!--</td>-->
                <!--                                            <td>--><?php //echo $row['name'] ?><!--</td>-->
                <!--                                            <td>--><?php //echo $row['manufacturer'] ?><!--</td>-->
                <!--                                            <td>--><?php //echo $row['model'] ?><!--</td>-->
                <!--                                            <td>--><?php //echo $row['mrp'] ?><!--</td>-->
                <!--                                            <td>--><?php //echo $row['price'] ?><!--</td>-->
                <!--                                            <td>--><?php //echo $row['qty'] ?><!--<br/>-->
                <!--                                            <td>--><?php //echo $row['short_desc'] ?><!--</td>-->
                <!--                                            <td>--><?php //echo $row['description'] ?><!--</td>-->
                <!--                                            <td>-->
                <!--                                                --><?php
//                                                if ($row['status'] == 1) {
//                                                    echo "<span class='badge badge-pending'><a href='?type=status&operation=deactive&id=" . $row['id'] . "'>Деакт.</a></span>&nbsp;";
//                                                } else {
//                                                    echo "<span class='badge badge-complete'><a href='?type=status&operation=active&id=" . $row['id'] . "'>Актив.</a></span>&nbsp;";
//                                                }
//                                                echo "<span class='badge badge-edit'><a href='manage_product.php?id=" . $row['id'] . "'>Ред.</a></span>&nbsp;";
//
//                                                echo "<span class='badge badge-delete'><a href='?type=delete&id=" . $row['id'] . "'>Удал.</a></span>";
//
//                                                ?>
            <?php } ?>
        </div>
    </div>
<?php
require('footer.inc.php');
?>