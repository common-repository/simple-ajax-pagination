<?php defined( 'ABSPATH' ) || exit;
class SapAdminNotice
{
    public function displayAdminNotice()
    {
        $message     = isset($_SESSION['sap_msg']) ? $_SESSION['sap_msg'] : false;
        $noticeLevel = ! empty($_SESSION['sap_notice_level']) ? $_SESSION['sap_notice_level'] : 'notice-error';

        if ($message) {
            echo "<div class='notice {$noticeLevel} is-dismissible'><p>{$message}</p></div>";
            unset($_SESSION['sap_msg']);
            unset($_SESSION['sap_notice_level']);
        }
    }

    public static function displayError($message)
    {
        self::updateOption($message, 'notice-error');
    }

    public static function displayWarning($message)
    {
        self::updateOption($message, 'notice-warning');
    }

    public static function displayInfo($message)
    {
        self::updateOption($message, 'notice-info');
    }

    public static function displaySuccess($message)
    {
        self::updateOption($message, 'notice-success');
    }

    protected static function updateOption($message, $noticeLevel) {
        $_SESSION['sap_msg'] = $message;
        $_SESSION['sap_notice_level'] = $noticeLevel;
    }
}