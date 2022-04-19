<div class="tab-content align-center" v-if="currentSubTab === 'general'">
	<div class="form-section">
		<h3 class="mb20">برچسب ها</h3>

		<div class="form-group mb20">
			<label>آیکون</label>
			<iconpicker v-model="settings.icon"></iconpicker>
		</div>

		<div class="form-group mb20">
			<label>نام تنها <small>(مثلا تجارت)</small></label>
			<input type="text" v-model="settings.singular_name">
		</div>

		<div class="form-group mb20">
			<label>نام جمع <small>(مثلا تجارت ها)</small></label>
			<input type="text" v-model="settings.plural_name">
		</div>

		<div class="form-group mb20">
			<label>پیوند یکتا <a class="cts-show-tip" data-tip="permalink-docs" title="Click to learn more">[بیشتر]</a></label>
			<input type="text" v-model="settings.permalink" placeholder="<?php echo esc_attr( urldecode( $type->get_permalink_name() ) ) ?>">
		</div>
	</div>
</div>