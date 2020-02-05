<div class="container">

    <div class="row">
        <div class="col-md-6 text-left" style="padding-top:30px">
            <h1 class="display-4">What is Unsaidstuff</h1>
            <br>
            <h4><small>
            <ul style="list-style-type:square;">
                <li class="mb-3 text-left">Checkout what people are saying about you</li>
                <li class="mb-3 text-left">You will get anonymous comments, comments will be completely private, No one can see your comments except you</li>
                <li class="mb-3 text-left">If you want to show your favorite comment on your profile then you can choose to publish it</li>
                <li class="mb-3 text-left">People may praise you, criticize you, abuse you, blame you but use that all feedback to improve yourself</li>
                <li class="mb-3 text-left">You can reply on comments</li>
                <li class="text-left">Share your profile on social media and ask your friends, colleague, relatives to give you comments anonymously</li>
            </ul></small>
            </h4>
        </div>
        
        <div class="col-md-6" style="padding-top:30px">
            <h1 class="display-4">Sign Up</h1>
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
                                <input type="radio" class="form-check-input" name="gender" value="F">Female
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