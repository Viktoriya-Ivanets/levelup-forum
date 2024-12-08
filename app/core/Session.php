<?php

namespace app\core;

class Session
{
    /**
     * Starts a new session or resumes an existing session.
     *
     * @return void
     */
    public static function start(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Sets a session variable.
     *
     * @param string $key The key for the session variable.
     * @param mixed $value The value to be stored in the session.
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Retrieves a session variable.
     *
     * @param string $key The key of the session variable to retrieve.
     * @return mixed|null The value of the session variable, or null if not set.
     */
    public static function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Removes a session variable.
     *
     * @param array $keys Array of keys - session variables to remove.
     * @return void
     */
    public static function remove(array $keys): void
    {
        foreach ($keys as $key) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Destroys the current session and all session data.
     *
     * @return void
     */
    public static function destroy(): void
    {
        session_destroy();
    }

    /**
     * Generate unique identificatore for authenticated user
     * @return string
     */
    public static function generateToken(): string
    {
        return substr(bin2hex(random_bytes(128)), 0, 128);
    }
}
