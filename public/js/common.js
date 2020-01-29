$( document ).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();  
    $('[data-toggle="popover"]').popover();  

    $("#frmAddThought").submit(function(e) {

        //prevent Default functionality
        e.preventDefault();

        //get the action-url of the form
        var actionurl = e.currentTarget.action;
        var data = $("#frmAddThought").serialize();
        var comment = $("#frmAddThought #comment").val();
        //do your own request an handle the results
        $.ajax({
            url : actionurl,
            type : 'post',
            data : data,
            success : function(data) {
                var obj = JSON.parse(data);
                
                $("#modalMSGTitle").html("Success");
                $("#modalMSGBody").html("Your comment is submitted anonymously. It will be shown on user profile once user publish it.");
                $("#modalMSG").modal();
                
                $("#frmAddThought")[0].reset();
            }, 
            error : function(data) {
                var obj = JSON.parse(data.responseText)
                //$("#divAddTag").append('<div class="alert alert-danger">' + data.msg + '</div>');
                $("#modalMSGTitle").html("Error");
                $("#modalMSGBody").html(obj.msg);
                $("#modalMSG").modal();
                $("#frmAddThought")[0].reset();
            }
        });

    });

   /* //$( ".divTags button" ).click(function() {
    $( ".btn-vote" ).click(function() {
        console.log("clicked")
        var tagId = $(this).data('tagid');
        var tagIdCount = parseInt($("#badgeTagCount_" + tagId).html());
        var tagIdCount = parseInt($(this +" .badge").html());
        tagIdCount++;
        console.log(tagIdCount);
        return false;
        $.ajax({
            url : HOST + "user/add_vote",
            type : 'post',
            data : { tag_id: tagId, to_user_id: $("#user_id").val() },
            success : function(data) {
                $("#badgeTagCount_" + tagId).html(tagIdCount);
                $(this).removeAttr("href");
                $(this).addClass("text-muted");
            }, 
            error : function(data) {
                var obj = JSON.parse(data);
            }
        });   
    });*/

    //$( ".btn-vote" ).click(function() {
    $( ".divTags" ).on('click', '.btn-vote', function() {
        var tagId = $(this).data('tagid');
        var tagIdCount = parseInt($(this).children(".badge").html());
        tagIdCount++;
        var btn = $(this);
        $.ajax({
            url : HOST + "user/add_vote",
            type : 'post',
            data : { tag_id: tagId, to_user_id: $("#user_id").val() },
            success : function(data) {
                btn.children(".badge").html(tagIdCount);
                btn.addClass("disabled");
            }, 
            error : function(data) {
                btn.addClass("disabled");
            }
        });   
    });

    $("#btnUPP").click(function(){
        $("#modalUPP").modal()
    });
    $("#btnAddComment").click(function(){
        $("#comment").focus()
    });
    
    $( "#divAllThoughts" ).on('click', '.publishThought', function() {
        var thoughtId = $(this).data('thoughtid');
        $.ajax({
            url : HOST + "home/publish/" + thoughtId,
            type : 'GET',
            success : (data)=>{
                $(this).removeClass("publishThought");
                $(this).addClass("unpublishThought");
                $(this).html("Unpublish");
            }
        }); 
        return false; 
    });

    $( "#divAllThoughts" ).on('click', '.unpublishThought', function() {
        var thoughtId = $(this).data('thoughtid');
        $.ajax({
            url : HOST + "home/unpublish/" + thoughtId,
            type : 'GET',
            success : (data)=> {
                $(this).removeClass("unpublishThought");
                $(this).addClass("publishThought");
                $(this).html("Publish")
            }
        }); 
        return false; 
    });

    $(".replyThought").click(function(){
        var thoughtId = $(this).data('thoughtid');
        $("#divReplyThought"+thoughtId).show(); 
        return false; 
    });

    $(".deleteThought").click(function(){
        
        var r = confirm("Do you want to delete?");

        if(r == false) {
            return false;
        }

        var thoughtId = $(this).data('thoughtid');
        $.ajax({
            url : HOST + "home/deletethought/" + thoughtId,
            type : 'GET',
            success : (data)=> {
                $("#thoughtPost"+thoughtId).hide()
            }
        }); 
        return false; 
    });
    
    
    $( "#divAllThoughts" ).on('click', '.deleteReply', function() {
        
        var r = confirm("Do you want to delete?");

        if(r == false) {
            return false;
        }

        var replyId = $(this).data('replyid');
        $.ajax({
            url : HOST + "home/deletereply/" + replyId,
            type : 'GET',
            success : (data)=> {
                $(this).parent().hide()
            }
        }); 
        return false; 
    });

    $(".frmReplyThought").submit(function(e) {
         //prevent Default functionality
         e.preventDefault();

         //get the action-url of the form
         var actionurl = e.currentTarget.action;
         var data = $(this).serialize();
         var reply = $(this).find("#commentReply").val()

         $.ajax({
            url : actionurl,
            type : 'post',
            data : data,
            success : (data) => {
                var obj = JSON.parse(data);
                $(this).parent().html('<b>Your Reply</b><br/>'+reply);
            }, 
            error : function(data) {
                var obj = JSON.parse(data.responseText)
                //$("#divAddTag").append('<div class="alert alert-danger">' + data.msg + '</div>');
                $("#modalMSGTitle").html("Error");
                $("#modalMSGBody").html(obj.msg);
                $("#modalMSG").modal();
            }
        });
        
    });

    $(".btnShareCmnt").click(function(){
        var objSocialShareUrls = $(this).data('socialshareurls') ;
        $("#modalShareCmnt .fa-facebook-square").attr('href', objSocialShareUrls.facebook);
        $("#modalShareCmnt .fa-twitter-square").attr('href', objSocialShareUrls.twitter);
        $("#modalShareCmnt .fa-whatsapp-square").attr('href', objSocialShareUrls.whatsapp);
        $("#modalShareCmnt").modal()
    });
});

function getVoteDetails(tagId, userId) {
    $.ajax({
        url : HOST + "home/vote_details/"+tagId+"/"+userId,
        success : function(data) {
            var results = JSON.parse(data);
            console.log(results)
            var html = '<div class="container">';

            for(var i=0; i<results.length; i++) {
                html += '<div class="row"><div class="col-md">';
                html += '<h4><a href="'+HOST+'user/'+results[i]['user_id']+'">'+results[i]['first_name']+' '+results[i]['last_name']+'</a></h4>'
                html += '</div></div>';
            }
            html += '<div>';
            $("#modalVoteDetailsBody").html(html);
            $("#modalVoteDetails").modal()

        }, 
        error : function(data) {
            var obj = JSON.parse(data);
        }
    }); 
    return false;
}
/*$( document ).ready(function() {
    $( "#txtSearch" ).focus(function() {
       $("#searchModal").modal()
    });

    $( ".post_comment" ).click(function() {
        $("#modalPostComment").modal()
    });

    $( "#link_post_comment" ).click(function() {
        $("#modalPostComment").modal()
    });
    

    /*$("#frm_post_comment").submit(function(e) {

        //prevent Default functionality
        e.preventDefault();

        //get the action-url of the form
        var actionurl = e.currentTarget.action;
    
        //do your own request an handle the results
        $.ajax({
                url: actionurl,
                type: 'post',
                data: $("#frm_post_comment").serialize(),
                success: function(data) {
                    console.log("Ajax Post", actionurl, data);
                }
        });

    });
    
});

function postVote(object_id, type, vote_type) {
    
    var url = HOST + "home/post_vote?post_type="+type+"&object_id="+object_id+"&vote_type="+vote_type;
    $.get(url, function(data, status){
        var count = parseInt($("#"+type+"fakeVoteCount_"+object_id).html());
        var countNF = parseInt($("#"+type+"notfakeVoteCount_"+object_id).html());

        if(vote_type) {
            countNF++;
        } else {
            count++;
        }
        
        $("#div"+type+"Fake_"+object_id).html("<h4>"+(count) +" Fake</h4>");
        $("#div"+type+"Fake_"+object_id).addClass("text-muted");

        $("#div"+type+"NotFake_"+object_id).html("<h4>"+(countNF) +" Not Fake</h4>");
        $("#div"+type+"NotFake_"+object_id).addClass("text-muted");
    });
    return false;
}

function commentVote(object_id, type, vote_type) {
    
    var url = HOST + "home/post_vote?post_type="+type+"&object_id="+object_id+"&vote_type="+vote_type;
    $.get(url, function(data, status){
        var countU = parseInt($("#"+type+"UpvoteCount_"+object_id).html());
        var countD = parseInt($("#"+type+"DownvoteCount_"+object_id).html());

        if(vote_type) {
            countU++;
        } else {
            countD++;
        }
        
        $("#div"+type+"Votes_"+object_id).html(countU +" Upvote " + " &nbsp; " + countD + " Downvote");
        
    });
    return false;
}

function validateForm(obj) {
    var msg = '';
    var strTags = $("#"+obj+" #tags").val().trim();
    
    if(strTags[0] != "#") {
        msg = "HashTag should start with #";
    }
    strTags = strTags.substr(1);
    var arrTags = strTags.split("#");
    for(var i=0; i<arrTags.length; i++) {
        var tag = arrTags[i].trim();
        if(tag.match(/^[\w\.()\-,;_&*!@$%]*$/)) {
            arrTags[i] = tag;
        } else {
            msg = "Invalid HashTags, mulitiple hashtags should be separated by space";
            break;
        }
    }
    if(msg) {
        $("#frmPostErrMsg").show();
        $("#spnPostErrMsg").html(msg);
        return false;
    }

    $("#"+obj+" #post_tags").val(arrTags.join(','));
    return true;
}*/

