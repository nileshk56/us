<div class="container">
    
    <div class="row">
        <div class="col-md-9 ">
            <h3>Search results for <?php echo $searchText ?></h3>
            <br>
            <?php 
                if(!empty($userData)) {
                foreach($userData as $user) {
            ?>
            <div class="row mb-3">
                <div class="col-xs-2">
                    <img src="<?php echo $user['image'] ? $user['image'] : base_url()."public/images/nouser.png"  ?>" class="img-fluid rounded" alt="<?php echo $user['first_name'], " ", $user['last_name'] ?>" width="75px" >
                </div>
                <div class="col-xs">
                <h5> &nbsp; <a href="<?php echo base_url('user/'.$user['user_id']) ?>" class="text-body"><?php echo $user['first_name'], " ", $user['last_name'] ?></a></h5>
                </div>
            </div>
            <?php } } else {?>
                <h4 class="text-danger">No results found.</h4>
            <?php } ?>
        </div>
    </div>

    
</div>