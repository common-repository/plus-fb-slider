jQuery(document).ready(function($){
	//open the lateral panel
	$('.cd-btn-fb').on('click', function(event){
		event.preventDefault();
		$('.cd-panel-fb').addClass('is-visible');
	});
	//clode the lateral panel
	$('.cd-panel-fb').on('click', function(event){
		if( $(event.target).is('.cd-panel-fb') || $(event.target).is('.cd-panel-close-fb') ) { 
			$('.cd-panel-fb').removeClass('is-visible');
			event.preventDefault();
		}
	});
});