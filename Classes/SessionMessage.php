<?php

class SessionMessage
{
    private static $validTypes = ['success', 'danger', 'warning', 'info'];

    public static function set($type, $message)
    {
        if (session_status() === PHP_SESSION_NONE) {
            error_log('Session not started before using SessionMessage::set(). This should be called once at the start of the application.');
            return false;
        }
        
        if (!in_array($type, self::$validTypes)) {
            $type = 'info';
        }
        
        if (empty(trim($message))) {
            return false;
        }
        
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => trim($message)
        ];
        
        return true;
    }

    public static function get()
    {
        if (session_status() === PHP_SESSION_NONE) {
            error_log('Session not started before using SessionMessage::get(). This should be called once at the start of the application.');
            return null;
        }

        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $message;
        }
        return null;
    }

    public static function hasMessages()
    {
        if (session_status() === PHP_SESSION_NONE) {
            error_log('Session not started before using SessionMessage::hasMessages(). This should be called once at the start of the application.');
            return false;
        }
        return isset($_SESSION['flash_message']);
    }
} 