<div class="container">
    
    <div class="row">
        <div class="col-md-9">
            <h3>Search results for <?php echo $searchText ?></h3>
            <hr />

            <?php 
                foreach($userData as $user) {
            ?>
            <div class="row">
                <div class="col-md-2">
                    <img src="<?php echo $user['image'] ? $user['image'] : base_url()."public/images/nouser.png"  ?>" class="img-fluid rounded" alt="<?php echo $user['first_name'], " ", $user['last_name'] ?>" width="100px" >
                </div>
                <div class="col-md">
                <h3><a href="<?php echo base_url('user/'.$user['user_id']) ?>"><?php echo $user['first_name'], " ", $user['last_name'] ?></a></h3>
                </div>
            </div>
            <hr/>
            
            <?php } ?>
        </div>
    </div>

    
</div>