var applicationName = 'photo';

var save = function(img, _name, _comment, _x, _y, _width, _height){
	console.dir("Saving " + _name + "'s comment");
	var _url = img.src;
	$.ajax({
    	url: '/'+applicationName+'/photocom.php',
    	type: 'POST',
      	data: { url:_url, name:_name, comment:_comment, x:_x, y:_y, width:_width, height:_height}
    }).done(function(data){
      	console.dir(data);
    });
}

var load = function(img, loadComments){
	console.dir("Reading comments");
	var _url = img.src;
	$.ajax({
		url: '/'+applicationName+'/photocom.php',
		type: 'GET',
		data: { url:_url }
	}).done(function(data){
		var comments = data;
		loadComments(comments);
	});
};