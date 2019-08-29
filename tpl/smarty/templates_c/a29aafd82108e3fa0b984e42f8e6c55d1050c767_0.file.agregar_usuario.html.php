<?php
/* Smarty version 3.1.33, created on 2019-08-13 14:53:54
  from '/Applications/nginxstack-1.14.2-3/nginx/html/monitoreo/domingo/agregar_usuario.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d5331726c6ab6_85890421',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a29aafd82108e3fa0b984e42f8e6c55d1050c767' => 
    array (
      0 => '/Applications/nginxstack-1.14.2-3/nginx/html/monitoreo/domingo/agregar_usuario.html',
      1 => 1565733231,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d5331726c6ab6_85890421 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="default col-med-9">
    <div class="panel panel-primary">
        <div class="panel panel-heading"> <centre> <b>Agregar Usuario</b> </centre></div>
        <div class="panel-body" width="95%">
            <form name="agregar_usuario" method="post">
                <div class="form group">
                    <div class="input group">
                        <span class="input-group-addon">Nombre</span> 
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
                    </div>
                </div>
                <div class="form group">
                    <div class="input group">
                        <span class="input-group-addon">Apellidos</span> 
                        <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Apellidos" required>
                    </div>
                </div>
                <div class="form group">
                    <div class="input group">
                        <span class="input-group-addon">Numero de cedula</span> 
                        <input type="text" name="cedula" id="cedula" class="form-control" placeholder="id_cedula">
                    </div>
                </div>
                <div class="form group">
                    <div class="input group">
                        <span class="input-group-addon">Nombre de Login</span> 
                        <input type="text" name="login" id="login" class="form-control" placeholder="login" required>
                    </div>
                </div>
                <div class="form group">
                    <div class="input group">
                        <span class="input-group-addon">Numero de telefono</span> 
                        <input type="text" name="telefono" id="telefono" class="form-control" placeholder="telefono">
                    </div>   
                </div>
                <div class="form group">
                    <div class="input group">
                        <span class="input-group-addon">Password</span> 
                        <input type="password" name="password" id="password" class="form-control" placeholder="***********" required>
                    </div>
                </div>
                <div class="form-group">
                        <label for="tipo_de_usuario">tipo de usuario</label>
                        <select class="form-control" id="tipo_de_usuario" required>
                            <option></option>
                            <option>administrador</option>
                            <option>subreceptor</option>
                            <option>promotor</option>
                            <option>tecnologo</option>
                        </select>
                </div>
                <div class="form-group">
                        <label for="tipo_de_usuario">Ubicacion</label>
                        <select class="form-control" id="tipo_de_usuario" required>
                            <option></option>
                            <option>Bocas del Toro</option>
                            <option>Chiriquí</option>
                            <option>Coclé</option>
                            <option>Colón</option>
                            <option>Herrera</option>
                            <option>Los Santos</option>
                            <option>Panamá Metro</option>
                            <option>Panamá Oeste 1</option>
                            <option>Panamá Oeste 2</option>
                            <option>San Miguelito</option>
                            <option>Veraguas</option>
                        </select>
                </div>
                <div class="form group">
                        <div class="input group">
                            <span class="input-group-addon">Trabaja con el subrecpetor</span> 
                            <input type="text" name="trabaja_con_subreceptor" id="trabaja_con_subreceptor" class="form-control" required>
                        </div>
                </div>
                <div class="form group">
                        <div class="input group">
                            <span class="input-group-addon">Numero de registro (Exclusivo para tecnologos)</span> 
                            <input type="text" name="numero_de_registro" id="numero_de_registro" class="form-control" placeholder="numero_de_registro">
                        </div>
                </div>
            </form>
        </div>

        

    </div>

</div><?php }
}
