<div class="row">
    <div class="col-lg-12">
        <div class="form-message">
            <?php 
            if (isset($form_message)) {
                echo $form_message;
            }
            ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?=$page_title?> Form
            </div>
            <div class="panel-body">
                <?php echo form_open($form_action,'role="form" enctype="multipart/form-data"'); ?>
                    <!-- /#quiztabs -->
                    <div role="tabpanel" id="tabster">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#quiz" aria-controls="quiz" role="tab" data-toggle="tab">Quiz Info</a></li>
                            <li role="presentation"><a href="#question" aria-controls="question" role="tab" data-toggle="tab">Question</a></li>
                        </ul><!-- Nav tabs -->
                        <!-- /.tab content -->
                        <div class="tab-content">
                            <!-- /#quiz -->
                            <div role="tabpanel" class="tab-pane fade in active" id="quiz">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="quiz_title">Quiz Title</label>
                                            <input type="text" class="form-control" name="quiz_title" id="quiz_title" value="<?=(isset($post['quiz_title'])) ? $post['quiz_title'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="quiz_content">Quiz Content</label>
                                            <textarea class="form-control ckeditor" name="quiz_content" id="quiz_content" rows="8"><?=(isset($post['quiz_title'])) ? $post['quiz_content'] : ''?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="start_date">Start Date</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" name="start_date" id="start_date" value="<?=(isset($post['start_date'])) ? $post['start_date'] : date('Y-m-d')?>" readonly="readonly"/>
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="end_date">End Date</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" name="end_date" id="end_date" value="<?=(isset($post['end_date'])) ? $post['end_date'] : date('Y-m-d')?>" readonly="readonly"/>
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="uri_path">SEO URL / SLUG</label>
                                            <input type="text" class="form-control" name="uri_path" id="uri_path" value="<?=(isset($post['uri_path'])) ? $post['uri_path'] : ''?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="uri_path">Question</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name="is_question" id="is_question" <?=(isset($post['is_question']) && !empty($post['is_question'])) ? 'checked="checked"' : ''?>/>Yes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="quiz_status">Status</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name="quiz_status" id="quiz_status" <?=(isset($post['quiz_status']) && !empty($post['quiz_status'])) ? 'checked="checked"' : ''?>/>Active
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_site">Site</label>
                                            <?php
                                        if(!isset($list_site)){


                                            foreach ($sites as $key => $value) {
                                            

                                            ?>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" <?= (isset($post['id_site'][$key]) && !empty($post['id_site'][$key])) ? 'checked="checked"' : '' ?> value="<?=$value['id_site']?>" name="id_site[]" id="id_site"/><?=$value['site_name']?>
                                                </label>
                                            </div>
                                            <?php
                                             }
                                         }else{
                                            foreach ($sites as $key => $value) {
                                                $checked_p="";
                                                if(in_array($value['id_site'], $list_site)){
                                                    $checked_p = 'checked="checked"';
                                                }
                                            ?>

                                            <div class="checkbox">
                                                <label>
                                                    <input <?=$checked_p?> type="checkbox" <?= (isset($post['id_site'][$key]) && !empty($post['id_site'][$key])) ? 'checked="checked"' : '' ?> value="<?=$value['id_site']?>" name="id_site[]" id="id_site"/><?=$value['site_name']?>
                                                </label>
                                            </div>
                                            <?php
                                            }
                                         }
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php if (isset($post['quiz_image']) && $post['quiz_image'] != ''): ?>
                                                        <img src="<?=AZURE_BLOB_URLPREFIX.AZURE_FOLDER_QUIZ.'/'.$post['quiz_image']?>" id="post-image" />
                                                        <span class="btn btn-danger btn-delete-photo" id="delete-picture" data-id="<?=$post['id_quiz']?>">x</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                        <input type="file" name="quiz_image">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /#quiz -->
                            <!-- /#answer -->
                            <div role="tabpanel" class="tab-pane fade" id="question">
                                <div class="row group-form-field">
                                    <?php if (isset($post['question'])) : ?>
                                    <?php foreach ($post['question'] as $row => $question): ?>
                                        <?php if (isset($post['id_quiz'])) : ?>
                                            <div class="row-question" id="row-question-<?=$row?>">
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label for="question_<?=$row?>">Question</label>
                                                        <textarea class="form-control" name="question[<?=$row?>][question]" id="question_<?=$row?>"><?=(isset($question['question'])) ? $question['question'] : ''?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="question_type_<?=$row?>">Type</label>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="question[<?=$row?>][question_type]" id="question_type_<?=$row?>_1" data-row="<?=$row?>" value="1" <?=((isset($question['question_type']) && $question['question_type'] == 1) ? 'checked="checked"' : '')?>/>Input Text
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="question[<?=$row?>][question_type]" id="question_type_<?=$row?>_2" data-row="<?=$row?>" value="2" <?=((isset($question['question_type']) && $question['question_type'] == 2) ? 'checked="checked"' : '')?>/>Textarea
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="question[<?=$row?>][question_type]" id="question_type_<?=$row?>_3" data-row="<?=$row?>" value="3" <?=((isset($question['question_type']) && $question['question_type'] == 3) ? 'checked="checked"' : '')?>/>Multiple Choice
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label for="question_position_<?=$row?>">Position</label>
                                                        <input type="text" class="form-control" name="question[<?=$row?>][position]" id="question_position_<?=$row?>" value="<?=(isset($question['position'])) ? $question['position'] : ''?>"/>
                                                    </div>
                                                    <input type="hidden" name="question[<?=$row?>][id_quiz_question]" value="<?=$question['id_quiz_question']?>" />
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label style="display:block;">&nbsp;</label>
                                                        <button type="button" class="btn btn-danger" onclick="removeQuestion('<?=$row?>');">-</button>
                                                    </div>
                                                </div>
                                                <?php if($question['answer'] && $question['question_type'] == 3) { ?>
                                                <div class="col-lg-12">
                                                    <div id="answer_question_type_<?=$row?>_3" class="row" style="display:block;">
                                                        <?php foreach ($question['answer'] as $key => $value) {
                                                            $ex_value = explode(',', $value)
                                                        ?>
                                                        <div class="col-sm-4">
                                                            <input type="text" placeholder="jawaban A" class="form-control" name="question[<?=$row?>][answer][<?=$ex_value[1]?>]" value="<?=$ex_value[0]?>" />
                                                        </div>
                                                        <?php } ?>
                                                        
                                                    </div>
                                                </div>
                                                <?php }else{ ?> 
                                                    <div class="col-lg-12">
                                                        <div id="answer_question_type_<?=$row?>_3" class="row" style="display:none;">
                                                            <div class="col-sm-4">
                                                                <input type="text" placeholder="jawaban A" class="form-control" name="question[<?=$row?>][answer][]"  value=""/>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <input type="text" placeholder="jawaban B" class="form-control" name="question[<?=$row?>][answer][]"  value=""/>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <input type="text" placeholder="jawaban C" class="form-control" name="question[<?=$row?>][answer][]"  value=""/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="row-question" id="row-question-<?=$row?>">
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label for="question_<?=$row?>">Question</label>
                                                        <textarea class="form-control" name="question[<?=$row?>][question]" id="question_<?=$row?>"><?=(isset($question['question'])) ? $question['question'] : ''?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="question_type_<?=$row?>">Type</label>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="question[<?=$row?>][question_type]" id="question_type_<?=$row?>_1" value="1" <?=((isset($question['question_type']) && $question['question_type'] == 1) ? 'checked="checked"' : '')?>/>Input Text
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="question[<?=$row?>][question_type]" id="question_type_<?=$row?>_2" value="2" <?=((isset($question['question_type']) && $question['question_type'] == 2) ? 'checked="checked"' : '')?>/>Textarea
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="question[<?=$row?>][question_type]" id="question_type_<?=$row?>_3" value="3" <?=((isset($question['question_type']) && $question['question_type'] == 3) ? 'checked="checked"' : '')?>/>Multiple Choice
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label for="question_position_<?=$row?>">Position</label>
                                                        <input type="text" class="form-control" name="question[<?=$row?>][position]" id="question_position_<?=$row?>" value="<?=(isset($question['position'])) ? $question['position'] : ''?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label style="display:block;">&nbsp;</label>
                                                        <button type="button" class="btn btn-danger" onclick="removeQuestion('<?=$row?>');">-</button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="row group-form-button">
                                    <div class="col-lg-2 col-lg-offset-10 text-right">
                                        <button type="button" class="btn btn-success" onclick="addQuestion();">+</button>
                                    </div>
                                </div>
                            </div><!-- /#answer -->
                        </div><!-- /.tab content -->
                    </div><!-- /#quiztabs -->
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a class="btn btn-danger" href="<?=$cancel_url?>">Cancel</a>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                <?php echo form_close(); ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<script type="text/javascript">
    $(function() {
        <?php if (isset($post['id_quiz'])): ?>
        $("#delete-picture").click(function() {
            var self = $(this);
            var id = self.attr('data-id');
            var post_delete = [{name:"id",value:id}];
            post_delete.push({name:token_name,value:token_key});
            $.ajax({
                url:'<?=$delete_picture_url?>',
                type:'post',
                data:post_delete,
                dataType:'json',
                beforeSend: function() {
                    self.attr('disabled',true);
                }
            }).always(function() {
                self.removeAttr('disabled');
            }).done(function(data) {
                if (data['error'])  {
                    $(".flash-message").html(data['error']);
                }
                if (data['success']) {
                    $(".flash-message").html(data['success']);
                    $("#post-image").remove();
                    self.remove();
                }
            });
        });

        <?php endif; ?>
    });
    var html;
    function addQuestion() {
        var row = $(".row-question").length;
        var not_show = '';
        if (row > 0) {
            not_show = 'style="display:none;"';
        }
        html = '\
            <div class="row-question" id="row-question-'+row+'">\
                <div class="col-lg-8">\
                    <div class="form-group">\
                        <label for="question_'+row+'" '+not_show+'>Question</label>\
                        <textarea class="form-control" name="question['+row+'][question]" id="question_'+row+'"></textarea>\
                    </div>\
                </div>\
                <div class="col-lg-2">\
                    <div class="form-group">\
                        <label for="question_type_'+row+'" '+not_show+'>Type</label>\
                        <div class="radio">\
                            <label>\
                                <input type="radio" name="question['+row+'][question_type]" data-row="'+row+'" id="question_type_'+row+'_1" value="1" checked="checked" />Input Text\
                            </label>\
                        </div>\
                        <div class="radio">\
                            <label>\
                                <input type="radio" name="question['+row+'][question_type]" data-row="'+row+'" id="question_type_'+row+'_2" value="2" />Textarea\
                            </label>\
                        </div>\
                        <div class="radio">\
                            <label>\
                                <input type="radio" name="question['+row+'][question_type]" data-row="'+row+'" class="multiple" id="question_type_'+row+'_3" value="3" />Multiple Choice\
                            </label>\
                        </div>\
                    </div>\
                </div>\
                <div class="col-lg-1">\
                    <div class="form-group">\
                        <label for="question_position_'+row+'" '+not_show+'>Position</label>\
                        <input type="text" class="form-control" name="question['+row+'][position]" id="question_position_'+row+'" value=""/>\
                    </div>\
                    <input type="hidden" name="question['+row+'][id_quiz_question]" value="0" />\
                </div>\
                <div class="col-lg-1">\
                    <div class="form-group">\
                        <label style="display:block;">&nbsp;</label>\
                        <button type="button" class="btn btn-danger" onclick="removeQuestion(\''+row+'\');">-</button>\
                    </div>\
                </div>\
                <div class="col-lg-12">\
                    <div id="answer_question_type_'+row+'_3" class="row" style="display:none;">\
                        <div class="col-sm-4">\
                            <input type="text" placeholder="jawaban A" class="form-control" name="question['+row+'][answer][]"  value=""/>\
                        </div>\
                        <div class="col-sm-4">\
                            <input type="text" placeholder="jawaban B" class="form-control" name="question['+row+'][answer][]"  value=""/>\
                        </div>\
                        <div class="col-sm-4">\
                            <input type="text" placeholder="jawaban C" class="form-control" name="question['+row+'][answer][]"  value=""/>\
                        </div>\
                    </div>\
                </div>\
            </div><br>';
        $(".group-form-field").append(html);
        //row++;
    }
    
    function removeQuestion(id) {
        $("#row-question-"+id).remove();
    }
    $("#quiz_title").keyup(function() {
        $("#uri_path").val(convert_to_uri(this.value));
        
    });
    $(document).on('change', 'input:radio[id^="question_type_"]', function (event) {

        var val = $(this).val();
        var id = $(this).attr('id');
        var el = '#answer_'+id;
        var row = $(this).attr('data-row');
        if(val == 3){
            $(el).show();
        }else{
            alert(row);
            $('#answer_question_type_'+row+'_3').hide();
        }
        
    });
</script>
