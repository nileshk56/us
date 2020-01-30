<input type="hidden" id="user_id" value="<?php echo $userId ?>" />

<div class="row">
      <div class="col-md-3 text-center mb-4">

            <div class="card ">
            <img class="card-img-top" src="<?php echo $userData['image'] ? $userData['image'] : base_url("public/images/nouser.png") ?>" alt="<?php echo $userData['first_name'], " ", $userData['last_name']?>" style="width:100%">
            <div class="card-body">
                <h4 class="card-title"><?php echo $userData['first_name'], " ", $userData['last_name']?></h4>
                <hr />
                <!--<p class="card-text">Let <?php echo $userData['first_name'], " ", $userData['last_name']?> know what do you think about him. <br><br>Your comment will be posted anonymously. <br><br>No Login Required. <br><br><?php echo $userData['first_name'], " ", $userData['last_name']?> may choose to publish your comment on the his profile</p>-->
                <p class="card-text ">
                    <ul class="text-left" style="list-style-type:square;">
                        <li class="mb-2">Let <?php echo $userData['first_name'], " ", $userData['last_name']?> know what do you think about him.</li>
                        <li class="mb-2">Your comment will be posted anonymously. No Login Required</li>
                        <li class="mb-2">You can praise, criticize, abuse, blame <?php echo $userData['first_name'] ?></li>
                        <li><?php echo $userData['first_name'], " ", $userData['last_name']?> may choose to reply and publish your comment on his profile</li>
                    </ul>
                </p>
                
                <a href="#" class="btn btn-primary" id="btnAddComment">Add Comment</a>
            </div>
            </div>

      </div>
        <div class="col-md-6">
            <div class="row" id="divAddThought">
                <div class="col-md-12">
                    <h3>People's Comment</h3>
                    <hr />
                    <form action="<?php echo base_url('user/addthought') ?>" method="post" id="frmAddThought">
                        <div class="form-group">
                        <label for="comment" class="lead font-weight-bold">Your Review:</label>
                        <textarea class="form-control" rows="2" id="comment" name="comment" placeholder="Write what do you think about <?php echo $userData['first_name'], " ", $userData['last_name']?>. Your comment will be completely anonymous. You can praise, criticize, abuse, blame about <?php echo $userData['first_name'] ?>."  required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <input type="hidden" name="to_user_id" value="<?php echo $userId ?>" />
                    </form>
                    <br />
                    <hr />
                    
                </div>

            </div>
            
            <?php
            if(!empty($thoughtsData)) {
            foreach($thoughtsData as $thought) { 
            ?>
            <div class="row" id="thoughtPost<?php echo $thought['thought_id'] ?>">
                <div class="col-md-12 text-justify">
                <span class="lead font-weight-normal"><?php echo $thought['thought_text'] ?></span>
                <br>
                <em class="text-muted small"><?php echo date('M j Y g:i A', strtotime($thought['created']))  ?></em>
                <br>
                
                <?php if($thought['comment']) {?>
                
                <div class="row" style="padding:10px">
                  <div class="col-md-12 ">
                  <b><?php echo $userData['first_name'], " ", $userData['last_name']?>'s reply </b> <br/>
                  <?php echo $thought['comment']?>
                  </div>
                </div>
                <?php } ?>
                
                <hr/>
            </div>
            </div>
            <?php
                }
            } else {
            ?>
            <div class="row" id="divNoComments">
                <div class="col-md-12 text-danger">
                  <h4>No comments yet</h4>
                </div>
              </div>
            <?php } ?>
        </div> 
  </div>


<div id="modalVoteDetails" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">People who voted</h4>
      </div>
      <div class="modal-body" id="modalVoteDetailsBody">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<div id="modalUPP" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Profile Photo</h4>
      </div>
      <div class="modal-body" id="modalVoteDetailsBody">
            <form action="<?php echo base_url()."home/upp" ?>" method="post" enctype="multipart/form-data">
                <div class="input-group">
                    <input type="file" class="form-control input-lg" placeholder="Add Tags" id="upp" name="upp" required>
                    <div class="input-group-btn">
                    <button class="btn btn-primary input-lg" type="submit" id="btnAddTag">
                        Upload
                    </button>
                    </div>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
