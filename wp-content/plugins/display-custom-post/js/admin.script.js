/*
 * Display Custom Post WordPress Plugin Jquery For Settings Page
*/  
 
jQuery(document).ready( function ($){
	/* we are assigning change event handler for select box */
	/* it will run when selectbox options are changed */

	$('a#build_shortcode').on('click', function(e){
		e.preventDefault();

		let postType = $('#dropdown_selector').find('option:selected').val();
		let postLayout = $('#layout_selector').find('option:selected').val();
		let postCols = $('#cols_selector').find('option:selected').val();
		let incPosts = $('#includeposts').val();
		let excPosts = $('#excludeposts').val();
		let postLimit = $('#numberposts').val();
		let postOrder = $('#order_selector').find('option:selected').val();
		let postOrderBy = $('#orderby_selector').find('option:selected').val();
		let postAuthor = $('#dcp_author').val();
		let postComments = $('#dcp_comments').val();
		let postDate = $('#dcp_date').val();
		let headTag = $('#heading_selector').find('option:selected').val();
		let contentLength = $('#contentlength').val(); 
		
		let postTypeLabel = postLayoutLabel = postColsLabel = excPostsLabel = incPostsLabel = postLimitLabel = postOrderLabel = postOrderByLabel = postAuthorLabel = postCommentLabel = postDateLabel = headTagLabel = contentLengthLabel = '';

		if(postType !== ''){
			postTypeLabel = ' type="'+ postType +'"';
			$('.validationError').addClass('hide');	
		}else{
			// Show the error message
			$('.validationError').removeClass('hide');
			return;
		}

		if(postLayout !== ''){
			postLayoutLabel = ' layout="'+ postLayout +'"';
		}
		
		if(postCols !== '' && (postLayout == 'dcp-column-grid' || postLayout == 'dcp-grid-overlay') ){
			postColsLabel = ' columns="'+ postCols +'"';
		}			

		if(incPosts !== ''){
			// remove everything except number and commas			
			incPostsTrimmed = incPosts.replace(/[^0-9,]/gi, '');
			incPostsLabel = ' include='+ incPostsTrimmed;	
		}

		if(excPosts !== ''){
			// remove everything except number and commas			
			excPostsTrimmed = excPosts.replace(/[^0-9,]/gi, '');
			excPostsLabel = ' exclude='+ excPostsTrimmed;	
		}

		if(postLimit !== ''){
			postLimitLabel = ' number="'+ postLimit +'"';	
		}
		if(postOrder !== ''){
			postOrderLabel = ' order="'+ postOrder +'"';	
		}
		if(postOrderBy !== ''){
			postOrderByLabel = ' orderby="'+ postOrderBy +'"';	
		}					
		if ($('#dcp_author').is(":checked")){
			postAuthorLabel = ' is_author="'+ postAuthor +'"';	
		}
		if ($('#dcp_comments').is(":checked")){
			postCommentLabel = ' is_comments="'+ postComments +'"';	
		}
		if ($('#dcp_date').is(":checked")){
			postDateLabel = ' is_date="'+ postDate +'"';	
		}		
		if(headTag !== ''){
			headTagLabel = ' title="'+ headTag +'"';	
		}	
		if(contentLength !== ''){
			contentLengthLabel = ' length="'+ contentLength +'"';	
		}			

		// Shortcode to be appended
		$('#showoption').val('');
		$('#showoption').val('[dcp_show'+ postTypeLabel + postLayoutLabel + postColsLabel + incPostsLabel + excPostsLabel + postLimitLabel + postOrderLabel + postOrderByLabel + postAuthorLabel + postCommentLabel + postDateLabel + headTagLabel + contentLengthLabel +']');	 
	});

	$('#reset_settings').on('click', function(e){
		e.preventDefault();
		
		// Reset all fields values
		$('#dropdown_selector').prop('selectedIndex',0);
		$('#layout_selector').prop('selectedIndex',0);
		$('#cols_selector').prop('selectedIndex',0);
		$('#includeposts').val('');
		$('#excludeposts').val('');
		$('#numberposts').val('');
		$('#order_selector').prop('selectedIndex',0);
		$('#orderby_selector').prop('selectedIndex',0);	
		$('#dcp_author').prop('checked',false);
		$('#dcp_comments').prop('checked',false);
		$('#dcp_date').prop('checked',false);
		$('#heading_selector').prop('selectedIndex',0);
		$('#contentlength').val('');
		
		// Reset shortcode field value
		$('#showoption').prop('readonly', false);
		$('#showoption').val('');
		$('#showoption').prop('readonly', true);	
		
		// Remove the validation alert field
		$('.validationError').addClass('hide');
	});
	
});
   
   
// Copy shortcode to clipboard 
function copy_clipboard() {
	var copyCB = document.getElementById("showoption");
	copyCB.select();
	copyCB.setSelectionRange(0, 99999); 
	if(navigator.clipboard) {
		navigator.clipboard.writeText(copyCB.value);
	}
}    