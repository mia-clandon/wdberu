<?php
require('./top.inc.php');

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
        $update_status_sql="update categories set status='$status' where id='$id'";
        mysqli_query($con, $update_status_sql);
    }

    if ($type == 'delete') {
        $id=get_safe_value($con, $_GET['id']);
        $delete_sql="delete from categories where id='$id'";
        mysqli_query($con, $delete_sql);
    }
}

//ДОДЕЛАТЬ ВЫВОД РОДИТЕЛЬСИКХ КАТЕГОРИЙ
$sql="select * from categories where parent_id > '0' order by categories asc";

//function selectNameParentCategories($parent_id)
//{
//    $parent__id=$parent_id;
//    $parent_categories="select categories as parent from categories where id=$parent__id";
//    $res_parent_categories=mysqli_query($con, $parent_categories);
//    while ($rows=mysqli_fetch_assoc($res_parent_categories)) {
//        echo $rows['parent'];
//    }
//}

$res=mysqli_query($con, $sql);
?>
    <div class="content pb-0">
        <div class="orders">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="box-title">Подкатегории</h4>
                            <h4 class="box-link"><a href="manage_sub_categories.php">Добавить подкатегорию</a></h4>
                            <!--                            <h4 class="box-link"><a href="manage_characteristic_sub_categories.php">Добавить параметры к-->
                            <!--                                    подкатегории</a></h4>-->
                        </div>
                        <div class="card-body--">
                            <div class="table-stats order-table ov-h">
                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>ID</th>
                                        <th>Родительская категория</th>
                                        <th>Подкатегория</th>
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
                                            <td><?php echo $row['id'] ?></td>
                                            <!--                                            <td>-->
                                            <?php //echo $row['parent_id'] ?><!--</td>-->
                                            <td><?php
//                                                selectNameParentCategories($row['parent_id']);
                                                $parent__id=$row['parent_id'];
                                                $parent_categories="select categories as parent from categories where id=$parent__id";
                                                $res_parent_categories=mysqli_query($con, $parent_categories);
                                                while ($rows=mysqli_fetch_assoc($res_parent_categories)) {
                                                    echo $rows['parent'];
                                                }
                                                ?></td>
                                            <td><?php echo $row['categories'] ?></td>
                                            <td>
                                                <?php
                                                if ($row['status'] == 1) {
                                                    echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=" . $row['id'] . "'>Активировать</a></span>&nbsp;";
                                                } else {
                                                    echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=" . $row['id'] . "'>Деактивировать</a></span>&nbsp;";
                                                }
                                                echo "<span class='badge badge-edit'><a href='manage_sub_categories.php?id=" . $row['id'] . "'>Редактировать</a></span>&nbsp;";

                                                echo "<span class='badge badge-delete'><a href='?type=delete&id=" . $row['id'] . "'>Удалить</a></span>";

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