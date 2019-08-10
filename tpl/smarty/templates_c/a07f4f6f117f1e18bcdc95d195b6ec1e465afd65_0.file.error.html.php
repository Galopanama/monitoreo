<?php
/* Smarty version 3.1.33, created on 2019-08-10 14:44:32
  from 'C:\WinNMP\WWW\Monitoreo\monitoreo\tpl\error.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d4ed850e17d34_47551508',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a07f4f6f117f1e18bcdc95d195b6ec1e465afd65' => 
    array (
      0 => 'C:\\WinNMP\\WWW\\Monitoreo\\monitoreo\\tpl\\error.html',
      1 => 1565448262,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d4ed850e17d34_47551508 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title>Error</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="<?php echo $_smarty_tpl->tpl_vars['_WEB_PATH_']->value;?>
/css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <div><span>Ha ocurrido un error</span></div>
    <div><span><?php echo $_smarty_tpl->tpl_vars['error_message']->value;?>
</span></div>
  </body>
</html>
<?php }
}
