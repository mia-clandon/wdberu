<?php
include('top.inc.php'); ?>
<?php
$msg='';
$name_shop='';
$name_manager='';
$phone_manager='';
$reserve_phone_manager='';
$email_manager="";
$social_networks='';
$form_pay='';
$type_pay='';
$address='';
$work_schedule='';
if (isset($_GET['id']) && $_GET['id'] != '') {
    $id=get_safe_value($con, $_GET['id']);
    $res=mysqli_query($con, "select * from sellers where id='$id'");
    $check=mysqli_num_rows($res);
    if ($check > 0) {
        $row=mysqli_fetch_assoc($res);
        $name_shop=$row['name_shop'];
        $name_manager=$row['name_manager'];
        $phone_manager=$row['phone_manager'];
        $reserve_phone_manager=$row['reserve_phone_manager'];
        $email_manager=$row['email_manager'];
        $social_networks=$row['social_network'];
        $form_pay=$row['form_pay'];
        $type_pay=$row['type_pay'];
        $address=$row['phisical_address'];
        $work_schedule=$row['work_schedule'];
    } else {
        header('location:sellers.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $name_shop=get_safe_value($con, $_POST['name_shop']);
    $name_manager=get_safe_value($con, $_POST['name_manager']);
    $phone_manager=get_safe_value($con, $_POST['phone_manager']);
    $reserve_phone_manager=get_safe_value($con, $_POST['reserve_phone_manager']);
    $email_manager=get_safe_value($con, $_POST['email_manager']);
    $social_networks=get_safe_value($con, $_POST['social_networks']);
    $form_pay=get_safe_value($con, $_POST['form_pay']);
    $type_pay=get_safe_value($con, $_POST['type_pay']);
    $address=get_safe_value($con, $_POST['address']);
    $work_schedule=get_safe_value($con, $_POST['work_schedule']);
    $res=mysqli_query($con, "select * from sellers where name_shop='$name_shop' and email_manager='$email_manager'");
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
            mysqli_query($con, "update sellers set 
                   name_shop='$name_shop', 
                   name_manager='$name_manager',
                   phone_manager='$phone_manager', 
                   reserve_phone_manager='$reserve_phone_manager',
                   email_manager='$email_manager',
                   phisical_address='$address',
                   social_network='$social_networks',
                   type_pay='$type_pay',
                   form_pay='$form_pay',
                   work_schedule='$work_schedule'
                   where id='$id'");
        } else {

            mysqli_query($con, "insert into sellers(name_shop, name_manager ,phone_manager, reserve_phone_manager, email_manager, phisical_address, social_network , type_pay, form_pay, work_schedule )
            values('$name_shop', '$name_manager' ,'$phone_manager', '$reserve_phone_manager', '$email_manager', '$social_networks' ,'$form_pay', '$type_pay', '$address', '$work_schedule' )");
            echo($name_shop);
            echo($name_manager);
            echo($phone_manager);
            echo($reserve_phone_manager);
            echo($email_manager);
            echo($social_networks);
            echo($form_pay);
            echo ($type_pay);
            echo ($address);
            echo ($work_schedule);
        }
        header('location:sellers.php');
        exit();
    }
}
?>
    <div class="content pb-0">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header"><strong>Добавить поставщика</strong></div>
                        <form method="post">
                            <div class="card-body card-block">
                                <div class="form-group">
                                    <label for="name_shop" class=" form-control-label">Название компании</label>
                                    <input type="text" name="name_shop" placeholder="Введите название компании"
                                           class="form-control" required value="<?php echo $name_shop ?>">
                                </div>
                                <div class="form-group">
                                    <label for="name_manager" class=" form-control-label">ФИО менеджера</label>
                                    <input type="text" name="name_manager" placeholder="Введите ФИО менеджера"
                                           class="form-control" required value="<?php echo $name_manager ?>">
                                </div>
                                <div class="form-group">
                                    <label for="phone_manager" class=" form-control-label">Номер телефона
                                        менеджера</label>
                                    <input type="text" name="phone_manager"
                                           placeholder="Введите номер телефона менеджера"
                                           class="form-control" required value="<?php echo $phone_manager ?>">
                                </div>
                                <div class="form-group">
                                    <label for="reserve_phone_manager" class=" form-control-label">Резервный номер
                                        телефона
                                        менеджера</label>
                                    <input type="text" name="reserve_phone_manager"
                                           placeholder="Введите резервный номер телефона менеджера"
                                           class="form-control" required value="<?php echo $reserve_phone_manager ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email_manager" class=" form-control-label">E-mail менеджера</label>
                                    <input type="text" name="email_manager"
                                           placeholder="Введите e-mail менеджера"
                                           class="form-control" required value="<?php echo $reserve_phone_manager ?>">
                                </div>
                                <div class="form-group">
                                    <label for="social_networks" class=" form-control-label">Социальные сети
                                        менеджера</label>
                                    <input type="text" name="social_networks"
                                           placeholder="Введите социальные сети менеджера"
                                           class="form-control" required value="<?php echo $social_networks ?>">
                                </div>
                                <div class="form-group">
                                    <label for="form_pay" class=" form-control-label">Форма оплаты</label>
                                    <input type="text" name="form_pay" placeholder="Введите форму оплаты"
                                           class="form-control" required value="<?php echo $form_pay ?>">
                                </div>
                                <div class="form-group">
                                    <label for="type_pay" class=" form-control-label">Тип оплаты</label>
                                    <input type="text" name="type_pay" placeholder="Введите тип оплаты"
                                           class="form-control" required value="<?php echo $type_pay ?>">
                                </div>
                                <div class="form-group">
                                    <label for="address" class="form-control-label">Адрес, откуда забирать
                                        товар</label>
                                    <input type="text" name="address" placeholder="Введите адрес, откуда забирать товар"
                                           class="form-control" required value="<?php echo $address ?>">
                                </div>
                                <div class="form-group">
                                    <label for="work_schedule" class=" form-control-label">График работы</label>
                                    <input type="text" name="work_schedule" placeholder="График работы"
                                           class="form-control" required value="<?php echo $work_schedule ?>">
                                </div>
                                <button id="payment-button" name="submit" type="submit"
                                        class="btn btn-lg btn-info btn-block">
                                    <span id="payment-button-amount">Добавить поставщика</span>
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