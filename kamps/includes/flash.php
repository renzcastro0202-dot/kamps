<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Set a flash message
 * 
 * @param string $message
 * @param string $type success|error|info|warning
 */
function set_flash(string $message, string $type = 'info'): void {
    $_SESSION['flash'][] = [
        'message' => $message,
        'type'    => $type
    ];
}

/**
 * Display and clear all flash messages
 */
function display_flash(): void {
    if (!empty($_SESSION['flash'])) {
        echo "<style>
            .flash {
              margin: 10px 0;
              padding: 12px 16px;
              border-radius: 6px;
              font-size: 14px;
              font-weight: 500;
            }
            .flash-success { background: #e0f6e9; color: #217a37; border: 1px solid #b6e2c0; }
            .flash-error   { background: #fbe3e3; color: #a11616; border: 1px solid #f2c2c2; }
            .flash-warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
            .flash-info    { background: #e7f1ff; color: #084298; border: 1px solid #b6d4fe; }
        </style>";

        foreach ($_SESSION['flash'] as $flash) {
            $class = match ($flash['type']) {
                'success' => 'flash flash-success',
                'error'   => 'flash flash-error',
                'warning' => 'flash flash-warning',
                default   => 'flash flash-info',
            };

            echo "<div class='{$class}'>" . htmlspecialchars($flash['message']) . "</div>";
        }
        unset($_SESSION['flash']); // clear after showing
    }
}
