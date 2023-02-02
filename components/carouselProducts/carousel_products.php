<?php
$j=file_get_contents('D:\test' . DIRECTORY_SEPARATOR . 'test.json');
$data=json_decode($j, JSON_UNESCAPED_UNICODE);
$index=0;
$index_product=0;
while ($index < count($data)) {
    ?>
    <div class="swiper carouselProducts">
        <h1><?php echo '' . $data[$index]['name_list'] . ""; ?></h1>
        <div class="swiper-wrapper" style="padding: 30px">
            <?php
            $count_products=count($data[$index]['products']);
            echo($count_products);
            while ($index_product < $count_products) {
                ?>
                <div class="swiper-slide swiper-product-card">
                    <div class="card">
                    <div class="main_img_product">
                            <img src="./../../assets/index/assets/img/orig.jfif" alt="Фото товара">
                        </div>
                        <span class="price"><?php echo $data[$index]['products'][$index_product]['price'] ?>&nbsp;₽</span>
                        <span>
    <a href="#">
        </a>
        </span>
                        <div class="buy">
                            <input type="button" value="Добавить в корзину" class="btn_bye">
                            <input type="button" value="Купить сейчас" class="btn_bye_now">
                        </div>
                    </div>
                </div>
                <?php
                $index_product++;
            } ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
    <?php
    $index++;
}
?>