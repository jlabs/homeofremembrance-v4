	<!--</div>end of container-->

    <!-- JavaScript plugins (requires jQuery) -->
    <!--<script src="http://code.jquery.com/jquery.js"></script>-->
    <!--<script src="js/jquery-2.0.3.min.js"></script>-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!--<script src="js/bootstrap.min.js"></script>

    <!-- Enable responsive features in IE8 with Respond.js (https://github.com/scottjehl/Respond) -->
    <!--<script src="js/respond.min.js"></script>
    
    <!--Backstretch script to stretch the image to the full width-->
    <!--<script src="js/jquery.backstretch.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script> -->
	<script src="js/build/modernizr.custom.js"></script>
    <script src="js/build/global.min.js"></script>
    <script src="assets/js/holder.js"></script>
    <!--<script src="js/libs/respond.min.js"></script>-->
    
    <script src="js/build/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
	
	<!-- js for http://tympanus.net/codrops/2014/05/12/morphing-buttons-concept/ -->
	<script src="js/build/classie.js"></script>
	<script src="js/build/uiMorphingButton_fixed.js"></script>
	<script src="js/build/uiMorphingButton_inflow.js"></script>
	<script src="js/build/selectFx.js"></script>
	
	<!-- for touch devices <script src="js/build/toucheffects.js"></script>-->
	<!-- <script src="js/build/modernizr.custom.js"></script> -->
	<!-- <script src="js/build/modernizr.js"></script> -->

	<script>
		/*
		$(document).ready(function(){
	    	
		});
		*/
		
		function milestoneIDForEditModal(parsedID)
		{			
			document.getElementById("milestone_id").value = parsedID;
			
			var milestone_text = "milestone_text" + parsedID;
			document.getElementById("milestone_edittext").value = document.getElementById(milestone_text).innerHTML;			
		}
		
		function bucketIDForEditModal(parsedID)
		{
			document.getElementById("bucketIDModal").value = parsedID;
			
			var bucket_body = "bucket_body" + parsedID;
			document.getElementById("bucket_editbody").value = document.getElementById(bucket_body).innerHTML;
			
			var bucket_title = "bucket_title" + parsedID;
			document.getElementById("bucket_edittitle").value = document.getElementById(bucket_title).innerHTML;
			
			var bucket_completed = "bucket_completed" + parsedID;
			if (document.getElementById(bucket_completed).innerHTML == "Completed")
			{
				document.getElementById("bucket_editcompleted").checked = true;
			}
			else
			{
				document.getElementById("bucket_editcompleted").checked = false;
			}
		}
		
		function bucketIDForModal(parsedID)
		{
			document.getElementById("bucketIDModal").value = parsedID;
		}
	
		(function() {
			$("a[rel^='prettyPhoto']").prettyPhoto();
			
			var docElem = window.document.documentElement, didScroll, scrollPosition;

			// trick to prevent scrolling when opening/closing button
			function noScrollFn() {
				window.scrollTo( scrollPosition ? scrollPosition.x : 0, scrollPosition ? scrollPosition.y : 0 );
			}

			function noScroll() {
				window.removeEventListener( 'scroll', scrollHandler );
				window.addEventListener( 'scroll', noScrollFn );
			}

			function scrollFn() {
				window.addEventListener( 'scroll', scrollHandler );
			}

			function canScroll() {
				window.removeEventListener( 'scroll', noScrollFn );
				scrollFn();
			}

			function scrollHandler() {
				if( !didScroll ) {
					didScroll = true;
					setTimeout( function() { scrollPage(); }, 60 );
				}
			};

			function scrollPage() {
				scrollPosition = { x : window.pageXOffset || docElem.scrollLeft, y : window.pageYOffset || docElem.scrollTop };
				didScroll = false;
			};

			scrollFn();

			[].slice.call( document.querySelectorAll( '.morph-button' ) ).forEach( function( bttn ) {
				new UIMorphingButton( bttn, {
					closeEl : '.icon-close',
					onBeforeOpen : function() {
						// don't allow to scroll
						noScroll();
					},
					onAfterOpen : function() {
						// can scroll again
						canScroll();
					},
					onBeforeClose : function() {
						// don't allow to scroll
						noScroll();
					},
					onAfterClose : function() {
						// can scroll again
						canScroll();
					}
				} );
			} );
			
			[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {	
					new SelectFx(el);
			} );
		})();
	</script>

	
  </body>
</html>