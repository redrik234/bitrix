<?
class FeedbackHandler
{
    public static function ChangeAuthor(&$event, &$lid, &$arFields)
    {
        global $USER;

        $info = array(
            $arFields["AUTHOR"]
        );
        $str = 'Пользователь не авторизован, данные из формы: %s';

        if ($USER->isAuthorized()) {
            $str = 'Пользователь авторизован: %d (%s) %s, данные из формы: %s';
            $info = array(
                $USER->GetID(),
                $USER->GetLogin(),
                $USER->GetFirstName(),
                $arFields["AUTHOR"]
            );
        }
        $arFields["AUTHOR"] = sprintf($str, ...$info);
        self::addRecordToEventLog($arFields["AUTHOR"]);
    }

    private static function addRecordToEventLog($str) {
        $msg = 'Замена данных в отсылаемом письме – %s';
        CEventLog::Add(array(
            "SEVERITY" => "INFO",
            "AUDIT_TYPE_ID" => "FEEDBACK",
            "MODULE_ID" => "main",
            "ITEM_ID" => 'replaceFeedbackInfo',
            "DESCRIPTION" => sprintf($msg, $str)
         ));
    }
}
?>