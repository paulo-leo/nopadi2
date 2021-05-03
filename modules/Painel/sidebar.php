<?php
hello(open_menu('Início|dashboard','home','np-deep-orange'));
/*Menu para filiasi*/
$menu_settings = array(
   'settings/environment|Gerais',
   'settings/theme|Tema',
   'settings/sectors|Setorização',
   'settings/smtp|SMTP|email',
   'settings/db|Banco de dados',
   'settings/key-api|Chave de API',
   'settings/modules|Módulos'
);



$menu_apps = array(
   'fin|Finanças',
   'inventory|Estoque',
   'crm|CRM'
);

$menu_users = array(
   'users|Listar',
   'users/create|Adicionar'
);

hello(dropdown_menu('users|Usuários|group|admin,dev,editor,author,collaborator',
['items'=>items_menu($menu_users)]));

hello(dropdown_menu('apps|Aplicativos|widgets|admin,dev,editor,author,collaborator',
['items'=>items_menu($menu_apps)]));

hello(dropdown_menu('settings|Configurações|settings|admin,dev,editor,author,collaborator',
['items'=>items_menu($menu_settings )]));




hello(close_menu());
?>
