<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
    "GROUPS" => array(),
    "PARAMETERS" => array(
        "IBLOCK_CATALOG_ID" => array(
            "PARENT" => "BASE",
            "NAME"   => GetMessage("SC_IBLOCK_CATALOG_ID"),
            "TYPE"   => "STRING"
        ),
        "IBLOCK_NEWS_ID" => array(
            "PARENT" => "BASE",
            "NAME"   => GetMessage("SC_IBLOCK_NEWS_ID"),
            "TYPE"   => "STRING"
        ),
        "USER_PROPERTY" => array(
            "PARENT" => "BASE",
            "NAME"   => GetMessage("SC_USER_PROPERTY"),
            "TYPE"   => "STRING"
        ),
        "CACHE_TIME"  =>  array("DEFAULT"=>3600)
    ),
);
?>