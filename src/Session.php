<?php

namespace Ebcms;

class Session
{

    private $prefix = '';

    function __construct(string $prefix = null)
    {
        if (is_null($prefix)) {
            $prefix = dirname('/' . implode('/', array_filter(explode('/', $_SERVER['SCRIPT_NAME']))));
        }
        $this->prefix = $prefix;
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function set(string $id, $value): self
    {
        $_SESSION[$this->prefix . $id] = $value;
        return $this;
    }

    public function get(string $id = null)
    {
        if ($id == null) {
            return $_SESSION;
        } else {
            return isset($_SESSION[$this->prefix . $id]) ? $_SESSION[$this->prefix . $id] : null;
        }
    }

    public function delete(string $id): self
    {
        if (isset($_SESSION[$this->prefix . $id])) {
            unset($_SESSION[$this->prefix . $id]);
        }
        return $this;
    }

    public function destroy(): self
    {
        session_destroy();
        return $this;
    }

    public function setSessionId(string $session_id): self
    {
        session_id($session_id);
        return $this;
    }

    public function getSessionId(): string
    {
        return session_id();
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }
}
