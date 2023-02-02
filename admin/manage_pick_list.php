<?php
include('top.inc.php'); ?>
<?php
$msg='';
$name_list='';
if (isset($_GET['id']) && $_GET['id'] != '') {
    $id=get_safe_value($con, $_GET['id']);
    $res=mysqli_query($con, "select * from pick_list where id='$id'");
    $check=mysqli_num_rows($res);
    if ($check > 0) {
        $row=mysqli_fetch_assoc($res);
        $name_list=$row['name_list'];
    } else {
        header('location:pick_list.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $name_list=get_safe_value($con, $_POST['name_list']);
    $res=mysqli_query($con, "select * from pick_list where name_list='$name_list'");
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

            mysqli_query($con, "insert into pick_list (name_list)
            values('$name_list')");
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
                        <div class="card-header"><strong>Создать подборку</strong></div>
                        <form method="post">
                            <div class="card-body card-block">
                                <div class="form-group">
                                    <label for="name_list" class="form-control-label">Название подборки</label>
                                    <input type="text" name="name_list" placeholder="Введите название компании"
                                           class="form-control" required value="<?php echo $name_list ?>">
                                </div>
                                <button id="payment-button" name="submit" type="submit"
                                        class="btn btn-lg btn-info btn-block">
                                    <span id="payment-button-amount">Добавить подборки</span>
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