<?
require($_SERVER["DOCUMENT_ROOT"]."/feedback/feedback_handler.php");
AddEventHandler("main", "OnBeforeEventAdd", array("FeedbackHandler", "ChangeAuthor"));
?>