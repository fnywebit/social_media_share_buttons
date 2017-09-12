<?php
	if ( ! defined( 'ABSPATH' ) ) {
		die();
	}

	$id = "";
	$title = "";
	$socialButtons = array();
	$socialButtonsParams = array();
	$ajaxNonce = wp_create_nonce('fny-create-action');

	if (isset($_GET['id'])) {
		$id = (int)$_GET['id'];

		require_once(FNY_CORE_PATH.'FNYSocialButtons.php');

		$socialButtonsParams = FNYSocialButtons::fnyGetSocialButtonsById($id);
		$socialButtons = $socialButtonsParams['buttons'];

		$title = esc_html($socialButtonsParams['title']);
	}
?>

<script type="text/javascript">
	FNY_SOCIALBUTTONS_PARAMS = <?php echo json_encode($socialButtonsParams); ?>;
	FNY_SELECTED_SOCIALBUTTONS = <?php echo json_encode($socialButtons); ?>;
</script>
<input class=form-control id="fny_title" type="text" placeholder="Title" value="<?php echo $title ?>">
<div id="body">
<!-- 	<form action="" class="form-group">
 -->
			<input id="fny-sharebuttons-id" type="" name="fny-sharebuttons-id" value="<?php echo $id ?>" hidden>
			<input id="fny-create-ajax-nonce" type="" name="fny-create-ajax-nonce" value="<?php echo $ajaxNonce ?>" hidden>
			<header>
    			<center style="padding-top:10px; padding-bottom:10px;"><h1><strong>SOCIAL MEDIA SHARE BUTTONS</strong></h1></center>
			</header>
            <br><br>

		<!--bootstrap body-->
		<div class="container-fluid text-center">
			<div class="row content" >

<!-- ______________________________________________________________________1 start _________________________________________-->

<!--			share buttons list-->
				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 border" >
					<div id="button_list"></div>
					<br><br>
					<div id="fny_get_now"></div>
					<div id="button_list_not_active"></div>

				</div>
<!--            end of share buttons list-->
			<!-- _____________________________________________________________1 end _________________________________ -->




				<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 border">

					<div class="row">



						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 border">
							<div class="row">
								<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 border" id="fny-firstbox" ></div>

								<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 border" id="fny-remove" ondragover="allowDrop(event)" ondrop="drop(event)" >
									<img src="<?php echo FNY_IMAGES_URL.'logo/remove.svg'; ?>" alt="remove" style="height:34px;width:34px">
								</div>
							</div>
						</div>



						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 border">

						    <div class="row">


								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 border">
									
										
									
								</div>


								<center>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 border">
										<button class="btn btn-danger" id="fny-submit" type="button">Submit</button>
									</div>
								</center>


								<center>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 border">
										<button class="btn btn-danger" id="fny_save" type="button">Save</button>

									</div>
								</center>



							</div>
						</div>
					</div>

					<div class="row">
<!--left part-->
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 border fny-half" id="fny-lefthalf">
                        	<strong><h1><b>SETTINGS</b></h1></strong>
                        	<div><strong><h3><b>SIZE SETTINGS</b></h3></strong></div>
                        	<div id="">

                        	<div id="fny_float_type">
                        	<span><h3>Floating</h3></span>
                        	<input type="radio" name="float_type" value="vertical" >
                        	<label for="vertical">Vertical</label>
                        	<input type="radio" name="float_type" value="horizontal" checked>
                        	<label for="horizontal">Horizontal</label>

                        	<div id="fny_float">
                        	
                        	<input type="radio" name="float" value="left">
                        	<label for="left">Left</label>
                        	<input type="radio" name="float" value="right">
                        	<label for=right>Right</label>
                        	</div>
                        	</div>

                        	<span id="fny_size">
								</span>

                        	<span id="fny_size_not_active">
                        		<br>
                        		<br>
                        		<br> 
                        	</span>
                        	</div>
                        	<div><strong><h3><b>THEME SETTINGS</b></h3></strong>
                        		
                        	</div>

                        	<div id="theme"></div>
                        	<div id="fny_theme_not_active"></div>
                        	
                        	


                        </div>
<!--live demo-->
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 border fny-half" id="fny-righthalf">
                                <p id="fny-upofpic" class="fny_pic"></p>
                                <div>
								 <center><img class="fny_img img-responsive" src="<?php echo FNY_IMAGES_URL.'livedemo/Muhammad.jpg'; ?>" alt="sharedexample"></center></div>
								<p id="fny-downofpic" class="fny_pic"></p>
								
						</div>
						<div class="fny-half">
						  
						  <br>
						  <br>
						  <br>
						
                          </div>
						</div>
<!--end of live demo-->
					</div>
				</div>
				<br>
			</div>
		</div>
	<!-- </form> -->
</div>
