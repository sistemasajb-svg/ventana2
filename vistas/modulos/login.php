<div class="login-box">
    <div class="login-logo">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
    <p href="../../index2.html" hidden><img src="vistas/img/imglogin/logoavicolajb.png" width="320" /></p>

        <p class="login-box-msg" hidden>SISTEMA DE CAJA</p>

        <form method="post">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="usuario" placeholder="usuario">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
               
                <!-- /.col -->
                <div class="btn-lg">
                    <button type="submit" class="btn btn-primary btn-block btn-success">entrar</button>
                </div>
                <!-- /.col -->
            </div>
            <?php 


$login=ControladorUsuarios::ctrIngresoUsuario();



?>

        </form>


        <!-- /.social-auth-links 

        <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a>
-->
    </div>
    <!-- /.login-box-body -->
</div>