<?
require($_SERVER["DOCUMENT_ROOT"]."/local/feedback/feedback_handler.php");
AddEventHandler("main", "OnBeforeEventAdd", array("FeedbackHandler", "ChangeAuthor"));
?>