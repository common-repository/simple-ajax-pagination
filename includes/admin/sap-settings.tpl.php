<div class="wrap sap-settings-wrap">
	
	<h1><?php echo __( 'Simple Ajax Pagination Settings', SAP_PLUGIN_DOMAIN );?></h1>
	
	<form id="post" method="post" name="post">
		
		<div id="sap-form-data" class="sap-hidden">
			<?php wp_nonce_field( 'allow-site-admin-sap-settings', 'sap-settings-nonce' ); ?>
		</div>

		<div id="poststuff">
			
			<div id="post-body" class="metabox-holder columns-2">
			
				<div id="postbox-container-1" class="postbox-container">
					<div id="side-sortables" class="meta-box-sortables ui-sortable">

						<div id="submitdiv" class="postbox ">

							<h2 class="hndle ui-sortable-handle">
								<span><?php echo __( 'Publish', SAP_PLUGIN_DOMAIN );?></span>
							</h2>
								
							<div class="inside">
								<div id="major-publishing-actions">

									<div id="publishing-action">
										<span class="spinner"></span>
										<input type="submit" value="<?php echo __( 'Update', SAP_PLUGIN_DOMAIN );?>" class="button button-primary button-large" id="publish" name="publish">
									</div>
			
									<div class="clear"></div>
		
								</div>
							</div>

						</div>

					</div>						
				</div>

			
				<div id="postbox-container-2" class="postbox-container">
				
					<div id="normal-sortables" class="meta-box-sortables">
						<div class="postbox sap-postbox">

							<h2 class="hndle">
								<span><?php echo __( 'Settings', SAP_PLUGIN_DOMAIN );?></span>
							</h2>

							<div class="inside sap-fields -top">
								
								<div class="sap-field sap-field-repeater" data-name="add_pagination_settings" data-type="repeater">
									
									<div class="sap-label">
										<label><?php echo __( 'Add pagination settings', SAP_PLUGIN_DOMAIN );?></label>
									</div>

									<div class="sap-input">
										<div class="sap-repeater -table" data-min="0" data-max="0">
												
											<table class="sap-table sap-table-main">

												<thead>
													<tr>
														<th class="sap-th" style="width: 33.3333%;">
															<?php echo __( 'Select Page', SAP_PLUGIN_DOMAIN );?>
														</th>

														<th class="sap-th" style="width: 33.3333%;">
															<?php echo __( 'Container Div', SAP_PLUGIN_DOMAIN );?>
														</th>

														<th class="sap-th" style="width: 33.3333%;">
															<?php echo __( 'Pagination Div', SAP_PLUGIN_DOMAIN );?>
														</th>
									
														<th class="sap-row-handle"></th>
													</tr>
												</thead>


												<tbody>

													<?php
													if( !empty( $this->sap_options ) ){

														foreach ( $this->sap_options as $options ) {
														?>
															
															<tr class="sap-row sap-tbl-row">
																
																<td class="sap-field sap-field-select">
																	<div class="sap-input">
																		<select name="sap[pages][]" required>
																			<?php echo $this->get_all_pages( $options['pages'] );?>
																		</select>
																	</div>
																</td>
															
																<td class="sap-field sap-field-text">
																	<div class="sap-input">
																		<div class="sap-input-wrap">
																			<input type="text" name="sap[cdiv][]" value="<?php echo $options['cdiv'];?>" required>
																		</div>
																	</div>
																</td>
															
																<td class="sap-field sap-field-text">
																	<div class="sap-input">
																		<div class="sap-input-wrap">
																			<input type="text" name="sap[pdiv][]" value="<?php echo $options['pdiv'];?>" required>
																		</div>
																	</div>
																</td>
																		
																<td class="sap-row-handle remove">
																	<a class="sap-icon -minus small sap-js-tooltip" href="#" data-event="remove-tbl-row" title="<?php echo __( 'Remove row', SAP_PLUGIN_DOMAIN );?>"></a>
																</td>
																		
															</tr>	

														<?php
														}
													}

													?>
													

												</tbody>
											</table>
									
											<div class="sap-actions">
												<a class="sap-button button button-primary" href="#" data-event="add-tbl-row"><?php echo __( 'Add Row', SAP_PLUGIN_DOMAIN );?></a>
											</div>
		
										</div>
									</div>
								</div>

							</div>

						</div>
					</div>					
				</div>
		
			</div>
		
			<br class="clear">
		
		</div>
		
	</form>
	
</div>

<script type="text/html" id="sap_settings_html">
    <tr class="sap-row sap-tbl-row">
																
		<td class="sap-field sap-field-select">
			<div class="sap-input">
				<select name="sap[pages][]" required>
					<?php echo $this->get_all_pages();?>
				</select>
			</div>
		</td>
	
		<td class="sap-field sap-field-text">
			<div class="sap-input">
				<div class="sap-input-wrap">
					<input type="text" name="sap[cdiv][]" required>
				</div>
			</div>
		</td>
	
		<td class="sap-field sap-field-text">
			<div class="sap-input">
				<div class="sap-input-wrap">
					<input type="text" name="sap[pdiv][]" required>
				</div>
			</div>
		</td>
				
		<td class="sap-row-handle remove">
			<a class="sap-icon -minus small sap-js-tooltip" href="#" data-event="remove-tbl-row" title="<?php echo __( 'Remove row', SAP_PLUGIN_DOMAIN );?>"></a>
		</td>
				
	</tr>
</script>

<script type="text/javascript">
	(function($, undefined){
		$( document ).on( 'click', 'a[data-event="add-tbl-row"]', function( e ){
			e.preventDefault();

			var sap_settings_html = $.trim( $( "#sap_settings_html" ).html() );
			$( ".sap-table-main tbody" ).append( sap_settings_html );

			return false;
		});

		$( document ).on( 'click', 'a[data-event="remove-tbl-row"]', function( e ){
			e.preventDefault();

			var r = confirm( "<?php echo __( 'Are you sure?', SAP_PLUGIN_DOMAIN );?>" );
			if ( r == true ) {
				
				$(this).parent().parent().remove();

			}

			return false;
		});
	})(jQuery);
</script>