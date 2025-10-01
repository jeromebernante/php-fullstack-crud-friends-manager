<?php
function render($html, $props = [])
{
    // Add "component" => true to props
    $props = array_merge($props, ["component" => true]);

    // Convert array keys into variables
    extract($props);

    // Include the component
    include $html;
}
?>