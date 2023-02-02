<?php
require('top.inc.php');

$article='';
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
        $row=mysqli_fetch_assoc($res);
        $article=$row['article'];
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
        header('location:product.php');
        die();
    }
}

if (isset($_POST['saveBtn'])) {
    echo('Я тут');
//ДОДЕЛАТЬ СИСТЕМУ АРТИКУЛЕЙ
    $article=get_safe_value($con, $_POST['categories_id']);
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

    $res=mysqli_query($con, "select * from product where article='$article'");
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

    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            if ($_FILES['image']['name'] != '') {
                $image=rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image);
                $update_sql="update product set categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',manufacturer='$manufacturer' ,short_desc='$short_desc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword',image='$image',best_seller='$best_seller',sub_categories_id='$sub_categories_id' where id='$id'";
            } else {
                $update_sql="update product set categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',model='$model',short_desc='$short_desc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword',best_seller='$best_seller',sub_categories_id='$sub_categories_id' where id='$id'";
            }
            mysqli_query($con, $update_sql);
        } else {
            $image=rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image);
            mysqli_query($con, "insert into product(article, categories_id, seller_id, name, manufacturer, model, mrp, price, qty, short_desc, description, best_seller, meta_title, meta_desc, meta_keyword)
values('$article', '$categories_id', '$seller_id', '$name', '$manufacturer', '$model', '$mrp', '$price', '$qty', '$short_desc', '$description', '$best_seller', '$meta_title', '$meta_desc', '$meta_keyword')");

        }
        header('location:product.php');
        die();
    }
}
?>
<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Добавление товара</strong></div>
                    <form id="productForm" method="post" enctype="multipart/form-data">
                        <h1>Добавление товара:</h1>
                        <div class="field_error"><?php echo $msg ?></div>
                        <div class="tab">
                            <h1>Общая информация</h1>
                            <div class="form-group">
                                <label for="categories_id" class=" form-control-label">Категория</label>
                                <select class="form-control" name="categories_id" id="categories_id" required>
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
                                <label for="seller_id" class=" form-control-label">Поставщик</label>
                                <select class="form-control" name="seller_id" id="seller_id" required>
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
                        </div>
                        <div class="tab">Подробная информация:
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
                        </div>
                        <div class="tab">Цены и количество:
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
                        </div>
                        <div class="tab">Описание товара:
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
                        </div>
                        <div class="tab">Фотографии товара:
                            <p><input type="file" placeholder="Добавить главное фото товара..."
                                      oninput="this.className = ''" name="uname1"></p>
                            <p><input type="file" placeholder="Добавить фото товара..." oninput="this.className = ''"
                                      name="uname2"></p>

                        </div>
                        <div style="overflow:auto;">
                            <div style="float:right;">
                                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Назад</button>
                                <button type="button" id="nextBtn" onclick="nextPrev(1)">Дальше</button>
                                <input type="submit" id="saveBtn" onclick="nextPrev(1)" placeholder="Сохранить"/>
                            </div>
                        </div>
                        <!-- Circles which indicates the steps of the form: -->
                        <div style="text-align:center;margin-top:40px;">
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                        </div>
                    </form>
                    <script>
                        let currentTab = 0; // Current tab is set to be the first tab (0)
                        showTab(currentTab); // Display the current tab

                        function showTab(n) {
                            // This function will display the specified tab of the form...
                            let x = document.getElementsByClassName("tab");
                            x[n].style.display = "block";
                            //... and fix the Previous/Next buttons:
                            if (n === 0) {
                                document.getElementById("prevBtn").style.display = "none";
                            } else {
                                document.getElementById("prevBtn").style.display = "inline";
                            }
                            if (n === (x.length - 1)) {
                                document.getElementById("nextBtn").innerHTML = "Сохранить";
                            } else {
                                document.getElementById("nextBtn").innerHTML = "Дальше";
                            }
                            //... and run a function that will display the correct step indicator:
                            fixStepIndicator(n)
                        }

                        function nextPrev(n) {
                            // This function will figure out which tab to display
                            var x = document.getElementsByClassName("tab");
                            // Exit the function if any field in the current tab is invalid:
                            if (n === 1 && !validateForm()) return false;
                            // Hide the current tab:
                            x[currentTab].style.display = "none";
                            // Increase or decrease the current tab by 1:
                            currentTab = currentTab + n;
                            // if you have reached the end of the form...
                            if (currentTab >= x.length) {
                                // ... the form gets submitted:
                                document.getElementById("productForm").submit();
                                const myInput = [];
                                myInput.push({
                                    'value': document.getElementById("categories_id")?.value,
                                    "from": "categories_id"
                                });
                                myInput.push({
                                    'value': document.getElementById("seller_id")?.value,
                                    "from": "seller_id"
                                });
                                myInput.push({'value': document.getElementById("name")?.value, "from": "name"});
                                myInput.push({
                                    'value': document.getElementById("manufacturer")?.value,
                                    "from": "manufacturer"
                                });
                                myInput.push({'value': document.getElementById("model")?.value, "from": "model"});
                                myInput.push({'value': document.getElementById("price")?.value, "from": "price"});
                                myInput.push({'value': document.getElementById("mrp")?.value, "from": "mrp"});
                                myInput.push({'value': document.getElementById("qty")?.value, "from": "qty"});
                                myInput.push({
                                    'value': document.getElementById("short_desc")?.value,
                                    "from": "short_desc"
                                });
                                myInput.push({
                                    'value': document.getElementById("description")?.value,
                                    "from": "description"
                                });
                                myInput.push({
                                    'value': document.getElementById("best_seller")?.value,
                                    "from": "best_seller"
                                });
                                myInput.push({
                                    'value': document.getElementById("meta_title")?.value,
                                    "from": "meta_title"
                                });
                                myInput.push({
                                    'value': document.getElementById("meta_desc")?.value,
                                    "from": "meta_desc"
                                });
                                myInput.push({
                                    'value': document.getElementById("meta_keyword")?.value,
                                    "from": "meta_keyword"
                                });
                                console.log(myInput);
                                alert(JSON.stringify(myInput));
                                return false;
                            }
                            // Otherwise, display the correct tab:
                            showTab(currentTab);
                        }

                        function validateForm() {
                            // This function deals with validation of the form fields
                            let x, y, i, valid = true;
                            x = document.getElementsByClassName("tab");
                            y = x[currentTab].getElementsByTagName("input");
                            // A loop that checks every input field in the current tab:
                            for (i = 0; i < y.length; i++) {
                                // If a field is empty...
                                if (y[i].value === "") {
                                    // add an "invalid" class to the field:
                                    y[i].className += " invalid";
                                    // and set the current valid status to false
                                    valid = false;
                                }
                            }
                            // If the valid status is true, mark the step as finished and valid:
                            if (valid) {
                                document.getElementsByClassName("step")[currentTab].className += " finish";
                            }
                            return valid; // return the valid status
                        }

                        function fixStepIndicator(n) {
                            // This function removes the "active" class of all steps...
                            let i, x = document.getElementsByClassName("step");
                            console.log(x.length)
                            for (i = 0; i < x.length; i++) {
                                x[i].className = x[i].className.replace(" active", "");
                            }
                            //... and adds the "active" class on the current step:
                            x[n].className += " active";
                        }
                    </script>

                    <?php
                    require('footer.inc.php');
                    ?>
