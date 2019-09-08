<?php
/* Smarty version 3.1.33, created on 2019-09-07 21:40:45
  from 'C:\WinNMP\WWW\Monitoreo\monitoreo\tpl\login.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d7423dd23e2d9_50174831',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5d4816471d84f3d7e7f136f1e5066aea6c0d7fa4' => 
    array (
      0 => 'C:\\WinNMP\\WWW\\Monitoreo\\monitoreo\\tpl\\login.html',
      1 => 1567892387,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d7423dd23e2d9_50174831 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico"> 

    <title>Identificación en Monitoreo</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="<?php echo $_smarty_tpl->tpl_vars['_WEB_PATH_']->value;?>
/css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" method="POST">
      <img class="mb-4" src="./img/panama fingerprint.png" alt="" width="72" height="72"> <!--introduccion del enlace de la imagen-->
      <?php if (isset($_smarty_tpl->tpl_vars['login_error']->value)) {?>
        <div><?php echo $_smarty_tpl->tpl_vars['login_error']->value;?>
</div>
      <?php }?>
      <h1 class="h3 mb-3 font-weight-normal">Por favor, identifícate</h1>
      <label for="username" class="sr-only">Usuario</label>
      <input type="text" id="username" name="username" class="form-control" placeholder="Usuario" required autofocus>
      <label for="password" class="sr-only">Password</label>
      <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
      
      <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
    </form>
  </body>
</html>
<?php }
}
