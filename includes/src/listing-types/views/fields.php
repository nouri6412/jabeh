<div class="tab-content full-width fields-tab">
	<div class="form-section">
		<h3>زمینه هایی را برای این نوع لیست انتخاب یا ایجاد کنید</h3>
		<p>
			کمک نیاز دارید؟ مستندات <a href="https://docs.mylistingtheme.com/article/listing-type-fields-tab/" target="_blank">را مطالعه کنید</a>
			یا تیکت جدیدی در <a href="https://helpdesk.27collective.net/" target="_blank">ایجاد نمایید</a>.
		</p>
	</div>

	<div class="editor-column col-2-3 rows row-padding">
		<div class="form-section mb10">
			<h4 class="mb5">فیلدهای استفاده شده</h4>
			<p>برای ویرایش بر روی یک قسمت کلیک کنید. برای مرتب کردن مجدد ، آن را بکشید و رها کنید.</p>
		</div>

		<draggable v-model="fields.used" :options="{group: 'listing-fields', handle: '.row-head'}">
			<div v-for="field in fields.used" :class="'row-item field-type-'+field.type+' field-name-'+field.slug+' '+(field === state.fields.active ? 'open' : '')">
				<div @click="state.fields.active = ( field !== state.fields.active ) ? field : null" class="row-head">
					<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
					<div class="row-head-label">
						<h4>{{ field.label }}</h4>
						<div class="details">
							<div class="detail" v-if="!field.is_custom">{{ field.default_label ? field.default_label : field.type }}</div>
							<div class="detail" v-if="field.is_custom">{{ capitalize( field.type ) }}</div>
							<div class="detail" v-if="field.is_custom">Custom Field</div>
						</div>
					</div>
					<div class="row-head-actions">
						<span title="Form heading element" class="action violet" v-if="field.type === 'form-heading'"><i class="mi format_size"></i></span>
						<span title="Remove" @click.stop="deleteField(field.slug)" class="action red" v-if="field.slug !== 'job_title'"><i class="mi delete"></i></span>
						<span title="This field cannot be deleted" v-if="field.slug === 'job_title'" class="action gray"><i class="mi lock"></i></span>
					</div>
				</div>
				<div class="row-edit" v-if="state.fields.active === field">
					<?php foreach ( $designer->get_field_types() as $field ): ?>
						<?php echo $field->print_editor_options() ?>
					<?php endforeach ?>
					<div class="text-right">
						<div class="btn" @click="state.fields.active = null">انجام شد</div>
					</div>
				</div>
			</div>
		</draggable>
	</div><!--
	--><div class="editor-column col-1-3">
		<div class="form-section mb10">
			<h4 class="mb5">فیلدهای از پیش تعیین شده</h4>
			<p>برای استفاده روی فیلد کلیک کنید</p>
		</div>

		<div
			v-for="field in editor.preset_fields"
			@click="usePresetField( field.slug )"
			class="btn btn-secondary btn-block mb10"
			v-if="!field._used"
		>{{ field.default_label ? field.default_label : field.label }}</div>

		<div class="form-section mb10 mt40">
			<h4 class="mb5">ایجاد فیلد سفارشی</h4>
			<p>روی نوع فیلدی که می خواهید ایجاد کنید کلیک کنید.</p>

			<div
				v-for="value, key in { all: 'همه', input: 'ورودی', choice: 'انتخاب', relational: 'مرتبط', ui: 'UI', }"
				@click="state.custom_field_category = key"
				class="btn btn-xs mb10"
				:class="state.custom_field_category === key ? 'btn-secondary' : 'btn-plain'"
			>{{ value }}</div>
		</div>

		<div v-if="state.custom_field_category === 'all' || state.custom_field_category === 'input'">
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('text')">متن</div>
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('textarea')">ناحیه متنی</div>
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('wp-editor')">ویرایشگر وردپرس</div>
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('password')">رمز عبور</div>
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('date')">تاریخ</div>
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('recurring-date')">تاریخ تکرار</div>
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('number')">عدد</div>
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('url')">URL</div>
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('email')">ایمیل</div>
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('file')">آپلود فایل</div>
		</div>

		<div v-if="state.custom_field_category === 'all' || state.custom_field_category === 'choice'">
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('select')">انتخاب</div>
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('multiselect')">چند انتخابی</div>
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('checkbox')">چکباکس</div>
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('radio')">دکمه رادیویی</div>
		</div>

		<div v-if="state.custom_field_category === 'all' || state.custom_field_category === 'relational'">
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('related-listing')">آگهی های مرتبط</div>
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('select-product')">انتخاب محصول</div>
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('select-products')">انتخاب چند محصول</div>
		</div>

		<div v-if="state.custom_field_category === 'all' || state.custom_field_category === 'ui'">
			<div class="btn btn-secondary btn-block mb10" @click="addCustomField('form-heading')">عنوان فرم</div>
		</div>
	</div>
</div>

<!-- <pre>{{ fields.used }}</pre> -->
