function getUserImages()
{
	var surl = siteurl+'admin/media/getMedia';
	$.getJSON(surl,function(response){
	    if (response.success) 
	    {
	    	$('#media').modal('show');
	      	$('.ajax_content_media').html(response.html);	           
	    }
	});
}

$(document).on('click', '.add_media', function (e) {
    
	$('#media').modal('hide');
	$('#upload_media').modal('show');
})

//getImages After Upload By upload images pop up
function renderAjaxImageList(data)
{
	$('#upload_media').modal('hide');
	if(data.media_html)
	{
		CKEDITOR.instances['content'].insertHtml(data.media_html);
	}
}

function useMedia($this)
{
	if($($this).closest('label').hasClass('selected'))
	{
		$($this).closest('label').removeClass('selected');
	}
	else
	{
		$($this).closest('label').addClass('selected');   
	}
}

$(document).on('click', '.use_media', function (e) {    
	var multiple_image = [];
    $(".selected").each(function () {
        multiple_image.push($(this).attr('data-id'));
        var image = $(this).attr('data_url');
        var alt = $(this).attr('data_alt');
		var html = '<img src="'+image+'" alt="'+alt+'" class="img-responsive custom_image"/>';
		CKEDITOR.instances['content'].insertHtml(html);       
    });
    $('#media').modal('hide');
})