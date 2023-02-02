<?php
require('top.inc.php');

if (isset($_GET['type']) && $_GET['type'] != '') {
    $type=get_safe_value($con, $_GET['type']);
    if ($type == 'unload_json') {
        $data=array(); // в этот массив запишем то, что выберем из базы
        $data_products=array(); // в этот массив запишем то, что выберем из базы
        $product=array(); // в этот массив запишем то, что выберем из базы
        $ta=mysqli_query($con, 'SELECT pick_list.id, pick_list.name_list FROM `pick_list` where status="1" order by id asc');
        while ($row=mysqli_fetch_assoc($ta)) { // оформим каждую строку результата
            // как ассоциативный массив
            $rowId = intval($row['id']);
            $array_products=mysqli_query($con, "SELECT picks_products.pick_list_id, pick_list.name_list, product.id, product.name, product.price, product.image, product.article FROM `picks_products`, `pick_list`, `product` WHERE pick_list.id = $rowId and picks_products.pick_list_id = pick_list.id and picks_products.product_id = product.id
"); // сделаем запрос в БД
            while ($row_products=mysqli_fetch_assoc($array_products)) {
                echo($row_products);
                for ($i=0; $i < count($row_products); $i++) {
                    $product['id']=$row_products['id'];
                    $product['article']=$row_products['article'];
                    $product['name']=$row_products['name'];
                    $product['price']=$row_products['price'];
                    $product['image']=$row_products['image'];
                }
                array_push($data_products, $product);
            }
            $row['products']=$data_products;
            $data[]=$row; // допишем строку из выборки как новый элемент результирующего массива
        }
//        echo json_encode($data);
        file_put_contents('D:\test\test.json', json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    if ($type == 'status') {
        $operation=get_safe_value($con, $_GET['operation']);
        $id=get_safe_value($con, $_GET['id']);
        if ($operation == 'active') {
            $status='1';
        } else {
            $status='0';
        }
        $update_status_sql="update pick_list set status='$status' where id='$id'";
        mysqli_query($con, $update_status_sql);
    }

    if ($type == 'delete') {
        $id=get_safe_value($con, $_GET['id']);
        $delete_sql="delete from pick_list where id='$id'";
        mysqli_query($con, $delete_sql);
    }
}

//SELECT picks_products.pick_list_id, pick_list.id, pick_list.name_list, product.id, product.name, product.price, product.image, product.article FROM `picks_products`, `pick_list`, `product` WHERE picks_products.pick_list_id = pick_list.id and picks_products.product_id = product.id


$sql="select * from pick_list order by id asc";


$res=mysqli_query($con, $sql);
?>
    <div class="content pb-0">
        <div class="orders">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="box-title">Подборки товаров</h4>
                            <h4 class="box-link"><a href="manage_pick_list.php">Добавить подборки</a></h4>
                            <?php echo "<h4 class='box-link'><a
                                        href='?type=unload_json'>Выгрузить на сайт</a></h4>"; ?>
                        </div>
                        <div class="card-body">
                            <h4 class="box-link"><a href="manage_picks_products.php">Добавить товары в подборки</a></h4>
                        </div>
                        <div class="card-body--">
                            <div class="table-stats order-table ov-h">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>Название подборки</th>
                                        <th>Посмотреть товары из подборки</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i=1;
                                    while ($row=mysqli_fetch_assoc($res)) {
                                        ?>
                                        <tr>
                                            <td class="serial"><?php echo $i++ ?></td>
                                            <td><?php echo $row['name_list'] ?></td>
                                            <td>
                                                <?php
                                                if ($row['status'] == 1) {
                                                    echo "<span class='badge badge-pending'><a href='?type=status&operation=deactive&id=" . $row['id'] . "'>Деакт.</a></span>&nbsp;";
                                                } else {
                                                    echo "<span class='badge badge-complete'><a href='?type=status&operation=active&id=" . $row['id'] . "'>Актив.</a></span>&nbsp;";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
require('footer.inc.php');
?>