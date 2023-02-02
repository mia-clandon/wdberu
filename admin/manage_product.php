<?php
require('top.inc.php');
//$article='';
$categories_id='';
$seller_id='';
$name='';
$manufacturer='';
$model='';
$mrp='';
$price='';
$qty='';
$image='';
$short_desc='';
$description='';
$best_seller='';
$meta_title='';
$meta_desc='';
$meta_keyword='';


$msg='';
$image_required='required';
if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required='';
    $id=get_safe_value($con, $_GET['id']);
    $res=mysqli_query($con, "select * from product where id='$id'");
    $check=mysqli_num_rows($res);
    if ($check > 0) {
        $last_id=mysqli_query($con, "select id from product order by id desc limit 1");
        $row=mysqli_fetch_assoc($last_id);
        $row=mysqli_fetch_assoc($res);
        $article = $seller_id.$categories_id.$row["id"];
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
        ?>
        <script type="text/javascript">
            window.location.assign('pick_list.php');
        </script>
        <?php
        exit();
    }
}

// article categories_id seller_id name manufacturer model mrp price qty image short_desc description best_seller meta_title meta_desc meta_keyword status

if (isset($_POST['submit'])) {
    $last_id=mysqli_query($con, "select id from product order by id desc limit 1");
    $row=mysqli_fetch_assoc($last_id);
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
    $upload_dir='D:/test/';

    $article = $seller_id.$categories_id.$row["id"];


    $res=mysqli_query($con, "select * from product where name='$name' and model='$model'");
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

    if (isset($_GET['id']) && $_GET['id'] == 0) {
        if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
            $msg="Please select only png,jpg and jpeg image formate";
        }
    } else {
        if ($_FILES['image']['type'] != '') {
            if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg' && $_FILES['image']['type'] != 'image/avif' && $_FILES['image']['type'] != 'image/gif') {
                $msg="Please select only png,jpg,avif and jpeg image formate";
            }
        }
    }

    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            if ($_FILES['image']['name'] != '') {
                $image=rand(111111111, 999999999).'_'.$_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir.$image);
                $update_sql="update product set categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',manufacturer='$manufacturer' ,short_desc='$short_desc',description='$description', image='$image',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword',image='$image',best_seller='$best_seller',sub_categories_id='$sub_categories_id' where id='$id'";
            } else {
                $update_sql="update product set categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',model='$model',short_desc='$short_desc',description='$description', image='$image',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword',best_seller='$best_seller',sub_categories_id='$sub_categories_id' where id='$id'";
            }
            mysqli_query($con, $update_sql);
        } else {
            $image=rand(111111111, 999999999).'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir.$image);
            mysqli_query($con, "insert into product(article, categories_id, seller_id, name, manufacturer, model, mrp, price, qty, image, short_desc, description, best_seller, meta_title, meta_desc, meta_keyword) 
values('$article', '$categories_id', '$seller_id', '$name', '$manufacturer', '$model', '$mrp', '$price', '$qty', '$image', '$short_desc', '$description', '$best_seller', '$meta_title', '$meta_desc', '$meta_keyword')");
        }
        ?>
        <script type="text/javascript"> window.location.assign('product.php');
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
                    <div class="card-header"><strong>Добавление товара</strong></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="categories_id" class="form-control-label">Категория</label>
                                <select class="form-control" name="categories_id" id="categories_id"
                                        onchange="get_sub_cat('')" required>
                                    <option>Выберите категорию</option>
                                    <?php
                                    $res=mysqli_query($con, "select id,categories from categories order by categories asc");
                                    while ($row=mysqli_fetch_assoc($res)) {
                                        if ($row['id'] == $categories_id) {
                                            echo "<option selected value=" . $row['id'] . ">" . $row['categories'] . "</option>";
                                        } else {
                                            echo "<option value=" . $row['id'] . ">" . $row['categories'] . "</option>";
                                        }

                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="seller_id" class="form-control-label">Поставщик</label>
                                <select class="form-control" name="seller_id" id="seller_id"
                                        onchange="get_sub_cat('')" required>
                                    <option>Выберите поставщика</option>
                                    <?php
                                    $res=mysqli_query($con, "select id, name_shop from sellers order by name_shop asc");
                                    while ($row=mysqli_fetch_assoc($res)) {
                                        if ($row['id'] == $seller_id) {
                                            echo "<option selected value=" . $row['id'] . ">" . $row['name_shop'] . "</option>";
                                        } else {
                                            echo "<option value=" . $row['id'] . ">" . $row['name_shop'] . "</option>";
                                        }

                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name" class="form-control-label">Название название товара</label>
                                <input type="text" name="name" id="name" placeholder="Введите название товара"
                                       class="form-control" required value="<?php echo $name ?>">
                            </div>
                            <div class="form-group">
                                <label for="manufacturer" class="form-control-label">Производитель</label>
                                <input type="text" name="manufacturer" id="manufacturer" placeholder="Производитель"
                                       class="form-control"
                                       value="<?php echo $manufacturer ?>">
                            </div>
                            <div class="form-group">
                                <label for="model" class="form-control-label">Модель</label>
                                <input type="text" name="model" id="model" placeholder="Модель" class="form-control"
                                       value="<?php echo $model ?>">
                            </div>
                            <div class="form-group">
                                <label for="price" class="form-control-label">Цена обычная</label>
                                <input type="text" name="price" id="price" placeholder="Обычная цена"
                                       class="form-control" required
                                       value="<?php echo $price ?>">
                            </div>
                            <div class="form-group">
                                <label for="mrp" class=" form-control-label">Цена со скидкой</label>
                                <input type="text" name="mrp" id="mrp" placeholder="Цена со скидкой"
                                       class="form-control"
                                       required value="<?php echo $mrp ?>">
                            </div>
                            <div class="form-group">
                                <label for="qty" class=" form-control-label">Количество</label>
                                <input type="number" name="qty" id="qty" placeholder="Количество" class="form-control"
                                       required
                                       value="<?php echo $qty ?>">
                            </div>
                            <div class="form-group">
                                <label for="short_desc" class=" form-control-label">Краткое описание</label>
                                <textarea name="short_desc" id="short_desc" placeholder="Краткое описание"
                                          class="form-control"
                                          required><?php echo $short_desc ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="description" class=" form-control-label">Описание</label>
                                <textarea name="description" id="description" placeholder="Описание"
                                          class="form-control"
                                          required><?php echo $description ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image" class=" form-control-label">Главное фото товара</label>
                                <input type="file" name="image" class="form-control" placeholder="<?php echo $image ?>">
                            </div>
                            <div class="form-group">
                                <label for="best_seller" class="form-control-label">Товар месяц?</label>
                                <select class="form-control" name="best_seller" id="best_seller" required>
                                    <?php
                                    if ($best_seller == 1) {
                                        echo '<option value="1" selected>Да</option>
												<option value="0">Нет</option>';
                                    } elseif ($best_seller == 0) {
                                        echo '<option value="1">Да</option>
												<option value="0" selected>Нет</option>';
                                    } else {
                                        echo '<option value="1">Да</option>
												<option value="0">Нет</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="meta_title" class="form-control-label">Мета заголовок</label>
                                <textarea name="meta_title" id="meta_title" placeholder="Мета заголовок"
                                          class="form-control"><?php echo $meta_title ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_desc" class="form-control-label">Мето-описание</label>
                                <textarea name="meta_desc" id="meta_desc" placeholder="Мета-описание"
                                          class="form-control"><?php echo $meta_desc ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_keyword" class=" form-control-label">Хэштег</label>
                                <textarea name="meta_keyword" id="meta_keyword" placeholder="Хэштег"
                                          class="form-control"><?php echo $meta_keyword ?></textarea>
                            </div>
                            <button id="payment-button" name="submit" type="submit"
                                    class="btn btn-lg btn-info btn-block">
                                <span id="payment-button-amount">Добавить</span>
                            </button>
                            <div class="field_error"><?php echo $msg ?></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function get_sub_cat(sub_cat_id) {
        let categories_id = jQuery('#categories_id').val();
        jQuery.ajax({
            url: 'get_sub_cat.php',
            type: 'post',
            data: 'categories_id=' + categories_id,
            success: function (result) {
                jQuery('#sub_categories_id').html(result);
            }
        });
    }
</script>

<?php
require('footer.inc.php');
?>
