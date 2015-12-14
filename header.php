<?php

$title = "Badminton Vourey - tournoi permanent";

$messages = Message::getAll();
Message::clear();

?><html>
<head>
  <meta charset="utf-8" />
  <title><?php echo $title ?></title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <h1><?php echo $title ?></h1>

<?php

foreach($messages as $message)
{
  echo '<p class="message '.$message['type'].'">'.$message['text'].'</p>'."\n";
}

