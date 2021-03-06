<?php

class GMWDViewOptions_gmwd extends GMWDView{

	////////////////////////////////////////////////////////////////////////////////////////
	// Events                                                                             //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Constants                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Variables                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Constructor & Destructor                                                           //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Public Methods                                                                     //
	////////////////////////////////////////////////////////////////////////////////////////

	public function display(){	
		add_thickbox();
		$options = $this->model->get_options();
		$lists = $this->model->get_lists();
		$query_url_generate_key = 'https://console.developers.google.com/henhouse/?pb=["hh-1","maps_backend",null,[],"https://developers.google.com",null,["maps_backend","geocoding_backend","directions_backend","distance_matrix_backend","elevation_backend","places_backend","static_maps_backend","roads","street_view_image_backend","geolocation"],null]';
	?>	
		<div class="gmwd_edit">
         
			<h2>
				<img src="<?php echo GMWD_URL . '/images/general_options.png';?>" width="30" style="vertical-align:middle;">
				<span><?php _e("General Options","gmwd");?></span>
			</h2>		
			<form method="post" action="" id="adminForm">
				<?php wp_nonce_field('nonce_gmwd', 'nonce_gmwd'); ?>
				<div class="wd-clear wd-row">
					<div class="wd-right">
						<button class="wd-btn wd-btn-primary wd-btn-icon wd-btn-apply" onclick="gmwdFormSubmit('apply');" ><?php _e("Apply","gmwd");?></button>
					</div>
				</div>
				<div class="gmwd">
					<div class="wd-clear">	
						 <div class="wd-options-tabs-container wd-left"> 
							<div id="general" class="wd-options-container" style="width:500px">
								<table class="gmwd_edit_table" style="width:100%;">		
									<tr>
											<td width="30%"><label for="map_api_key" title="<?php _e("Set your map API key","gmwd");?>"><?php _e("Map API Key","gmwd"); ?>:</label></td>
											<td><input type="text" name="map_api_key" id="map_api_key" value="<?php echo esc_attr($options->map_api_key); ?>" style="width:400px" ></td>
									</tr>
									<tr>
											<td colspan="2">
												 <a target="_blank" class="wd-btn wd-btn-primary" name="<?php _e( 'Generate API Key - ( MUST be logged in to your Google account )', 'gmwd' ); ?>" href='<?php echo $query_url_generate_key;?>'>
															<?php _e("Generate Key","gmwd");?>
													</a>
													or <a target="_blank" href='https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend,static_maps_backend,roads,street_view_image_backend,geolocation,places_backend&keyType=CLIENT_SIDE&reusekey=true'>click here</a>
													<?php echo _e( ' to Get a Google Maps API KEY', 'gmwd' ) ?>
											</td>
									</tr>
									<tr>
										<td width="30%"><label for="map_language" title="<?php _e("Choose Your Map Language","gmwd");?>"><?php _e("Map Language","gmwd"); ?>:</label></td>
										<td>
											<select name="map_language" id="map_language">
												<?php 
													foreach($lists["map_languages"] as $key => $value){
														$selected = $options->map_language ==  $key ? "selected" : "";
														echo '<option value="'.esc_attr($key).'" '.$selected.'>'.esc_html($value).'</option>';
													}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td><label for="marker_default_icon"  title="<?php _e("Upload a Custom Map Marker for Your Google Maps ","gmwd");?>"><?php _e("Marker Default Icon","gmwd");?>:</label></td>
										<td>
											<button class="wd-btn wd-btn-primary" onclick="alert('<?php _e("This functionality is disabled in free version.","gmwd"); ?>'); return false;"><?php _e("Upload Image","gmwd"); ?></button>
											<input type="hidden" name="marker_default_icon" id="marker_default_icon" value="<?php echo esc_attr($options->marker_default_icon); ?>" >
                      <div class="gmwd_pro_option"><small><?php _e("Only in the Paid version.","gmwd");?></small></div>
										</td>
									</tr>
									<tr>
										<td style="width:15%;"><label for="address" title="<?php _e("Set Center Address of your Google Map","gmwd");?>"><?php _e("Center address","gmwd");?>:</label></td>
										<td>
											<input type="text" name="center_address" id="address" value="<?php echo esc_attr($options->center_address); ?>" autocomplete="off" ><br>
											<small><em><?php _e("Or Right Click on the Map.","gmwd");?></em></small>
                     </td>
									</tr>
									<tr>
										<td><label for="center_lat" title="<?php _e("Google Map's Center Latitude","gmwd");?>"><?php _e("Center Lat","gmwd");?>:</label></td>
										<td><input type="text" name="center_lat" id="center_lat" value="<?php echo esc_attr($options->center_lat); ?>"></td>
									</tr>
									<tr>
										<td><label for="center_lng" title="<?php _e("Google Map's Center Longitude","gmwd");?>"><?php _e("Center Lng","gmwd");?>:</label></td>
										<td><input type="text" name="center_lng" id="center_lng" value="<?php echo esc_attr($options->center_lng); ?>"></td>
									</tr>         					
									<tr>
										<td><label for="zoom_level" title="<?php _e("Choose the Zoom Level of Your Google Maps","gmwd");?>"><?php _e("Zoom Level","gmwd");?>:</label></td>
										<td><input type="text" name="zoom_level" id="zoom_level" value="<?php echo esc_attr($options->zoom_level); ?>" data-slider="true" data-slider-highlight="true" data-slider-theme="volume" data-slider-values="<?php echo implode(",",range(0,22)); ?>"></td>
									</tr> 
									<tr>
										<td><label title="<?php _e("Enable or Disable Mouse Scroll-Wheel Scaling","gmwd");?>"><?php _e("Wheel Scrolling","gmwd"); ?>:</label></td>
										<td>
										  <input type="radio" class="inputbox" id="whell_scrolling0" name="whell_scrolling" <?php echo ( ( $options->whell_scrolling ) ? '' : 'checked="checked"'); ?> value="0" >
										  <label for="whell_scrolling0"><?php _e("Off","gmwd"); ?></label>
										  <input type="radio" class="inputbox" id="whell_scrolling1" name="whell_scrolling" <?php echo ( ( $options->whell_scrolling ) ? 'checked="checked"' : ''); ?> value="1" >
										  <label for="whell_scrolling1"><?php _e("On","gmwd"); ?></label>
										</td>
									</tr>
									<tr>
										<td ><label title="<?php _e("Enable or Disable Google Maps Dragging","gmwd");?>"><?php _e("Map Draggable","gmwd"); ?>:</label></td>
										<td>
										  <input type="radio" class="inputbox" id="map_draggable0" name="map_draggable" <?php echo ( ( $options->map_draggable ) ? '' : 'checked="checked"'); ?> value="0" >
										  <label for="map_draggable0"><?php _e("No","gmwd"); ?></label>
										  <input type="radio" class="inputbox" id="map_draggable1" name="map_draggable" <?php echo ( ( $options->map_draggable ) ? 'checked="checked"' : ''); ?> value="1" >
										  <label for="map_draggable1"><?php _e("Yes","gmwd"); ?></label>
										</td>
									</tr>
									<tr>
											<td ><label title="<?php _e("Enable or Disable Privacy/GDPR","gmwd");?>"><?php _e("Privacy/GDPR","gmwd"); ?>:</label></td>
											<td>
													<input type="radio" class="inputbox" id="gdpr0" name="gdpr" <?php echo ( ( $options->gdpr ) ? '' : 'checked="checked"'); ?> value="0" >
													<label for="gdpr0"><?php _e("No","gmwd"); ?></label>
													<input type="radio" class="inputbox" id="gdpr1" name="gdpr" <?php echo ( ( $options->gdpr ) ? 'checked="checked"' : ''); ?> value="1" >
													<label for="gdpr1"><?php _e("Yes","gmwd"); ?></label>
											</td>
									</tr>
									<tr>
											<td><label for="gdpr_text" title="<?php _e("Content for privacy","gmwd");?>"><?php _e("Privacy content","gmwd");?>:</label></td>
											<td><textarea name="gdpr_text" id="gdpr_text" cols="60" rows="5"> <?php echo esc_html($options->gdpr_text); ?></textarea></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="wd-right">
							<div id="wd-options-map" style="width:600px; height:300px;"></div>
						</div>	
					</div>	
			  </div>            
				<input id="page" name="page" type="hidden" value="<?php echo GMWDHelper::get('page');?>" />	
				<input id="task" name="task" type="hidden" value="" />	
			</form>
		</div>
		<script>
			jQuery(".gmwd_edit_table [data-slider]").each(function () {
				var input = jQuery(this);
				jQuery("<span>").addClass("output").insertAfter(jQuery(this));
			}).bind("slider:ready slider:changed", function (event, data) {
				jQuery(this) .nextAll(".output:first").html(data.value.toFixed(1));
			});
			gmwdSlider(this.jQuery || this.Zepto, jQuery(".gmwd_edit_table"));

			var mapWhellScrolling = Number(<?php echo $options->whell_scrolling;?>) == 1 ? true : false;
			var zoom = Number(<?php echo $options->zoom_level;?>);
			var mapDragable = Number(<?php echo $options->map_draggable;?>) == 1 ? true : false;
			var centerLat = Number(<?php echo $options->center_lat;?>);
			var centerLng = Number(<?php echo $options->center_lng;?>);
      var centerAddress = '<?php echo esc_html($options->center_address);?>';

      var map;
            
		</script>	
       
	<?php
	 
	}


	////////////////////////////////////////////////////////////////////////////////////////
	// Getters & Setters                                                                  //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Private Methods                                                                    //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Listeners                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
}