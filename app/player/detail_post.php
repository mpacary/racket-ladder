<?php

Database::update(array(
    'table' => 'bad_player',
    'row' => array(
        'id' => intval($_POST['id']),
        'first_name' => "'".Database::escape($_POST['first_name'])."'",
        'last_name' => "'".Database::escape($_POST['last_name'])."'",
      )
  ));

Message::add(array('type' => 'success', 'text' => 'Joueur modifié avec succès.'));

Routing::redirect(array('module' => $g_current_module, 'action' => 'list'));