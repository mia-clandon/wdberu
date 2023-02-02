<?php
include('top.inc.php'); ?>
<?php
$msg='';
$pick_list_id='';
$product_id='';
if (isset($_GET['id']) && $_GET['id'] != '') {
    $id=get_safe_value($con, $_GET['id']);
    $res=mysqli_query($con, "select * from pick_list where id='$id'");
    $check=mysqli_num_rows($res);
    if ($check > 0) {
        $row=mysqli_fetch_assoc($res);
        $pick_list_id=$row['pick_list_id'];
        $product_id=$row['product_id'];
    } else {
        header('location:pick_list.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $pick_list_id=get_safe_value($con, $_POST['pick_list_id']);
    $product_id=get_safe_value($con, $_POST['product_id']);
    $res=mysqli_query($con, "select * from picks_products where pick_list_id='$pick_list_id' and product_id='$product_id'");
    if (!$res) {
        die("Select failed");
    }
    $check=mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $getData=mysqli_fetch_assoc($res);
            if ($id == $getData['id']) {
            } else {
                $msg="Такой поставщик уже есть";
            }
        } else {
            $msg="Такой поставщик уже есть";
        }
    }

    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            mysqli_query($con, "update pick_list set 
                   name_list='$name_list', 
                   where id='$id'");
        } else {

            mysqli_query($con, "insert into picks_products (pick_list_id, product_id)
            values('$pick_list_id', '$product_id')");
            echo($name_list);
        }
        ?>
        <script type="text/javascript">
            window.location.assign('pick_list.php');
        </script>
        <?php
        exit();
    }
}
?>
    <div class="content pb-0">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header"><strong>Добавить товары в подборку</strong></div>
                        <form method="post">
                            <div class="card-body card-block">
                                <div class="form-group">
                                    <label for="pick_list_id" class="form-control-label">Категория</label>
                                    <select class="form-control" name="pick_list_id" id="pick_list_id" required>
                                        <option>Выберите название подборки</option>
                                        <?php
                                        $res=mysqli_query($con, "select id, name_list from pick_list order by name_list asc");
                                        while ($row=mysqli_fetch_assoc($res)) {
                                            if ($row['id'] == $id) {
                                                echo "<option selected value=" . $row['id'] . ">" . $row['name_list'] . "</option>";
                                            } else {
                                                echo "<option value=" . $row['id'] . ">" . $row['name_list'] . "</option>";
                                            }

                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="categories_id" class="form-control-label">Категория</label>
                                    <select class="form-control" name="product_id" id="product_id" required>
                                        <option>Выберите товар</option>
                                        <?php
                                        $res=mysqli_query($con, "select id, name from product order by name asc");
                                        while ($row=mysqli_fetch_assoc($res)) {
                                            if ($row['id'] == $id) {
                                                echo "<option selected value=" . $row['id'] . ">" . $row['name'] . "</option>";
                                            } else {
                                                echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                                            }

                                        }
                                        ?>
                                    </select>
                                </div>
                                <button id="payment-button" name="submit" type="submit"
                                        class="btn btn-lg btn-info btn-block">
                                    <span id="payment-button-amount">Добавить товары</span>
                                </button>
                                <div class="field_error"><?php echo $msg ?></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
require('footer.inc.php');
?>