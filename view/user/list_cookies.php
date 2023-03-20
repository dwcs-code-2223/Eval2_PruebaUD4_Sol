<!<!-- h) -->
<div class="row">
    <div class="col-md-12 text-right">
      
    </div>
    <?php if (count($dataToView["data"]) > 0) : ?>

        <table class="table">
            <thead>
                <tr>

                    <th scope="col">Cookie name</th>
                    <th scope="col">Cookie value</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataToView["data"] as $key => $value) {
                        
                     ?>
                    <tr>
                        <td><?= $key ?></td>
                        <td><?=$value
                      
                      ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    <?php endif;
    
    if(count($dataToView["data"])===0):?>
        
        <div class="alert alert-info">
            Actualmente no existen cookies.
        </div>
        <?php
    endif;
    ?>
</div>