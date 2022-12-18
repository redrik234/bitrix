<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Задание 1");
?><h2>Обратная связь</h2>
	<?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback",
	"bootstrap_v4",
	Array(
		"EMAIL_TO" => "example@localhost.ru",
		"EVENT_MESSAGE_ID" => array(),
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"REQUIRED_FIELDS" => array("NAME","EMAIL"),
		"USE_CAPTCHA" => "Y"
	)
);



require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>