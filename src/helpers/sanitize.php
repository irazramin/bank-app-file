<?php
    function sanitize($str): string
    {
        return htmlspecialchars(trim($str));
    }

?>