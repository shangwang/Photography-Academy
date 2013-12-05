(function ($) {

	$.fn.imageComment = function(options) {
		
		return this.each(function(i){
			// Wrapping image with container
			var container = $('<div class="imageCommentContainer"></div>');
			$(this).wrap(container); // $(this) is the image element
			container = $(".imageCommentContainer:last"); // For some reason, this needs to be reselected
			
			// Adding list element
			var list = $('<ul class="imageCommentList"></ul>');
			var overlay = $('<div class="overlay"></div>');
			overlay.width($(this).width());
			var selection = $('<div class="selection"></div>'); // TODO custom text
			var commentText = $('<p>Add your comment:</p>');
			var commentInput = $('<textarea></textarea>');
			var submitBtn = $('<a href="#">Submit</a>') // TODO custom text
			var commentBox = $('<div class="commentBox"></div>');
			commentBox.append(commentText);
			commentBox.append(commentInput);
			commentBox.append(submitBtn);
			overlay.append(commentBox);
			container.append(overlay, list, selection);
			
			// Load existing comments
			if(options.load !== undefined){

				var addComments = function(comments){
					for(c in comments){
						addCommentToList(comments[c].name, comments[c].comment, comments[c].x, comments[c].y, comments[c].width, comments[c].height);
					}
				}
				options.load(this, addComments);
			}

			var startingX = 0;
			var startingY = 0;

			/*
			 * Handles the start of the drag
			 */
			function dragStart(e){
				
				// Obtaining starting point
				startingX = e.originalEvent.offsetX;
				startingY = e.originalEvent.offsetY;
				
				// Repositioning the selection div
				selection.css('left', startingX);
				selection.css('top', startingY);
				
				// Resizing the selection div to 0 x 0
				selection.width(0);
				selection.height(0);

				// Displaying the selection div
				selection.fadeIn('fast');
				commentBox.hide();
			};

			/*
			 * Handles data during the drag action
			 */
			function drag(e){
				// Stopping image from being dragged

				// Getting x and y from initial position
				var x = e.originalEvent.offsetX,
					y = e.originalEvent.offsetY;

				console.dir(x + "," + y);

				/*
					When the drag is released, it reverts the x and y back to the origin.
					This conditional stops that from happening
				*/
				if(x > 0 && y > 0){				
					// Calculating the height and width
					var width = x - startingX;
					var height = y - startingY;

					// Setting the width
					if(width > 0){
						selection.width(width);
					} else {
						selection.css('left', startingX+width);
						selection.width(-width);
					}

					// Setting the height
					if(height > 0){
						selection.height(height);	
					} else {
						selection.css('top', startingY+height);
						selection.height(-height);	
					}
				}
			};

			/*
			 * Finishes the drag and triggers the dialog
			 */
			function dragEnd(e){
				// Positioning and resizing comment box
				commentBox.css('left', parseInt(selection.css('left')));
				commentBox.css('top', parseInt(selection.css('top')) + selection.height() + 1);
				commentBox.width(selection.width() - parseInt(commentBox.css('padding-left')) * 2);
				// Displaying comment box
				commentBox.fadeIn('fast');
			};

			function postComment(img){
				// Retrieving values
				var username = options.username ? options.username : 'John Doe'; // TODO dynamic username
				var message = commentInput.val();
				var x = startingX;
				var y = startingY;
				var width = selection.width();
				var height = selection.height();

				// Adding comment to list
				addCommentToList(username, message, x, y, width, height);

				// Saving comment
				options.save(img, username, message, x, y, width, height);

				// Cleaning up and hiding things
				commentInput.val('');
				commentBox.fadeOut('fast');
				selection.fadeOut('fast');	
			};

			/*
			 * Creates the HTML for a single comment in the comments sidebar
			 */
			function createComment(username, comment, x, y, width, height){
				var item = $('<li></li>');
				var content = $('<strong>' + username + ' says: </strong><p>' + comment + '</p><input type="hidden" value="{x:'+x+', y:'+y+', w:'+width+', h:'+height+'}"/>');
				item.append(content);
				return item;
			};

			function addCommentToList(name, comment, x, y, w, h){
				var comment = createComment(name, comment, x, y, w, h);
				comment.on('mouseover', function(e){
					e.stopPropagation();
					e.preventDefault();
					highlightComment(x, y, w, h);
				});
				comment.on('mouseout', function(e){
					e.stopPropagation();
					e.preventDefault();
					hideComment();
				});
				list.append(comment);
			};

			function highlightComment(x, y, w, h){
				selection.css('left', x);
				selection.css('top', y);
				selection.width(w);
				selection.height(h)
				selection.show();
			}

			function hideComment(){
				selection.hide();
			}

			// Setting up image for drag action
			overlay.on('mouseup', function(e){
				e.stopPropagation();
    			e.stopImmediatePropagation();
			});
			overlay.attr('draggable', 'true');
			overlay.on('dragstart', dragStart);
			overlay.on('drag', drag);
			overlay.on('dragend', dragEnd);
			
			// Setting up click action for comment button
			var img = this;
			submitBtn.on('click', function(e){
				e.preventDefault();
				postComment(img);
			});

			return this;
		});
	};

}( jQuery ));