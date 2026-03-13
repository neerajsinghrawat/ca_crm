<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class SingleSessionHooks
{
    public function afterLogin($bean, $event, $arguments)
    {
        // Current PHP session id
        /*$currentSessionId = session_id();

        // Old session id saved in user custom field
        $oldSessionId = isset($bean->current_session_id_c) ? $bean->current_session_id_c : '';

        // If user already had a different active session, kill that session
        if (!empty($oldSessionId) && $oldSessionId !== $currentSessionId) {
            $this->destroyOldSession($oldSessionId);
        }

        // Save the new session id for this user
        $bean->current_session_id_c = $currentSessionId;
        // Avoid infinite loop / unnecessary hooks
        $bean->update_date_modified = false;
        $bean->save();*/
    }

    protected function destroyOldSession($sessionId)
    {
        /*if (empty($sessionId)) {
            return;
        }

        // This works for default file-based sessions
        $sessionPath = session_save_path();
        if (empty($sessionPath)) {
            $sessionPath = sys_get_temp_dir(); // fallback
        }

        $file = rtrim($sessionPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'sess_' . $sessionId;

        if (file_exists($file)) {
            @unlink($file);
        }*/
    }
}
