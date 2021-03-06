<?php

class GMWDViewMarkers_gmwd extends GMWDView{

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

	public function edit($id){

		$row = $this->model->get_row($id);
		$animations = array("NONE" => __("None","gmwd"), "BOUNCE" => __("Bounce","gmwd"),"DROP" => __("Drop","gmwd"));
		$custom_marker_sizes = array("16" => "16X16","24" => "24X24","32" => "32X32", "48" => "48X48","64" => "64X64","122" => "122X122","256" => "256X256");
        $page =  sanitize_text_field(stripslashes($_GET["page"]));
		$query_url =  admin_url('admin-ajax.php');

		$query_url_select_icon = add_query_arg(array('action' => 'select_marker_icon', 'page' => 'markers_gmwd', 'task' => 'select_icon', 'width' => '900', 'height' => '600', 'callback' => 'selectMarkerIcon', 'nonce_gmwd' => wp_create_nonce('nonce_gmwd'), 'TB_iframe' => '1' ), $query_url);        
	?> 
		<div class="pois_wrapper gmwd_edit">
			<form method="post" action="" id="adminForm">
				<!-- header -->

                <h2 class="overlay_title wd-clear">
                    <div class="wd-left">
                        <img src="<?php echo GMWD_URL . '/images/css/marker-active-tab.png';?>" width="30" style="vertical-align:middle;">
                        <span><?php _e("Add Marker","gmwd");?></span>
                    </div>
                    <div class="wd-right">
                        <button class="wd-btn wd-btn-secondary" onclick="gmwdAddPoi();return false;"><?php isset($_GET["hiddenName"]) ? _e("Edit Marker","gmwd") : _e("Add Marker","gmwd") ;?></button>
                        <button class="wd-btn wd-btn-secondary" onclick="gmwdClosePoi();return false;"><?php  _e("Cancel","gmwd") ;?></button>
                    </div>
				</h2>
				<!-- data -->
				<div class="wd-clear">
					<div class="wd-left">
						<table class="pois_table">
							<tr>
                                <td><label for="title" title="<?php _e("Add new marker title for location.","gmwd");?>"><?php _e("Title","gmwd");?>:</label></td>
								<td><input type="text" name="title" id="title" value="<?php echo $row->title;?>" class="wd-form-field wd-poi-required"></td>
		
                                <td><label for="link_url" title="<?php _e("Link the marker with URL.","gmwd");?>"><?php _e("Link Url","gmwd");?>:</label></td>
								<td>
                                    <input type="text" name="link_url" id="link_url" value="<?php echo $row->link_url;?>" style="width:auto;" class="wd-form-field gmwd_disabled_field" disabled readonly>
                                    <div class="gmwd_pro_option"><small><?php _e("Only in the Paid version.","gmwd");?></small></div>
                                </td>                                
							</tr>							
							<tr>
                                <td><label for="marker_address" title="<?php _e("Search for location or right-click on the map to bring address.  Alternatively, add a location manually.","gmwd");?>"><?php _e("Address","gmwd");?>:</label></td>
								<td>
                                    <input type="text" name="address" id="marker_address" class="wd-form-field wd-poi-required" value="<?php echo $row->address;?>" autocomplete="off" >
									<div class="gmwd_help_small">
										<small><em><?php _e("Paste the address and press enter ","gmwd");?></em></small><br>
										<small><em><?php _e("or right click on the Map.","gmwd");?></em></small>
									</div>

                                </td>
					
                                <td>
                                    <label for="pic_url" title="<?php _e("Add an image to your marker in the info window and basic table marker list.","gmwd");?>"><?php _e("Marker Description Image","gmwd");?>:</label>
                                   
                                </td>
								<td>
                                    <button class="wd-btn wd-btn-primary" onclick="alert('<?php _e("This functionality is disabled in free version.","gmwd"); ?>'); return false;"><?php _e("Upload Image","gmwd"); ?></button>
                                    
                                    <input type="hidden" name="pic_url" id="pic_url" value="<?php echo $row->pic_url; ?>" class="wd-form-field gmwd_disabled_field" disabled readonly>                                   
                                    <div class="gmwd_pro_option"><small><?php _e("Only in the Paid version.","gmwd");?></small></div>                                    
                               </td>							
                            </tr>
							<tr>
                                <td><label for="lat" title="<?php _e("Set latitude if not specified automatically.","gmwd");?>"><?php _e("Latitude","gmwd");?>:</label></td>
								<td><input type="text" name="lat" id="lat" value="<?php echo $row->lat;?>" class="wd-form-field wd-poi-required"></td>						
                                <td><label for="category" title="<?php _e("Add a category for location.","gmwd");?>"><?php _e("Category","gmwd");?>:</label></td>
								<td>
									<select name="category" id="category" class="wd-form-field gmwd_disabled_field" disabled readonly>
										<option value="0">-<?php _e("Select","gmwd");?>-</option>
									</select>
                                    <div class="gmwd_pro_option"><small><?php _e("Only in the Paid version.","gmwd");?></small></div>
								</td>							
                            </tr>					
							<tr>
                                <td><label for="lng" title="<?php _e("Set longitude if not specified automatically.","gmwd");?>"><?php _e("Longitude","gmwd");?>:</label></td>
								<td><input type="text" name="lng" id="lng" value="<?php echo $row->lng;?>" class="wd-form-field wd-poi-required"></td>
								
								<td><label for="animation" title="<?php _e("Choose a dynamic movement for marker.","gmwd");?>"><?php _e("Animation","gmwd");?>:</label></td>
								<td>
									<select name="animation" id="animation" class="wd-form-field">
										<?php 
											foreach($animations as $key => $value){
												$selected = $key == $row->animation ? "selected" : "";
												echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
											}
										?>
									</select>
								</td>                                
							</tr>
							<tr>
								<td><label for="description" title="<?php _e("Add a description in the info window of a marker.","gmwd");?>"><?php _e("Description","gmwd");?>:</label></td>
								<td>
                                    <textarea name="description" id="description" class="wd-form-field gmwd_disabled_field"  disabled readonly></textarea>
                                    <div class="gmwd_pro_option"><small><?php _e("Only in the Paid version.","gmwd");?></small></div>
                                </td>
                                <td colspan="2">
                                    <button class="wd-btn wd-btn-primary open_editor" onclick="alert('<?php _e("This functionality is disabled in free version.","gmwd"); ?>');return false;"><?php _e("Open Editor","gmwd");?></button>
                                    <div class="gmwd_pro_option"><small><?php _e("Only in the Paid version.","gmwd");?></small></div>
                                </td>
	                               
							</tr>
                            <tr>
                                <td><label title="<?php _e("Choose whether to enable info window or not.","gmwd");?>"><?php _e("Enable Info Window","gmwd");?></label>:</td>
								<td>								
									<input type="radio" class="inputbox wd-form-field" id="enable_info_window0" name="enable_info_window" <?php echo (($row->enable_info_window) ? '' : 'checked="checked"'); ?> value="0"  >
									<label for="enable_info_window0"><?php _e("No","gmwd"); ?></label>
									<input type="radio" class="inputbox wd-form-field" id="enable_info_window1" name="enable_info_window" <?php echo (($row->enable_info_window) ? 'checked="checked"' : ''); ?> value="1"  >
									<label for="enable_info_window1"><?php _e("Yes","gmwd"); ?></label>						
								</td>                                    
 								<td><label title="<?php _e("Choose whether to open info by default or not.","gmwd");?>"><?php _e("Open Info Window by Default","gmwd");?></label>:</td>
								<td>								
									<input type="radio" class="inputbox wd-form-field" id="info_window_open0" name="info_window_open" <?php echo (($row->info_window_open) ? '' : 'checked="checked"'); ?> value="0"  >
									<label for="info_window_open0"><?php _e("No","gmwd"); ?></label>
									<input type="radio" class="inputbox wd-form-field" id="info_window_open1" name="info_window_open" <?php echo (($row->info_window_open) ? 'checked="checked"' : ''); ?> value="1"  >
									<label for="info_window_open1"><?php _e("Yes","gmwd"); ?></label>						
								</td>                              
                            </tr>
                            <tr>
								<td><label title="<?php _e("Choose a marker image from the list or upload yours.","gmwd");?>"><?php _e("Custom Icon:","gmwd"); ?></label></td>
								<td colspan="2">
                                  <input type="radio" class="inputbox wd-form-field gmwd_disabled_field" id="choose_marker_icon1" name="choose_marker_icon" <?php echo ($row->choose_marker_icon == 1  ? 'checked="checked"' : ''); ?> value="1" disabled readonly >
								  <label for="choose_marker_icon1"><?php _e("Choose from Icons","gmwd"); ?></label>
								  <input type="radio" class="inputbox wd-form-field gmwd_disabled_field" id="choose_marker_icon0" name="choose_marker_icon" <?php echo (($row->choose_marker_icon == 0 ) ? 'checked="checked"' : ''); ?> value="0" disabled readonly >
								  <label for="choose_marker_icon0"><?php _e("Upload","gmwd"); ?></label> 
                                 		                                 
								</td> 
                              
							</tr>
                            <tr>  
                                <td></td>
                                <td>
                                    <div class="from_media_uploader" <?php echo (($row->choose_marker_icon == 0 ) ? '' : 'style="display:none;"'); ?>>
                                        <button class="wd-btn wd-btn-primary" onclick="alert('<?php _e("This functionality is disabled in free version.","gmwd"); ?>'); return false;"><?php _e("Upload Marker Image","gmwd"); ?></button>
                
                                    </div>
                                    <div class="from_icons" <?php echo (($row->choose_marker_icon == 1 ) ? '' : 'style="display:none;"'); ?>>
                                        <a class="wd-btn wd-btn-primary " href="#" onclick="alert('<?php _e("This functionality is disabled in free version.","gmwd"); ?>'); return false;"><?php _e("Choose Marker Image","gmwd"); ?></a>    
                                    </div>
                                    <input type="hidden" name="custom_marker_url" id="custom_marker_url" value="<?php echo $row->custom_marker_url; ?>" class="wd-form-field">  
                                    <div class="custom_marker_url_view upload_view">
                                       <?php if($row->custom_marker_url){
                                        }
                                        ?>               
                                    </div> 
                                     <div class="gmwd_pro_option"><small><?php _e("Only in the Paid version.","gmwd");?></small></div>
                                </td>                               
                            </tr>   
							<tr>
								<td><label for="marker_size" title="<?php _e("Set a custom marker icon size.","gmwd");?>"><?php _e("Custom Icon Size","gmwd");?>:</label></td>
								<td>
									<select name="marker_size" id="marker_size" class="wd-form-field gmwd_disabled_field" disabled readonly>
										<?php 
											foreach($custom_marker_sizes as  $key => $value){
												$selected = $key == $row->marker_size ? "selected" : "";
												echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
											}
										?>
									</select>
                                     <div class="gmwd_pro_option"><small><?php _e("Only in the Paid version.","gmwd");?></small></div>
								</td>                             
							</tr>
                            <tr>
                                <td><label title="<?php _e("Publish your marker.","gmwd");?>"><?php _e("Published:","gmwd"); ?></label></td>
								<td>
                                  <input type="radio" class="inputbox wd-form-field" id="publishedm1" name="published" <?php echo (($row->published) ? 'checked="checked"' : ''); ?> value="1" >
								  <label for="publishedm1"><?php _e("Yes","gmwd"); ?></label>
								  <input type="radio" class="inputbox wd-form-field" id="publishedm0" name="published" <?php echo (($row->published) ? '' : 'checked="checked"'); ?> value="0"  >
								  <label for="publishedm0"><?php _e("No","gmwd"); ?></label>

								</td>   
                            </tr>
						
							<tr>								
								<td colspan="4">
									<button class="wd-btn wd-btn-primary" onclick="gmwdAddPoi();return false;"><?php isset($_GET["hiddenName"]) ? _e("Edit Marker","gmwd") : _e("Add Marker","gmwd") ;?></button>
									<button class="wd-btn wd-btn-secondary" onclick="gmwdClosePoi();return false;"><?php  _e("Cancel","gmwd") ;?></button>
								</td>
							</tr>	
						</table>
					</div>
					<div class="wd-right">
						<div id="wd-map2" class="wd_map gmwd_follow_scroll" style="height:400px;width:472px;"></div>
					</div>					
				</div>					
				<input id="page" name="page" type="hidden" value="<?php echo GMWDHelper::get('page');?>" />	
				<input id="task" name="task" type="hidden" value="" />	
				<input id="id" name="id" type="hidden" value="<?php echo $row->id;?>" class="wd-form-field" />	
				<input id="map_id" name="map_id" type="hidden" value="<?php echo GMWDHelper::get('map_id');?>" class="wd-form-field"/>	
			</form>
		</div>
				
		<script>
			var _type = "markers";			
			var GMWD_URL = "<?php echo GMWD_URL;?>";
			var _hiddenName = "<?php echo isset($_GET["hiddenName"]) ?  sanitize_text_field(stripslashes($_GET["hiddenName"])) : ""; ?>";
			var markerDefaultIcon = "<?php echo gmwd_get_option("marker_default_icon");?>";
           
		</script>

	<?php
    $version = get_option("gmwd_version");
    wp_register_script('admin_main', GMWD_URL . '/js/admin_main.js', array(), $version);
    wp_register_script('markers_gmwd', GMWD_URL . '/js/markers_gmwd.js', array(), $version);
    wp_print_scripts('markers_gmwd');
    wp_print_scripts('admin_main');

	 die();
	}
	
	public function select_icon(){
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