<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-6">
            <form method="post" action="FrontController.php?controller=Usuario&action=login">
                <!-- Email input -->
                <div class="form-group mb-4 ">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" id="email" class="form-control" name="email"  required/>

                </div>

                <!-- Current Password input -->
                <div class="form-group mb-4">
                    <label class="form-label" for="currentPwd">Contraseña actual</label>
                    <input type="password" id="currentPwd" class="form-control" name="pwd" required/>

                </div>
                <!-- Submit button -->
                <input type="submit" class="btn btn-primary btn-block mb-4" value="Iniciar sesión"></button>


            </form>        
            <?php
            echo password_hash("abc123.", PASSWORD_BCRYPT);
            $usuario = $dataToView["data"];
            if($usuario!=null && ($usuario->getStatus()=== Util::OPERATION_NOK)) {
                ?>

                <div class="alert alert-danger" role="alert">
                    <?=LOGIN_ERROR_MSG; ?>
            </div>
            <?php } else {echo "login ok";} ?>
        </div>
    </div>
</div>



