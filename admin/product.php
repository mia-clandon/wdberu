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
    <div class="content pb-0">
        <div class="orders">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="box-title">Товары </h4>
                            <h4 class="box-link"><a href="manage_product.php">Добавить товар</a></h4>
                        </div>
                        <div class="card-body--">
                            <div class="table-stats order-table ov-h">
                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>Артикуль</th>
                                        <th>Категория</th>
                                        <th>Поставщик</th>
                                        <th>Название</th>
                                        <th>Производитель</th>
                                        <th>Модель</th>
                                        <th>Обычная цена</th>
                                        <th>Скидочная цена</th>
<!--                                        <th>Количество</th>-->
                                        <th>Краткое описание</th>
<!--                                        <th>Описание</th>-->
                                        <th>Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i=1;
                                    while ($row=mysqli_fetch_assoc($res)) {
                                        ?>
                                        <tr>
                                            <td class="serial"><?php echo $i++ ?></td>
                                            <td><?php echo $row['article'] ?></td>
                                            <td><?php echo $row['categories'] ?></td>
                                            <td><?php echo $row['name_shop'] ?></td>
                                            <td><?php echo $row['name'] ?></td>
                                            <td><?php echo $row['manufacturer'] ?></td>
                                            <td><?php echo $row['model'] ?></td>
                                            <td><?php echo $row['mrp'] ?></td>
                                            <td><?php echo $row['price'] ?></td>
<!--                                            <td>--><?php //echo $row['qty'] ?><!--<br/>-->
                                            <td><?php echo $row['short_desc'] ?></td>
<!--                                            <td>--><?php //echo $row['description'] ?><!--</td>-->
                                            <td>
                                                <?php
                                                if ($row['status'] == 1) {
                                                    echo "<span class='badge badge-pending'><a href='?type=status&operation=deactive&id=" . $row['id'] . "'>Деакт.</a></span>&nbsp;";
                                                } else {
                                                    echo "<span class='badge badge-complete'><a href='?type=status&operation=active&id=" . $row['id'] . "'>Актив.</a></span>&nbsp;";
                                                }
                                                echo "<span class='badge badge-edit'><a href='manage_product.php?id=" . $row['id'] . "'>Ред.</a></span>&nbsp;";

                                                echo "<span class='badge badge-delete'><a href='?type=delete&id=" . $row['id'] . "'>Удал.</a></span>";

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