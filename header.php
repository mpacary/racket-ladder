<?php

$title = "Badminton Vourey";

$messages = Message::getAll();
Message::clear();

?><html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title><?php echo $title ?></title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  
<nav class="navbar navbar-inverse navbar-fixed-top">
<div class="container">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="."><?php echo $title ?></a>
  </div>
  <div id="navbar" class="collapse navbar-collapse">
    <ul class="nav navbar-nav">
      <?php

      foreach($g_modules as $module_code => $module)
      {
        $classname = "";
        
        if ($module_code == $g_current_module)
          $classname = "active";
        
        echo '<li class="'.$classname.'"><a href="'.Routing::getUrlFor(array('module' => $module_code)).'">'.$module['name'].'</a></li>'."\n";
      }

      ?>
    </ul>
  </div><!--/.nav-collapse -->
</div>

</nav>

<div id="content" class="container">

<ul class="nav nav-pills">
<?php

foreach($g_actions as $action_code => $action)
{
  if ($action_code != $g_current_action && isset($action['hidden']) && $action['hidden'])
    continue; // skip
  
  if ($action_code == $g_current_action)
  {
    echo '<li class="active"><a href="'.$url.'">'.$action['name'].'</a></li>'."\n";
  }
  else
  {
    $url = Routing::getUrlFor(array('module' => $g_current_module, 'action' => $action_code));
    echo '<li><a href="'.$url.'">'.$action['name'].'</a></li>'."\n";
  }
}

?>
</ul>

<?php

foreach($messages as $message)
{
  echo '<p class="message text-'.$message['type'].' bg-'.$message['type'].'">'.$message['text'].'</p>'."\n";
}

?>
