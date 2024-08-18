<?php
function getFormattedDate($date): string
{
    $timestamp = strtotime($date);
    return date('d M Y, h:i A', $timestamp);
}
?>