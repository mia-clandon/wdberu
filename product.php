<?php
require('top.php');
if (isset($_GET['id'])) {
    $product_id=mysqli_real_escape_string($con, $_GET['id']);
    if ($product_id > 0) {
        $get_product=get_product($con, '', '', $product_id);
    } else {
        ?>
        <script>
            window.location.href = 'index.php';
        </script>
        <?php
    }
} else {
    ?>
    <script>
        window.location.href = 'index.php';
    </script>
    <?php
}
?>
    <div class="card">
        <section class="header">
            <ul>
                <li>Подборки</li>
                <li>Детали мужского образа</li>
                <li>Наручные часы</li>
                <li>CITIZEN</li>
            </ul>
            <h1 class="header_product">
                Наручные часы CITIZEN
            </h1>
            <div class="info_product">
                <ul>
                    <li class="rating"><span>4.8</span></li>
                    <li><a href="#"><span>Отзывы</span></a></li>
                    <li><a href="#"><span>Характеристика</span></a></li>
                    <li><a href="#"><span>Обзоры</span></a></li>
                </ul>
            </div>
        </section>
        <section class="card_product">
            <div class="img_product">
                <ul class="carousel_images">
                    <li><img src="./images/test/orig.jfif" alt="Фото товара" class="clicable_images"></li>
                    <li><img src="./images/test/carousel.png" alt="Фото товара" class="clicable_images"></li>
                    <li><img src="./images/test/carousel1.png" alt="Фото товара" class="clicable_images"></li>
                </ul>
                <div class="main_img_product">
                    <img src="./images/test/orig.jfif" alt="Фото товара" id="mainImage">
                </div>
            </div>
            <div class="desc_product">
                <div class="price_block">
                    <span class="new_price">2999&nbsp;₽</span>
                    <span class="old_price">3999&nbsp;₽</span>
                </div>
                <div class="article_block">
                    <span>Артикул: 46270743</span>
                </div>
                <div>
                    <h3>Коротко о товаре</h3>
                    <table>
                        <tbody>
                        <tr>
                            <td>
                                <div class="title_feature">
                                    <span>Тип механизма</span>
                                </div>
                            </td>
                            <td class="desc_feature">
                                <a href="#">Кварцевые</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Тип механизма</td>
                            <td style="color: #04b; text-transform: lowercase;">Кварцевые</td>
                        </tr>
                        <tr>
                            <td>Тип механизма</td>
                            <td style="color: #04b; text-transform: lowercase;">Кварцевые</td>
                        </tr>
                        <tr>
                            <td>Тип механизма</td>
                            <td style="color: #04b; text-transform: lowercase;">Кварцевые</td>
                        </tr>
                        <tr>
                            <td>Тип механизма</td>
                            <td style="color: #04b; text-transform: lowercase;">Кварцевые</td>
                        </tr>
                        <tr>
                            <td>Тип механизма</td>
                            <td style="color: #04b; text-transform: lowercase;">Кварцевые</td>
                        </tr>
                        <tr>
                            <td>Тип механизма</td>
                            <td style="color: #04b; text-transform: lowercase;">Кварцевые</td>
                        </tr>
                        <tr>
                            <td>Тип механизма</td>
                            <td style="color: #04b; text-transform: lowercase;">Кварцевые</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <input type="button" value="Добавить в корзину" class="btn_bye">
                <input type="button" value="Купить сейчас" class="btn_bye_now">
            </div>
        </section>
        <section class="full_desc_product">
            <!-- <div class="full_desc">
                <h1 class="header_product header_full_desc">Описание</h1>
                <p class="content_full_desc">В современном мире все меняется с очень высокой скоростью, от климата до моделей носимых гаджетов, но
                    классические часы остаются неизменны. Да, многие переходят на умные часы и фитнес-браслеты, но есть те
                    кому
                    нравятся классические большие часы с точным механизмом. И я отношусь ко второй группе.

                    За все время у меня было несколько разных часов включая механические Seiko, которые меня и привлекли
                    относительно не дорогой стоимостью и наличием автоподзавода. Два главных недостатка часов Seiko моей
                    модели
                    это точность и слабый запас хода.
                </div> -->
            <div class="full_features">
                <h1 class="header_product header_full_desc">Подробные характеристики
                </h1>
                <div>
                    <h3>Общие характеристики
                    </h3>
                </div>
            </div>
        </section>
        <section class="footer">
            <div class="reviews">
            </div>
        </section>
    </div>
<?php //require('footer.php') ?>