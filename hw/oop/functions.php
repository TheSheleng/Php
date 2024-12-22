<?php

function convertToHTML($control) {
    $html = '';
    if ($control instanceof Button) {
        $html .= "<button style='background: {$control->getBackground()}; width: {$control->getWidth()}px; height: {$control->getHeight()}px;' name='{$control->getName()}' value='{$control->getValue()}'>";
        if ($control->getSubmitState()) {
            $html .= "Submit";
        }
        $html .= "</button>";
    } elseif ($control instanceof Text) {
        $html .= "<input type='text' style='background: {$control->getBackground()}; width: {$control->getWidth()}px; height: {$control->getHeight()}px;' name='{$control->getName()}' value='{$control->getValue()}' placeholder='{$control->getPlaceholder()}' />";
    } elseif ($control instanceof Label) {
        $html .= "<label for='{$control->getParentName()}' style='background: {$control->getBackground()}; width: {$control->getWidth()}px; height: {$control->getHeight()}px;'>{$control->getName()}</label>";
    }

    return $html;
}
