<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
    <div class="row">
        <h1>Каталог:</h1>
    </div>
    <div class="container-fluid">
        <ul>
            <?foreach($arResult['NEWS_CATALOG'] as $branch):?>
                <li>
                    <p class="d-inline">
                        <b>
                            <?echo $branch['NEWS']['NAME']?>.
                        </b>
                        &nbsp;-&nbsp;
                        <? echo (!empty($branch['NEWS']['DATE_ACTIVE_FROM']) ? $branch['NEWS']['DATE_ACTIVE_FROM'] : "Нет данных об активности")?>
                        <?
                            $sectionsList = array();
                            foreach($branch['SECTIONS'] as $section) {
                                $sectionsList[] = $section['NAME'];
                            }
                            echo "(" . implode(', ', $sectionsList) . ')';
                        ?>
                    </p>
                    <ul>
                        <?foreach ($branch['PRODUCTS'] as $product):?>
                            <li>
                                <?
                                    echo $product['NAME'] . " - " . $product['CATALOG_PRICE_1'] . " - " . $product['PROPERTY_MATERIAL_VALUE'] . " - " . $product['PROPERTY_ARTNUMBER_VALUE']
                                ?>
                            </li>
                        <?endforeach;?>
                    </ul>
                </li>
            <?endforeach;?>
        </ul>
    </div>
<?endif;?>