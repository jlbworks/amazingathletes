<?php 
$wp_map = $this->options; ?>
<form method="post" action="<?php echo admin_url( '/' ); ?>admin.php?page=wp-map">
<div id="wp-map-wrapper">
  <div id="map-header">
    <img src="<?php echo WPMMAP_URL . 'images/top-image.png'; ?>">
    <p class="map-shortcode">Insert this shortcode <strong>[us_wp_map]</strong> into any page or post to show the map.</p>
    <p class="map-btns"><span class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save changes"><input type="submit" name="restore_default" id="submit" class="button button-primary" value="Restore default"></span></p>
  </div>
  <div id="wp-map-main">
    <div class="map-col map-col-lt">
      <div id="map-preview">
        <?php include 'map.php'; ?>
      </div>
      <div class="map-parameters">
        <div class="map-box-header regions-icon">States Parameters</div>
        <div class="map-box-body region-field">

          <div class="region">
            <div class="region-name"><a href="#">ALABAMA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_1" value="1" <?php if ($wp_map['enable_region_1'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_1" value="<?php echo $wp_map['up_color_1']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_1" value="<?php echo $wp_map['over_color_1']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_1" value="<?php echo $wp_map['down_color_1']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_1" value="<?php echo $wp_map['url_1']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_1">
                    <option value="_self" <?php if($wp_map['open_url_1'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_1'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_1'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_1"><?php echo $wp_map['hover_content_1']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">ALASKA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_2" value="1" <?php if ($wp_map['enable_region_2'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_2" value="<?php echo $wp_map['up_color_2']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_2" value="<?php echo $wp_map['over_color_2']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_2" value="<?php echo $wp_map['down_color_2']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_2" value="<?php echo $wp_map['url_2']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_2">
                    <option value="_self" <?php if($wp_map['open_url_2'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_2'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_2'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_2"><?php echo $wp_map['hover_content_2']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">ARIZONA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_3" value="1" <?php if ($wp_map['enable_region_3'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_3" value="<?php echo $wp_map['up_color_3']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_3" value="<?php echo $wp_map['over_color_3']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_3" value="<?php echo $wp_map['down_color_3']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_3" value="<?php echo $wp_map['url_3']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_3">
                    <option value="_self" <?php if($wp_map['open_url_3'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_3'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_3'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_3"><?php echo $wp_map['hover_content_3']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">ARKANSAS</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_4" value="1" <?php if ($wp_map['enable_region_4'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_4" value="<?php echo $wp_map['up_color_4']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_4" value="<?php echo $wp_map['over_color_4']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_4" value="<?php echo $wp_map['down_color_4']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_4" value="<?php echo $wp_map['url_4']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_4">
                    <option value="_self" <?php if($wp_map['open_url_4'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_4'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_4'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_4"><?php echo $wp_map['hover_content_4']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">CALIFORNIA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_5" value="1" <?php if ($wp_map['enable_region_5'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_5" value="<?php echo $wp_map['up_color_5']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_5" value="<?php echo $wp_map['over_color_5']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_5" value="<?php echo $wp_map['down_color_5']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_5" value="<?php echo $wp_map['url_5']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_5">
                    <option value="_self" <?php if($wp_map['open_url_5'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_5'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_5'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_5"><?php echo $wp_map['hover_content_5']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">COLORADO</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_6" value="1" <?php if ($wp_map['enable_region_6'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_6" value="<?php echo $wp_map['up_color_6']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_6" value="<?php echo $wp_map['over_color_6']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_6" value="<?php echo $wp_map['down_color_6']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_6" value="<?php echo $wp_map['url_6']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_6">
                    <option value="_self" <?php if($wp_map['open_url_6'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_6'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_6'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_6"><?php echo $wp_map['hover_content_6']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">CONNECTICUT</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_7" value="1" <?php if ($wp_map['enable_region_7'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_7" value="<?php echo $wp_map['up_color_7']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_7" value="<?php echo $wp_map['over_color_7']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_7" value="<?php echo $wp_map['down_color_7']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_7" value="<?php echo $wp_map['url_7']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_7">
                    <option value="_self" <?php if($wp_map['open_url_7'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_7'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_7'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_7"><?php echo $wp_map['hover_content_7']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">DELAWARE</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_8" value="1" <?php if ($wp_map['enable_region_8'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_8" value="<?php echo $wp_map['up_color_8']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_8" value="<?php echo $wp_map['over_color_8']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_8" value="<?php echo $wp_map['down_color_8']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_8" value="<?php echo $wp_map['url_8']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_8">
                    <option value="_self" <?php if($wp_map['open_url_8'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_8'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_8'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_8"><?php echo $wp_map['hover_content_8']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">FLORIDA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_9" value="1" <?php if ($wp_map['enable_region_9'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_9" value="<?php echo $wp_map['up_color_9']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_9" value="<?php echo $wp_map['over_color_9']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_9" value="<?php echo $wp_map['down_color_9']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_9" value="<?php echo $wp_map['url_9']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_9">
                    <option value="_self" <?php if($wp_map['open_url_9'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_9'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_9'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_9"><?php echo $wp_map['hover_content_9']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">GEORGIA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_10" value="1" <?php if ($wp_map['enable_region_10'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_10" value="<?php echo $wp_map['up_color_10']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_10" value="<?php echo $wp_map['over_color_10']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_10" value="<?php echo $wp_map['down_color_10']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_10" value="<?php echo $wp_map['url_10']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_10">
                    <option value="_self" <?php if($wp_map['open_url_10'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_10'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_10'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_10"><?php echo $wp_map['hover_content_10']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">HAWAII</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_11" value="1" <?php if ($wp_map['enable_region_11'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_11" value="<?php echo $wp_map['up_color_11']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_11" value="<?php echo $wp_map['over_color_11']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_11" value="<?php echo $wp_map['down_color_11']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_11" value="<?php echo $wp_map['url_11']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_11">
                    <option value="_self" <?php if($wp_map['open_url_11'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_11'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_11'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_11"><?php echo $wp_map['hover_content_11']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">IDAHO</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_12" value="1" <?php if ($wp_map['enable_region_12'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_12" value="<?php echo $wp_map['up_color_12']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_12" value="<?php echo $wp_map['over_color_12']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_12" value="<?php echo $wp_map['down_color_12']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_12" value="<?php echo $wp_map['url_12']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_12">
                    <option value="_self" <?php if($wp_map['open_url_12'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_12'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_12'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_12"><?php echo $wp_map['hover_content_12']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">ILLINOIS</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_13" value="1" <?php if ($wp_map['enable_region_13'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_13" value="<?php echo $wp_map['up_color_13']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_13" value="<?php echo $wp_map['over_color_13']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_13" value="<?php echo $wp_map['down_color_13']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_13" value="<?php echo $wp_map['url_13']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_13">
                    <option value="_self" <?php if($wp_map['open_url_13'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_13'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_13'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_13"><?php echo $wp_map['hover_content_13']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">INDIANA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_14" value="1" <?php if ($wp_map['enable_region_14'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_14" value="<?php echo $wp_map['up_color_14']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_14" value="<?php echo $wp_map['over_color_14']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_14" value="<?php echo $wp_map['down_color_14']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_14" value="<?php echo $wp_map['url_14']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_14">
                    <option value="_self" <?php if($wp_map['open_url_14'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_14'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_14'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_14"><?php echo $wp_map['hover_content_14']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">IOWA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_15" value="1" <?php if ($wp_map['enable_region_15'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_15" value="<?php echo $wp_map['up_color_15']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_15" value="<?php echo $wp_map['over_color_15']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_15" value="<?php echo $wp_map['down_color_15']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_15" value="<?php echo $wp_map['url_15']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_15">
                    <option value="_self" <?php if($wp_map['open_url_15'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_15'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_15'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_15"><?php echo $wp_map['hover_content_15']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">KANSAS</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_16" value="1" <?php if ($wp_map['enable_region_16'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_16" value="<?php echo $wp_map['up_color_16']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_16" value="<?php echo $wp_map['over_color_16']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_16" value="<?php echo $wp_map['down_color_16']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_16" value="<?php echo $wp_map['url_16']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_16">
                    <option value="_self" <?php if($wp_map['open_url_16'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_16'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_16'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_16"><?php echo $wp_map['hover_content_16']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">KENTUCKY</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_17" value="1" <?php if ($wp_map['enable_region_17'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_17" value="<?php echo $wp_map['up_color_17']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_17" value="<?php echo $wp_map['over_color_17']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_17" value="<?php echo $wp_map['down_color_17']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_17" value="<?php echo $wp_map['url_17']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_17">
                    <option value="_self" <?php if($wp_map['open_url_17'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_17'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_17'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_17"><?php echo $wp_map['hover_content_17']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">LOUISIANA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_18" value="1" <?php if ($wp_map['enable_region_18'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_18" value="<?php echo $wp_map['up_color_18']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_18" value="<?php echo $wp_map['over_color_18']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_18" value="<?php echo $wp_map['down_color_18']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_18" value="<?php echo $wp_map['url_18']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_18">
                    <option value="_self" <?php if($wp_map['open_url_18'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_18'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_18'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_18"><?php echo $wp_map['hover_content_18']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">MAINE</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_19" value="1" <?php if ($wp_map['enable_region_19'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_19" value="<?php echo $wp_map['up_color_19']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_19" value="<?php echo $wp_map['over_color_19']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_19" value="<?php echo $wp_map['down_color_19']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_19" value="<?php echo $wp_map['url_19']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_19">
                    <option value="_self" <?php if($wp_map['open_url_19'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_19'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_19'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_19"><?php echo $wp_map['hover_content_19']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">MARYLAND</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_20" value="1" <?php if ($wp_map['enable_region_20'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_20" value="<?php echo $wp_map['up_color_20']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_20" value="<?php echo $wp_map['over_color_20']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_20" value="<?php echo $wp_map['down_color_20']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_20" value="<?php echo $wp_map['url_20']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_20">
                    <option value="_self" <?php if($wp_map['open_url_20'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_20'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_20'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_20"><?php echo $wp_map['hover_content_20']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">MASSACHUSETTS</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_21" value="1" <?php if ($wp_map['enable_region_21'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_21" value="<?php echo $wp_map['up_color_21']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_21" value="<?php echo $wp_map['over_color_21']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_21" value="<?php echo $wp_map['down_color_21']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_21" value="<?php echo $wp_map['url_21']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_21">
                    <option value="_self" <?php if($wp_map['open_url_21'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_21'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_21'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_21"><?php echo $wp_map['hover_content_21']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">MICHIGAN</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_22" value="1" <?php if ($wp_map['enable_region_22'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_22" value="<?php echo $wp_map['up_color_22']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_22" value="<?php echo $wp_map['over_color_22']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_22" value="<?php echo $wp_map['down_color_22']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_22" value="<?php echo $wp_map['url_22']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_22">
                    <option value="_self" <?php if($wp_map['open_url_22'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_22'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_22'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_22"><?php echo $wp_map['hover_content_22']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">MINNESOTA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_23" value="1" <?php if ($wp_map['enable_region_23'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_23" value="<?php echo $wp_map['up_color_23']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_23" value="<?php echo $wp_map['over_color_23']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_23" value="<?php echo $wp_map['down_color_23']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_23" value="<?php echo $wp_map['url_23']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_23">
                    <option value="_self" <?php if($wp_map['open_url_23'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_23'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_23'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_23"><?php echo $wp_map['hover_content_23']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">MISSISSIPPI</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_24" value="1" <?php if ($wp_map['enable_region_24'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_24" value="<?php echo $wp_map['up_color_24']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_24" value="<?php echo $wp_map['over_color_24']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_24" value="<?php echo $wp_map['down_color_24']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_24" value="<?php echo $wp_map['url_24']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_24">
                    <option value="_self" <?php if($wp_map['open_url_24'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_24'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_24'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_24"><?php echo $wp_map['hover_content_24']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">MISSOURI</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_25" value="1" <?php if ($wp_map['enable_region_25'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_25" value="<?php echo $wp_map['up_color_25']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_25" value="<?php echo $wp_map['over_color_25']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_25" value="<?php echo $wp_map['down_color_25']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_25" value="<?php echo $wp_map['url_25']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_25">
                    <option value="_self" <?php if($wp_map['open_url_25'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_25'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_25'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_25"><?php echo $wp_map['hover_content_25']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">MONTANA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_26" value="1" <?php if ($wp_map['enable_region_26'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_26" value="<?php echo $wp_map['up_color_26']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_26" value="<?php echo $wp_map['over_color_26']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_26" value="<?php echo $wp_map['down_color_26']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_26" value="<?php echo $wp_map['url_26']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_26">
                    <option value="_self" <?php if($wp_map['open_url_26'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_26'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_26'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_26"><?php echo $wp_map['hover_content_26']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">NEBRASKA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_27" value="1" <?php if ($wp_map['enable_region_27'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_27" value="<?php echo $wp_map['up_color_27']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_27" value="<?php echo $wp_map['over_color_27']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_27" value="<?php echo $wp_map['down_color_27']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_27" value="<?php echo $wp_map['url_27']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_27">
                    <option value="_self" <?php if($wp_map['open_url_27'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_27'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_27'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_27"><?php echo $wp_map['hover_content_27']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">NEVADA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_28" value="1" <?php if ($wp_map['enable_region_28'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_28" value="<?php echo $wp_map['up_color_28']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_28" value="<?php echo $wp_map['over_color_28']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_28" value="<?php echo $wp_map['down_color_28']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_28" value="<?php echo $wp_map['url_28']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_28">
                    <option value="_self" <?php if($wp_map['open_url_28'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_28'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_28'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_28"><?php echo $wp_map['hover_content_28']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">NEW HAMPSHIRE</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_29" value="1" <?php if ($wp_map['enable_region_29'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_29" value="<?php echo $wp_map['up_color_29']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_29" value="<?php echo $wp_map['over_color_29']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_29" value="<?php echo $wp_map['down_color_29']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_29" value="<?php echo $wp_map['url_29']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_29">
                    <option value="_self" <?php if($wp_map['open_url_29'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_29'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_29'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_29"><?php echo $wp_map['hover_content_29']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">NEW JERSEY</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_30" value="1" <?php if ($wp_map['enable_region_30'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_30" value="<?php echo $wp_map['up_color_30']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_30" value="<?php echo $wp_map['over_color_30']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_30" value="<?php echo $wp_map['down_color_30']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_30" value="<?php echo $wp_map['url_30']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_30">
                    <option value="_self" <?php if($wp_map['open_url_30'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_30'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_30'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_30"><?php echo $wp_map['hover_content_30']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">NEW MEXICO</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_31" value="1" <?php if ($wp_map['enable_region_31'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_31" value="<?php echo $wp_map['up_color_31']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_31" value="<?php echo $wp_map['over_color_31']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_31" value="<?php echo $wp_map['down_color_31']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_31" value="<?php echo $wp_map['url_31']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_31">
                    <option value="_self" <?php if($wp_map['open_url_31'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_31'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_31'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_31"><?php echo $wp_map['hover_content_31']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">NEW YORK</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_32" value="1" <?php if ($wp_map['enable_region_32'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_32" value="<?php echo $wp_map['up_color_32']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_32" value="<?php echo $wp_map['over_color_32']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_32" value="<?php echo $wp_map['down_color_32']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_32" value="<?php echo $wp_map['url_32']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_32">
                    <option value="_self" <?php if($wp_map['open_url_32'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_32'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_32'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_32"><?php echo $wp_map['hover_content_32']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">NORTH CAROLINA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_33" value="1" <?php if ($wp_map['enable_region_33'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_33" value="<?php echo $wp_map['up_color_33']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_33" value="<?php echo $wp_map['over_color_33']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_33" value="<?php echo $wp_map['down_color_33']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_33" value="<?php echo $wp_map['url_33']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_33">
                    <option value="_self" <?php if($wp_map['open_url_33'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_33'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_33'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_33"><?php echo $wp_map['hover_content_33']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">NORTH DAKOTA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_34" value="1" <?php if ($wp_map['enable_region_34'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_34" value="<?php echo $wp_map['up_color_34']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_34" value="<?php echo $wp_map['over_color_34']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_34" value="<?php echo $wp_map['down_color_34']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_34" value="<?php echo $wp_map['url_34']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_34">
                    <option value="_self" <?php if($wp_map['open_url_34'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_34'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_34'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_34"><?php echo $wp_map['hover_content_34']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">OHIO</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_35" value="1" <?php if ($wp_map['enable_region_35'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_35" value="<?php echo $wp_map['up_color_35']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_35" value="<?php echo $wp_map['over_color_35']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_35" value="<?php echo $wp_map['down_color_35']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_35" value="<?php echo $wp_map['url_35']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_35">
                    <option value="_self" <?php if($wp_map['open_url_35'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_35'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_35'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_35"><?php echo $wp_map['hover_content_35']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">OKLAHOMA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_36" value="1" <?php if ($wp_map['enable_region_36'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_36" value="<?php echo $wp_map['up_color_36']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_36" value="<?php echo $wp_map['over_color_36']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_36" value="<?php echo $wp_map['down_color_36']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_36" value="<?php echo $wp_map['url_36']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_36">
                    <option value="_self" <?php if($wp_map['open_url_36'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_36'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_36'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_36"><?php echo $wp_map['hover_content_36']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">OREGON</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_37" value="1" <?php if ($wp_map['enable_region_37'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_37" value="<?php echo $wp_map['up_color_37']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_37" value="<?php echo $wp_map['over_color_37']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_37" value="<?php echo $wp_map['down_color_37']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_37" value="<?php echo $wp_map['url_37']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_37">
                    <option value="_self" <?php if($wp_map['open_url_37'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_37'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_37'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_37"><?php echo $wp_map['hover_content_37']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">PENNSYLVANIA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_38" value="1" <?php if ($wp_map['enable_region_38'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_38" value="<?php echo $wp_map['up_color_38']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_38" value="<?php echo $wp_map['over_color_38']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_38" value="<?php echo $wp_map['down_color_38']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_38" value="<?php echo $wp_map['url_38']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_38">
                    <option value="_self" <?php if($wp_map['open_url_38'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_38'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_38'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_38"><?php echo $wp_map['hover_content_38']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">RHODE ISLAND</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_39" value="1" <?php if ($wp_map['enable_region_39'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_39" value="<?php echo $wp_map['up_color_39']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_39" value="<?php echo $wp_map['over_color_39']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_39" value="<?php echo $wp_map['down_color_39']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_39" value="<?php echo $wp_map['url_39']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_39">
                    <option value="_self" <?php if($wp_map['open_url_39'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_39'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_39'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_39"><?php echo $wp_map['hover_content_39']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">SOUTH CAROLINA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_40" value="1" <?php if ($wp_map['enable_region_40'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_40" value="<?php echo $wp_map['up_color_40']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_40" value="<?php echo $wp_map['over_color_40']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_40" value="<?php echo $wp_map['down_color_40']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_40" value="<?php echo $wp_map['url_40']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_40">
                    <option value="_self" <?php if($wp_map['open_url_40'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_40'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_40'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_40"><?php echo $wp_map['hover_content_40']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">SOUTH DAKOTA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_41" value="1" <?php if ($wp_map['enable_region_41'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_41" value="<?php echo $wp_map['up_color_41']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_41" value="<?php echo $wp_map['over_color_41']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_41" value="<?php echo $wp_map['down_color_41']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_41" value="<?php echo $wp_map['url_41']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_41">
                    <option value="_self" <?php if($wp_map['open_url_41'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_41'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_41'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_41"><?php echo $wp_map['hover_content_41']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">TENNESSEE</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_42" value="1" <?php if ($wp_map['enable_region_42'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_42" value="<?php echo $wp_map['up_color_42']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_42" value="<?php echo $wp_map['over_color_42']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_42" value="<?php echo $wp_map['down_color_42']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_42" value="<?php echo $wp_map['url_42']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_42">
                    <option value="_self" <?php if($wp_map['open_url_42'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_42'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_42'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_42"><?php echo $wp_map['hover_content_42']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">TEXAS</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_43" value="1" <?php if ($wp_map['enable_region_43'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_43" value="<?php echo $wp_map['up_color_43']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_43" value="<?php echo $wp_map['over_color_43']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_43" value="<?php echo $wp_map['down_color_43']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_43" value="<?php echo $wp_map['url_43']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_43">
                    <option value="_self" <?php if($wp_map['open_url_43'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_43'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_43'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_43"><?php echo $wp_map['hover_content_43']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">UTAH</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_44" value="1" <?php if ($wp_map['enable_region_44'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_44" value="<?php echo $wp_map['up_color_44']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_44" value="<?php echo $wp_map['over_color_44']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_44" value="<?php echo $wp_map['down_color_44']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_44" value="<?php echo $wp_map['url_44']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_44">
                    <option value="_self" <?php if($wp_map['open_url_44'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_44'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_44'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_44"><?php echo $wp_map['hover_content_44']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">VERMONT</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_45" value="1" <?php if ($wp_map['enable_region_45'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_45" value="<?php echo $wp_map['up_color_45']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_45" value="<?php echo $wp_map['over_color_45']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_45" value="<?php echo $wp_map['down_color_45']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_45" value="<?php echo $wp_map['url_45']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_45">
                    <option value="_self" <?php if($wp_map['open_url_45'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_45'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_45'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_45"><?php echo $wp_map['hover_content_45']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">VIRGINIA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_46" value="1" <?php if ($wp_map['enable_region_46'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_46" value="<?php echo $wp_map['up_color_46']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_46" value="<?php echo $wp_map['over_color_46']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_46" value="<?php echo $wp_map['down_color_46']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_46" value="<?php echo $wp_map['url_46']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_46">
                    <option value="_self" <?php if($wp_map['open_url_46'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_46'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_46'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_46"><?php echo $wp_map['hover_content_46']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">WASHINGTON</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_47" value="1" <?php if ($wp_map['enable_region_47'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_47" value="<?php echo $wp_map['up_color_47']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_47" value="<?php echo $wp_map['over_color_47']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_47" value="<?php echo $wp_map['down_color_47']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_47" value="<?php echo $wp_map['url_47']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_47">
                    <option value="_self" <?php if($wp_map['open_url_47'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_47'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_47'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_47"><?php echo $wp_map['hover_content_47']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">WEST VIRGINIA</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_48" value="1" <?php if ($wp_map['enable_region_48'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_48" value="<?php echo $wp_map['up_color_48']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_48" value="<?php echo $wp_map['over_color_48']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_48" value="<?php echo $wp_map['down_color_48']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_48" value="<?php echo $wp_map['url_48']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_48">
                    <option value="_self" <?php if($wp_map['open_url_48'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_48'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_48'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_48"><?php echo $wp_map['hover_content_48']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">WISCONSIN</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_49" value="1" <?php if ($wp_map['enable_region_49'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_49" value="<?php echo $wp_map['up_color_49']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_49" value="<?php echo $wp_map['over_color_49']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_49" value="<?php echo $wp_map['down_color_49']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_49" value="<?php echo $wp_map['url_49']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_49">
                    <option value="_self" <?php if($wp_map['open_url_49'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_49'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_49'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_49"><?php echo $wp_map['hover_content_49']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">WYOMING</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_50" value="1" <?php if ($wp_map['enable_region_50'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_50" value="<?php echo $wp_map['up_color_50']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_50" value="<?php echo $wp_map['over_color_50']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_50" value="<?php echo $wp_map['down_color_50']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_50" value="<?php echo $wp_map['url_50']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_50">
                    <option value="_self" <?php if($wp_map['open_url_50'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_50'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_50'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_50"><?php echo $wp_map['hover_content_50']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">WASHINGTON DC</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_51" value="1" <?php if ($wp_map['enable_region_51'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_51" value="<?php echo $wp_map['up_color_51']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_51" value="<?php echo $wp_map['over_color_51']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_51" value="<?php echo $wp_map['down_color_51']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_51" value="<?php echo $wp_map['url_51']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_51">
                    <option value="_self" <?php if($wp_map['open_url_51'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_map['open_url_51'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_map['open_url_51'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content<small>&nbsp;(<b>Important:</b> If needed, please use this character&nbsp; ’ &nbsp;instead of apostrophe to avoid breaking the code)&nbsp;<a href="JavaScript:apostSolution();">more info!</a></small></label><textarea rows="5" name="hover_content_51"><?php echo $wp_map['hover_content_51']; ?></textarea></p></div>
            </div>
          </div>

        </div><!-- map-box-body -->
      </div><!-- map-parameters -->
    </div><!-- map-col-lt -->


    <!-- General Map Colors -->
    <div id="submitdiv" class="map-col map-col-rt">
      <div class="map-parameters">
        <div class="map-box-header map-icon">General Map Colors</div>
        <div class="map-box-body">
          <div class="map-field"><span class="map-parameter icon-border">Border Color</span><input type="text" name="border_color" value="<?php echo $wp_map['border_color']; ?>" class="color-field" /></div>               
          <div class="map-field"><span class="map-parameter icon-shadow">Shadow Color</span><input type="text" name="shadow_color" value="<?php echo $wp_map['shadow_color']; ?>" class="color-field" /></div>               
          <div class="map-field"><span class="map-parameter icon-opacity">Shadow Opacity</span><input type="text" name="shadow_opacity" value="<?php echo $wp_map['shadow_opacity']; ?>" style="width: 50px;"/></div>             
          <div class="map-field"><span class="map-parameter icon-abbs">Short Names</span><input type="text" name="short_names" value="<?php echo $wp_map['short_names']; ?>" class="color-field" /></div>              
          <div class="map-field"><span class="map-parameter icon-hover">Hover Shadow</span><input type="text" name="hover_shadow" value="<?php echo $wp_map['hover_shadow']; ?>" class="color-field" /></div>               
          <div class="map-field"><span class="map-parameter icon-lakes">Lakes Color</span><input type="text" name="lake_color" value="<?php echo $wp_map['lake_color']; ?>" class="color-field" /></div>  
        </div><!-- map-box-body -->
      </div><!-- map-parameters -->
    </div><!-- map-col-rt -->

    <input type="hidden" name="wp_map">
      <?php
      settings_fields(__FILE__);
      do_settings_sections(__FILE__);
      ?>
    <p class="map-btns"><span class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save changes"><input type="submit" name="restore_default" id="submit" class="button button-primary" value="Restore default"></span></p>
    
    <script>
    function apostSolution() {
        window.open("http://www.html5interactivemaps.com/apostrophe.html", "", "width=600, height=220");

    }
    </script>

  </div><!-- wp-map-main -->
</div><!-- wp-map-wrapper -->
</form>
