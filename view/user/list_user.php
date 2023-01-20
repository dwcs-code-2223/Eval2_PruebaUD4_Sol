<div class="row">
    <div class="col-md-12 text-right">
      
    </div>
    <?php if (count($dataToView["data"]) > 0) {
        
        echo "count: ". count($dataToView["data"]);
        ?>

        <table class="table">
            <thead>
                <tr>

                    <th scope="col">Email</th>
                    <th scope="col">Roles</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataToView["data"] as $user) { ?>
                    <tr>
                        <td><?= $user->getEmail() ?></td>
                        <td><?=$user->getRoleNamesCSV();
                      
                      ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    <?php} else {?>
        
        <div class="alert alert-info">
            Actualmente no existen usuarios.
        </div>
        <?php
    }
    ?>
</div>