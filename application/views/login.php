<div class="container">

    <div class="row">
        <div class="col-md-5 text-left" style="padding-top:50px">
            <h1>What is Unsaidstuff</h1>
            <br>
            <h4><small>
            <ul class="list-unstyled">
                <li class="mb-3 text-justify">See what other people think about you by taking your anonymous review</li>
                <li class="mb-3 text-justify">Reviews are completely private, no one can see them but you can publish good reviews on your profile. Others will see only published reviews on your profile.</li>
                <li class="mb-3 text-justify">You can reply on review</li>
                <li class="mb-3 text-justify">People will criticize you, abuse you, blame you but use that all feedback to improve yourself</li>
                <li class="text-justify">Share your profile on social network and ask your friends, colleague, relatives to give your review anonymously</li>
            </ul></small>
            </h4>
        </div>
        <div class="col-md-1">&nbsp;</div>
        <div class="col-md-6" style="padding-top:50px">
            <h1>Sign Up</h1>
            <br>
            <form action="<?php echo base_url("home/signup") ?>" method="post">
                <div class=" form-group form-row">
                    <div class="col-sm-5">
                        <input type="text" class="form-control input-lg mb-2" id="first_name" name="first_name" placeholder="First Name">
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control input-lg" id="last_name" name="last_name" placeholder="Last Name">
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col-sm-10">
                        <input type="email" class="form-control input-lg" id="email"  name="email" placeholder="Email">
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col-sm-10"> 
                        <input type="password" class="form-control input-lg" id="password" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col-sm-10"> 
                        <!--<label class="radio-inline input-lg">
                            <input type="radio" name="gender" value="M">Male
                        </label>
                        <label class="radio-inline input-lg">
                            <input type="radio" name="gender" value="F">Female
                        </label>--> 
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="gender" value="M">Male
                            </label>
                            </div>
                            <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="gender" value="M">Female
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group form-row"> 
                    <div class="col-sm-10">
                    <button type="submit" class="btn btn-success input-lg">Sign Up</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row ">
        <div class="col-md-12 text-center p-2 mt-5 mb-0 p-md-2 border-top text-muted">
            Unsaidstuff.com@2020
        </div>
    </div>
</div>