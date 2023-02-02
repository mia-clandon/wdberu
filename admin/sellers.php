<?php
require('top.inc.php');

if (isset($_GET['type']) && $_GET['type'] != '') {
    $type=get_safe_value($con, $_GET['type']);

    if ($type == 'delete') {
        $id=get_safe_value($con, $_GET['id']);
        $delete_sql="delete from sellers where id='$id'";
        mysqli_query($con, $delete_sql);
    }
}

$sql="select * from sellers order by id asc";


$res=mysqli_query($con, $sql);
?>
    <div class="content pb-0">
        <div class="orders">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="box-title">Поставщики </h4>
                            <h4 class="box-link"><a href="manage_sellers.php">Добавить поставщиков</a></h4>
                        </div>
                        <div class="card-body--">
                            <div class="table-stats order-table ov-h">
                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>ID</th>
                                        <th>Название</th>
                                        <th>Представитель</th>
                                        <th>Телефон</th>
                                        <th>Рез. телефон</th>
                                        <th>E-mail</th>
                                        <th>Адрес</th>
                                        <th>Соц.сети</th>
                                        <th>Тип оплаты</th>
                                        <th>Форма оплаты</th>
                                        <th>График работы</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i=1;
                                    while ($row=mysqli_fetch_assoc($res)) {
                                        ?>
                                        <tr>
                                            <td class="serial"><?php echo $i ?></td>
                                            <td><?php echo $i++ ?></td>
                                            <td><?php echo $row['name_shop'] ?></td>
                                            <td><?php echo $row['name_manager'] ?></td>
                                            <td><?php echo $row['phone_manager'] ?></td>
                                            <td><?php echo $row['reserve_phone_manager'] ?></td>
                                            <td><?php echo $row['email_manager'] ?></td>
                                            <td><?php echo $row['phisical_address'] ?></td>
                                            <td><?php echo $row['social_network'] ?></td>
                                            <td><?php echo $row['type_pay'] ?></td>
                                            <td><?php echo $row['form_pay'] ?></td>
                                            <td><?php echo $row['work_schedule'] ?></td>
                                            <td>
                                                <?php
                                                echo "<span class='badge badge-edit'><a href='manage_sellers.php?id=" . $row['id'] . "'>Редактировать</a></span>&nbsp;";
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