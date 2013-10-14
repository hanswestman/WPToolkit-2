<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h2>WP Toolkit 2</h2>

	<table cellspacing="0" class="wp-list-table widefat plugins">
		<thead>
			<tr>
				<th style="" class="manage-column column-cb check-column" id="cb" scope="col">
				</th>
				<th style="" class="manage-column column-name" id="name" scope="col">Modules</th>
				<th style="" class="manage-column column-description" id="description" scope="col">Description</th>
			</tr>
		</thead>

		<tfoot>
			<tr>
				<th style="" class="manage-column column-cb check-column" scope="col">
				</th>
				<th style="" class="manage-column column-name" scope="col">Modules</th>
				<th style="" class="manage-column column-description" scope="col">Description</th>
			</tr>
		</tfoot>

		<tbody id="the-list">
			<?php if(!empty($modules)): foreach($modules as $moduleName => $module): ?>
			<tr class="active" id="wp-toolkit-2">
				<th class="check-column" scope="row">
				</th>
				<td class="plugin-title">
					<strong><?php echo($moduleName); ?></strong>
					<div class="row-actions-visible"></div>
				</td><td class="column-description desc">
					<div class="plugin-description">
						<p><?php echo($module['description']); ?></p>
					</div>
					<div class="active second plugin-version-author-uri">
						Version <?php echo($module['version']); ?> | 
						By <?php echo($module['author']); ?>
					</div>		
				</td>
			</tr>
			<?php endforeach; endif; ?>
		</tbody>
	</table>
	
	
	
</div>