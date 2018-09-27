$ = jQuery;
var count = $("#header_count").val();
var countArray = [];
var deletedArray = [];
var exsistingArrayString = $("#exsistingArray").val();
if(exsistingArrayString){
    var exsistingArray = exsistingArrayString.split(',');
    for (var i = 0; i < exsistingArray.length; i++) {
        countArray.push(Number(exsistingArray[i]));
    }
}
var valid = true;
var options = '<option value="null">What page do you want to link to?</option>';
for (var i = 0; i < pageList.length; i++) {
    options += '<option value="'+pageList[i].ID+'">'+pageList[i].post_title+'</option>';
}

jQuery( document ).ready( function( $ ) {
	// Loop over each control and transform it into our color picker.
	$( '.customize-control-alpha-color' ).each( function() {
		// Move title & notification into visible position
		var $parent = $(this).closest('li.customize-control-alpha-color');
		$parent.find('div.customize-control-notifications-container').prependTo($parent);
		$parent.find('span.customize-control-title').prependTo($parent);
    });

	//Prevent Dragging Meta Boxes
	$('.meta-box-sortables').sortable({
		disabled: true
	});
	$('.postbox .hndle').css('cursor', 'pointer');

	createTinyMCE('header_description');
    createTinyMCE('page_description');
	for (var i = 0; i < exsistingArray.length; i++) {
		altTinyMCE('section_content_'+exsistingArray[i]);
	}
});

$(document).on('click', '.set_custom_images', function(e) {
    e.preventDefault();
    var button = $(this);
    var id = button.prev();
    wp.media.editor.send.attachment = function(props, attachment) {
        id.val(attachment.id);
    };
    wp.media.editor.open(button);
    id.show();
    return false;
});

$(document).on('click', '.remove_custom_images', function(e){
    e.preventDefault();
    $(this).parent().find('.process_custom_images').val('');

});

$('#addNewSection').click(function(){
    event.preventDefault();

    if(valid == true){
        count++;
        $("#header_count").attr('value', count);
        countArray.push(count);
        var arrayString = countArray.toString();
        $("#exsistingArray").attr('value', arrayString);

        $(this).parents('.inside').append('<div class="newAlternatingSection" data-id="'+count+'">'+
			'<h3>Section</h3>'+
            '<div>'+
                '<div class="form-group">'+
                    '<label>Section Title</label>'+
                    '<input class="customInput" type="text" name="section_title_'+count+'">'+
                '</div>'+
                '<div class="form-group">'+
                    '<label>Section Content (required)</label>'+
                    '<textarea class="customTextarea" id="section_content_'+count+'" rows="4" name="section_content_'+count+'"></textarea>'+
                '</div>'+
            '</div>'+
			'<div class="halfSection">'+
				'<div class="form-group">'+
					'<label>Section Image</label>'+
					'<input type="number" value="" class="customInput regular-text process_custom_images" name="section_image_'+count+'" max="" min="1" step="1" readonly>'+
					'<button class="set_custom_images button">Set Image ID</button>'+
				'</div>'+
				'<div class="form-group">'+
					'<label>Image Clickable</label>'+
					'<input type="checkbox" name="section_image_link_'+count+'">'+
				'</div>'+
			'</div>'+
			'<div class="halfSection">'+
				'<div class="form-group">'+
					'<label>Link to Page </label><br>'+
					'<select class="customInput" name="section_link_'+count+'">'+
					options+
					'<option>---</option>'+
					'<option value="externalPage">Link to external Page</option>'+
					'</select>'+
					'<div class="externalLink" style="display:none;"><label>External Link</label><input type="text" class="customInput" name="section_external_link_'+count+'"></div>'+
				'</div>'+
				'<div class="form-group">'+
					'<label>Button Label</label>'+
					'<input type="text" value="Read More" class="customInput" name="section_button_'+count+'">'+
				'</div>'+
			'</div>'+
			'<div class="form-group">'+
				'<button class="remove_section_button button">Remove Section</button>'+
			'</div>'+
        '</div>');
        valid = false;
        altTinyMCE('section_content_'+count);
    } else {
        if(!$('.alert-error').length){
            $(this).parents('.inside').prepend('<div class="alert-error">Please fill out at least the section content before adding another section.</div>');
        }
    }
});

$(document).on('blur', '.customTextarea', function(e) {
    if($(this).val().length > 0){
        valid = true;
        $(".alert-error").remove();
    } else {
        valid = false;
    }
});

$(document).on('change', 'select.customInput', function(e){
    var value = $(this).val();
    if(value == 'externalPage'){
        $(this).parent().find('.externalLink').show();
    } else {
        $(this).parent().find('.externalLink').hide();
        $(this).parent().find('input').val("");
    }
});

$(document).on('click', '.remove_section_button', function(e) {
    e.preventDefault();
    var id = $(this).parents('.newAlternatingSection').data('id');
    deletedArray.push(id);
    var index = countArray.indexOf(id);
    if (index > -1) {
      countArray.splice(index, 1);
    }
    var arrayString = countArray.toString();
    var deleteString = deletedArray.toString();

    $("#exsistingArray").attr('value', arrayString);
    $("#deletingArray").attr('value', deleteString);
    $(this).parents('.newAlternatingSection').remove();
});

$('#publish').click(function(){
    event.preventDefault();
    if(valid == false){
        if(!$('.alert-error').length){
            $(this).parents('.inside').prepend('<div class="alert-error">Please fill out at least the section content before adding another section.</div>');
        }
    } else {
        $('#post').submit();
    }
});

function createTinyMCE(ID){
    var editorID = ID;
    tinymce.EditorManager.init({
        plugins: 'link',
        menubar: false,
         toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignnone | link ',
        setup:function(ed) {

        }
    });
    tinymce.EditorManager.execCommand('mceAddEditor', true, editorID);
}

function altTinyMCE(ID){
    var editorID = ID;
    tinymce.EditorManager.init({
        plugins: 'link',
        menubar: false,
         toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignnone | link ',
        setup:function(ed) {
            ed.on('blur', function(e) {
                if(ed.getContent()){
                    valid = true;
                    $(".alert-error").remove();
                } else {
                    valid = false;
                }
            });
        }
    });
    tinymce.EditorManager.execCommand('mceAddEditor', true, editorID);
}
