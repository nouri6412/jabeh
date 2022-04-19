<?php
$quick_view_templates = apply_filters( 'mylisting/type-editor/quick-view-templates', [
	'default' => 'Default',
	'alternate' => 'Alternate',
] );
?>
<div v-show="currentSubTab === 'quick-view'" class="tab-content full-width">
	<div class="form-section">
		<h3>حالت نمایش سریع را سفارشی کنید</h3>
		<p>
			کمک نیاز دارید؟ مستندات <a href="http://docs.mylistingtheme.com/article/configuring-the-preview-card-results-template/" target="_blank">را مطالعه کنید.</a>
			یا یک تیکت جدید <a href="https://helpdesk.27collective.net/" target="_blank">ایجاد نمایید</a>.
		</p>
	</div>

	<div class="editor-column col-1-3">
		<div class="form-section">
			<h4>طراحی</h4>

			<div class="form-group mb20">
				<label>قالب</label>
				<div class="select-wrapper">
					<select v-model="result.quick_view.template">
						<?php foreach ( (array) $quick_view_templates as $key => $label ): ?>
							<option value="<?php echo esc_attr( $key ) ?>">
								<?php echo esc_html( $label ) ?>
							</option>
						<?php endforeach ?>
					</select>
				</div>
			</div>

			<div class="form-group" v-show="result.quick_view.template == 'default'">
				<label>پوسته نقشه</label>
				<div class="select-wrapper">
					<select v-model="result.quick_view.map_skin">
						<option v-for="(skin_name, skin_key) in blueprints.map_skins" :value="skin_key">{{ skin_name }}</option>
					</select>
				</div>
			</div>
		</div>
	</div><!--
	--><div class="editor-column col-2-3">
		<div class="quick-view-template" :class="'template-'+result.quick_view.template">
			<div class="background"></div>
			<div class="details">
				<div class="line"></div>
				<div class="line"></div>
				<div class="line"></div>
				<div class="line"></div>
			</div>
			<div class="map"></div>
		</div>
	</div>
</div>
