<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Loader;
class CTestTaskCatalog extends CBitrixComponent{

    const DEFAULT_CACHE_TIME = 3600;
    const IBLOCK_CATALOG_ID  = 'IBLOCK_CATALOG_ID';
    const IBLOCK_NEWS_ID     = 'IBLOCK_NEWS_ID';
    const USER_PROPERTY      = 'USER_PROPERTY';
    const CACHE_TIME         = 'CACHE_TIME';
    public function onPrepareComponentParams($arParams) {
        return array(
            self::IBLOCK_CATALOG_ID => (int)$arParams[self::IBLOCK_CATALOG_ID],
            self::IBLOCK_NEWS_ID    => (int)$arParams[self::IBLOCK_NEWS_ID],
            self::USER_PROPERTY     => trim($arParams[self::USER_PROPERTY]),
            self::CACHE_TIME        => empty($arParams[self::CACHE_TIME]) ? self::DEFAULT_CACHE_TIME : (int)$arParams[self::CACHE_TIME]
        );
    }

    private function _isEmptyParams() {
        if (empty($this->arParams[self::IBLOCK_CATALOG_ID])
        || empty($this->arParams[self::IBLOCK_NEWS_ID])
        || empty($this->arParams[self::USER_PROPERTY])) {
            return true;
        }
        return false;
    }

    private function _isIncludeModule() {
        if (Loader::includeModule('iblock')) {
            return true;
        }
        return false;
    }

    private function _getActiveNews() {
        $list = \CIBlockElement::GetList(
            array(),
            array(
                'IBLOCK_ID' => $this->arParams[self::IBLOCK_NEWS_ID],
                'ACTIVE'    => 'Y'
            ),
            false,
            false,
            array(
                'ID',
                'NAME',
                'DATE_ACTIVE_FROM',
                'IBLOCK_ID'
            )
        );

        $activeNews = array();
        while ($news = $list->Fetch()) {
            $activeNews[$news['ID']] = $news;
        }
        return $activeNews;
    }

    private function _getProducts($sectionIds) {
        $list = \CIBlockElement::GetList(
            array(),
            array(
                'IBLOCK_ID' => $this->arParams[self::IBLOCK_CATALOG_ID],
                'ACTIVE'    => 'Y',
                'SECTION_ID' => $sectionIds
            ),
            false,
            false,
            array(
                'ID',
                'IBLOCK_ID',
                'NAME',
                'IBLOCK_SECTION_ID',
                'PROPERTY_ARTNUMBER',
                'PROPERTY_MATERIAL',
                'CATALOG_PRICE_1'
            )
        );

        $products = array();
        while ($product = $list->Fetch()) {
            $products[$product['ID']] = $product;
        }
        return $products;
    }

    private function _getSections($newsId) {
        $list = \CIBlockSection::GetList(
            array(),
            array(
                'IBLOCK_ID' => $this->arParams[self::IBLOCK_CATALOG_ID],
                $this->arParams[self::USER_PROPERTY] => $newsId,
                'ACTIVE'    => 'Y'
            ),
            true,
            array(
                'ID',
                'IBLOCK_ID',
                'NAME',
                $this->arParams[self::USER_PROPERTY]
            ),
            false
        );

        $activeSections = array();
        while ($section = $list->Fetch()) {
            $activeSections[$section['ID']] = $section;
        }
        return $activeSections;
    }

    public function executeComponent() {
        global $USER, $APPLICATION;
        if ($this->startResultCache(false, ($this->arParams["CACHE_GROUPS"] === "N" ? false : $USER->GetGroups()))) {
            if (!$this->_isIncludeModule()) {
                $this->abortResultCache();
                ShowError(GetMessage("SC_IBLOCK_NOT_INCLUDE"));
                return false;
            }

            if ($this->_isEmptyParams()) {
                $this->abortResultCache();
                ShowError(GetMessage("SC_EMPTY_PARAMS"));
                return false;
            }

            $activeNews = $this->_getActiveNews();

            $this->arResult['NEWS_CATALOG'] = array();
            $this->arResult['PRODUCT_COUNT'] = 0;

            $info = array();
            foreach ($activeNews as $news) {
                $newsId = $news['ID'];
                $info[$newsId]['NEWS'] = $news;
                $info[$newsId]['SECTIONS'] = $this->_getSections($newsId);
                $sectionIds = array_map(function($val) {
                    return $val['ID'];
                }, $info[$newsId]['SECTIONS']);
                $info[$newsId]['PRODUCTS'] = $this->_getProducts($sectionIds);
                $this->arResult['PRODUCT_COUNT'] += count($info[$newsId]['PRODUCTS']);
            }

            $this->arResult['NEWS_CATALOG'] = $info;

            $this->SetResultCacheKeys(['PRODUCT_COUNT']);

            $this->IncludeComponentTemplate();
        }

        $APPLICATION->SetTitle(GetMessage('SC_PAGE_TITLE', array('PRODUCT_COUNT' => $this->arResult['PRODUCT_COUNT'])));
    }
}
?>