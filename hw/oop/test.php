<?php

$button = new Button("blue", 100, 50, "submitBtn", "Submit", true);
$text = new Text("white", 200, 30, "username", "", "Enter your username");
$label = new Label("lightgrey", 100, 30, "usernameLabel", "Username", $text);

// Виведення HTML
echo convertToHTML($button);
echo convertToHTML($text);
echo convertToHTML($label);
