<link rel="stylesheet" href="<?=USER_CSS?>questions.css">
<style>
<?php if($this->__("settings.align") == "left"):?>
    .form-group input:checked+label:after {
        left:11%;
    }
<?php else:?>
    .form-group input:checked+label:after {
        right:12%;
    }
<?php endif; ?>
    .form-group label:before {
        margin-<?=$this->__("settings.reverse-align")?>: 5px;
    }
    .main-content>section>.body-for-answers{
        text-align : <?=$this->__("settings.align")?>;
    }
</style>
<section class="main-content questions">
<div></div>
    <section>
        <div class="body-for-answers">
            <div class="title-Question">
                <h2><?=nl2br($this->question_content)?></h2>
            </div>
            <div class="cont-answers">
                <ul>
                <?php foreach($this->answers as $i => $answer):?>
                    <li>
                        <div class="form-group">
                            <input type="radio" name="ans" value="<?=$answer['id']?>" id="checkbox_<?=$i?>">
                            <label class="label_answer" for="checkbox_<?=$i?>"><?=$answer['answer_content']?></label>
                            <span class="check"></span>
                        </div>
                    </li>
                <?php endforeach;?>
                </ul>
                <div class="next-answers text-center">
                    <button class="btn main-btn" id="next-q">Next</button>
                </div>
            </div>
        </div>
    </section>
    <aside class="aside-data">
        <section>
            <span class="precentage-load"></span>
            <header>
                <div class="answers-percentage">
                    <span id="answered">0%</span>
                    <span class="main-color"><?=$this->__("user.questions.answerd_ques")?></span>
                </div>
            </header>
            <section>
                <div class="body-for-instructions">
                    <div class="head-instructions">
                        <span>?</span>
                        <span><?=$this->__("user.questions.important")?></span>
                    </div>
                    <div class="cont-instructions">
                        <ul>
                            <?=$this->__("user.questions.aside_text")?>
                        </ul>
                    </div>
                </div>
            </section>
        </section>
    </aside>
</section>
<script>
    var nextQBtn = $("#next-q");
    const minSuccessPercentage = 70;
    nextQBtn.on("click",function(){
        if($(".cont-answers ul li").find("input:checked").val() == undefined){
            alert("Please Answer The Question !");
            return;
        }
        let data = {
            ans : $(".cont-answers ul li").find("input:checked").val(),
            hash_token : "<?=$this->get_token()?>"
        }
        if(data.ans != ""){
            ajaxRequest("/user/<?=$this->active_page?>/next_question","POST",data,"html",successQues,errorQues);
        }else{
            alert("Please Answer Question !");
        }
    });
    var question_content = $(".title-Question h2"),
        answers = $(".cont-answers ul"),
        question_count = "<?=$this->question_count()?>",
        answered = $("#answered");
    let check_score = {
        data : null,
        is_final_question : function(){
            return (this.data.score != undefined && typeof this.data.score == "number") ? this : false;
        },
        is_success : function(){
            ((this.data.score/question_count)*100) >= minSuccessPercentage ? this.success() : this.failed();
        },
        success : function(){
            alert("<?=$this->active_page == 'join_to_listener' ? 'Congratulations You Now A Listener !' : 'You\'re active now !'?>");
            location.reload();
        },
        failed : function(){
            alert("Sorry You need to take the test again");
            location.reload();
        },
        set_data : function(data){
            this.data = data;
            return this;
        }
    }
    let next_question = {
        question_content : null,
        data : null,
        answered : 0,
        set_answered_question : function(){
            this.answered++;
            var precentage = Math.round((this.answered/question_count)*100) + "%";
            answered.text(precentage);
            $(".main-content>aside>section .precentage-load").css("width",precentage);
        },
        set_question_content : function(){
            this.question_content = this.data[0]["question_content"];
            return this;
        },
        render_new_question : function(){
            question_content.html(nl2br(this.question_content));
            return this;
        },
        remove_current_answers : function(){
            answers.children().remove();
            return this;
        },
        render_new_answers : function (){
            this.data.forEach(function(element,i){
                var html = '<li>';
                    html += '<div class="form-group">';
                    html += '<input type="radio" name="ans" value="'+element.id+'" id="checkbox_'+i+'">';
                    html += '<label class="label_answer" for="checkbox_'+i+'">'+element.answer_content+'</label>';
                    html += '<span class="check"></span></div></li>';
                answers.append(html)
            });
        },
        set_data : function(data){
            this.data = data;
            return this.check_if_there_is_new_question() ? this : false ;
        },
        check_if_there_is_new_question : function(){
            return typeof this.data.score == "undefined";
        }
    }
    function successQues(data){
        var data = JSON.parse(data);
        next_question.set_answered_question();
        try{
            check_score.set_data(data).is_final_question().is_success();
        }catch(e){
            console.log("Not Final Question");
        }
        try{
            next_question.set_data(data).remove_current_answers().set_question_content().render_new_question().render_new_answers();
        }catch(e){
            console.log("Final Question");
        }
    }
    function errorQues(){
        alert("Check Your Internet Connection !");
    }
</script>