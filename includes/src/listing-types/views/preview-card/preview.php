<?php
$preview_card_templates = apply_filters( 'mylisting/type-editor/preview-card-templates', [
	'default' => 'Default',
	'alternate' => 'Alternate',
	'list-view' => 'List view',
] );
?>
<div v-show="currentSubTab === 'preview-card'" class="tab-content full-width">
	<div class="form-section">
		<h3>سفارشی سازی بخش پیشنمایش</h3>
		<p>
			کمک نیاز دارید؟ مستندات <a href="http://docs.mylistingtheme.com/article/configuring-the-preview-card-results-template/" target="_blank">را مطالعه کنید.</a>
			یا یک تیکت در <a href="https://helpdesk.27collective.net/" target="_blank">ایجاد نمایید</a>.
		</p>
	</div>

	<div class="editor-column col-1-3 rows">
		<div class="form-section">
			<h4>طراحی</h4>
			<div class="form-group mb20">
				<label>قالب</label>
				<div class="select-wrapper">
					<select v-model="result.template">
						<?php foreach ( (array) $preview_card_templates as $key => $label ): ?>
							<option value="<?php echo esc_attr( $key ) ?>">
								<?php echo esc_html( $label ) ?>
							</option>
						<?php endforeach ?>
					</select>
				</div>
			</div>

			<div class="form-group" v-show="result.template !== 'list-view'">
				<label>پس زمینه</label>
				<div class="select-wrapper">
					<select v-model="result.background.type">
						<option value="image">تصویر</option>
						<option value="gallery">گالری</option>
					</select>
				</div>
			</div>
		</div>

		<div class="form-section">
			<h4>دکمه های بالا</h4>

			<head-buttons inline-template>
				<div>
					<draggable v-model="$root.result.buttons" :options="{group: 'head-buttons', handle: '.row-head'}">
						<div v-for="button in $root.result.buttons" class="row-item" :class="{open: isActive(button)}">
							<div class="row-head" @click="toggleActive(button)">
								<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
								<div class="row-head-label">
									<h4>
										<span v-for="part in $root.getLabelParts( button.label, '(click to edit)' )"
											:class="'label-part-'+part.type" v-text="part.content"></span>
									</h4>
									<div class="details">
										<div class="detail">دکمه بالا</div>
									</div>
								</div>
								<div class="row-head-actions">
									<span title="Remove" @click.stop="deleteItem(button)" class="action red">
										<i class="mi delete"></i>
									</span>
								</div>
							</div>
							<div class="row-edit" v-if="isActive(button)">
								<div class="form-group">
									<label>برچسب</label>
									<atwho v-model="button.label" template="input"></atwho>
								</div>
								<div class="text-right">
									<div class="btn" @click="setActive(null)">انجام شد</div>
								</div>
							</div>
						</div>
					</draggable>
					<div v-if="!$root.result.buttons.length" class="btn btn-plain btn-block mt20">
						<i class="mi playlist_add"></i>
						دکمه ای افزوده نشده.
					</div>

					<div class="text-center mt20">
						<a class="btn btn-outline" @click.prevent="addItem">افزودن دکمه</a>
					</div>
				</div>
			</head-buttons>

		</div>

		<div class="form-section">
			<h4>فیلدهای زیر عنوان</h4>

			<info-fields inline-template>
				<div>
					<draggable v-model="$root.result.info_fields" :options="{group: 'info-fields', handle: '.row-head'}">
						<div v-for="infoField in $root.result.info_fields" class="row-item" :class="{open: isActive( infoField )}">
							<div class="row-head" @click="toggleActive( infoField )">
								<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
								<div class="row-head-label">
									<h4>
										<span v-for="part in $root.getLabelParts( infoField.label, '(click to edit)' )"
											:class="'label-part-'+part.type" v-text="part.content"></span>
									</h4>
									<div class="details">
										<div class="detail">نمایش زیر عنوان</div>
									</div>
								</div>
								<div class="row-head-actions">
									<span title="Icon" class="action gray" v-if="infoField.icon">
										<i :class="infoField.icon"></i>
									</span>
									<span title="Remove" @click.stop="deleteItem(infoField)" class="action red">
										<i class="mi delete"></i>
									</span>
								</div>
							</div>
							<div class="row-edit" v-if="isActive( infoField )">
								<div class="form-group">
									<label>آیکون</label>
									<iconpicker v-model="infoField.icon"></iconpicker>
								</div>

								<div class="form-group">
									<label>برچسب</label>
									<atwho v-model="infoField.label" template="input"></atwho>
								</div>
								<div class="text-right">
									<div class="btn" @click="setActive(null)">Done</div>
								</div>
							</div>
						</div>
					</draggable>
					<div v-if="!$root.result.info_fields.length" class="btn btn-plain btn-block mt20">
						<i class="mi playlist_add"></i>
						فیلد اطلاعات افزوده نشده.
					</div>

					<div class="text-center mt20">
						<a class="btn btn-outline" @click.prevent="addItem">افزودن فیلد</a>
					</div>
				</div>
			</info-fields>

		</div>

		<div class="form-section">
			<h4>بخش های فوتر</h4>

			<footer-sections ref="footerSections" inline-template>
				<div>
					<draggable v-model="$root.result.footer.sections" :options="{group: 'footer-sections', handle: '.row-head'}">
						<div v-for="section in $root.result.footer.sections" class="row-item" :class="{open: isActive( section )}">
							<div class="row-head" @click="toggleActive( section )">
								<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
								<div class="row-head-label">
									<h4>{{ $root.getFooterSectionTitle( section ) }}</h4>
									<div class="details">
										<div class="detail">بخش فوتر</div>
									</div>
								</div>
								<div class="row-head-actions">
									<span title="Remove" @click.stop="deleteSection( section )" class="action red">
										<i class="mi delete"></i>
									</span>
								</div>
							</div>
							<div class="row-edit">
								<div v-if="section.type === 'categories'">
									<div class="form-group">
										<label>طبقه بندی</label>
										<div class="select-wrapper">
											<select v-model="section.taxonomy">
												<?php $taxonomies = get_taxonomies( [ 'object_type' => [ 'job_listing' ] ], 'objects' ) ?>
												<?php foreach ( (array) $taxonomies as $tax ): ?>
													<option value="<?php echo esc_attr( $tax->name ) ?>">
														<?php echo esc_html( $tax->label ) ?>
													</option>
												<?php endforeach ?>
											</select>
										</div>
									</div>
								</div>

								<div v-if="section.type === 'host'">
									<div class="form-group">
										<label>برچسب</label>
										<atwho v-model="section.label" template="input"></atwho>
									</div>
									<div class="form-group">
										<label>استفاده از فیلد</label>
										<div class="select-wrapper">
											<select v-model="section.show_field">
												<option v-for="field in $root.fieldsByType( [ 'related-listing' ] )"
													:value="field.slug"
												>{{ field.label }}</option>
											</select>
										</div>
									</div>
								</div>

								<div v-if="section.type === 'author'">
									<div class="form-group">
										<label>برچسب</label>
										<atwho v-model="section.label" template="input"></atwho>
									</div>
								</div>

								<div v-if="section.type === 'details'" class="form-group">
									<label class="mb10">جزییات</label>
									<draggable v-model="section.details" :options="{group: 'footer-details', handle: '.row-head'}">
										<div v-for="detail in section.details" class="row-item" :class="{open: activeDetail === detail}">
											<div class="row-head" @click="activeDetail=(activeDetail===detail)?null:detail">
												<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
												<div class="row-head-label">
													<h4>
														<span v-for="part in $root.getLabelParts( detail.label, '(click to edit)' )"
															:class="'label-part-'+part.type" v-text="part.content"></span>
													</h4>
													<div class="details">
														<div class="detail">جزییات</div>
													</div>
												</div>
												<div class="row-head-actions">
													<span title="Remove" @click.stop="deleteDetail( detail, section )" class="action red">
														<i class="mi delete"></i>
													</span>
												</div>
											</div>
											<div class="row-edit">
												<div class="form-group">
													<label>آیکون</label>
													<iconpicker v-model="detail.icon"></iconpicker>
												</div>

												<div class="form-group">
													<label>برچسب</label>
													<atwho v-model="detail.label" template="input"></atwho>
												</div>

												<div class="text-right">
													<div class="btn" @click="activeDetail = null">انجام شد</div>
												</div>
											</div>
										</div>

										<div class="text-center mt10">
											<a class="btn btn-xs btn-outline" @click.prevent="addDetail(section)">افزودن جزییات</a>
										</div>
									</draggable>
								</div>

								<div class="form-group">
									<label class="mb10">دکمه ها</label>
									<label class="mb10">
										<input type="checkbox" v-model="section.show_quick_view_button"
											value="yes" class="form-checkbox">
										نمایش سریع
									</label>
									<label>
										<input type="checkbox" v-model="section.show_bookmark_button"
											value="yes" class="form-checkbox">
										بوکمارک
									</label>
									<label>
										<input type="checkbox" v-model="section.show_compare_button"
											value="yes" class="form-checkbox">
										Add To Comparison
									</label>
								</div>

								<div class="text-right">
									<div class="btn" @click="setActive(null)">انجام شد</div>
								</div>
							</div>
						</div>
					</draggable>

					<div v-if="!$root.result.footer.sections.length" class="btn btn-plain btn-block mt20 mb20">
						<i class="mi playlist_add"></i>
						بخشی افزوده نشده.
					</div>

					<p>یک بخش انتخاب کنید</p>
					<div v-for="section in sectionTypes" class="btn btn-xs mb10"
						@click="addSection( section.type )" style="margin-right: 5px;"
					>{{ $root.getFooterSectionTitle( section ) }}</div>
				</div>
			</footer-sections>
		</div>
	</div><!--
	--><div class="editor-column col-2-3">
		<div class="preview-template" :class="'template-'+result.template">
			<div class="head-buttons">
				<div v-for="button in result.buttons" class="head-button btn btn-xxs">
					<span v-for="part in $root.getLabelParts( button.label, '(empty)' )"
						:class="'label-part-'+part.type" v-text="part.content"></span>
				</div>
				<div class="head-button btn btn-xxs" v-if="!result.buttons.length">(دکمه بالا افزوده نشده)</div>
			</div>

			<div class="background">
				<i class="mi chevron_left left-arrow" v-if="result.background.type === 'gallery'"></i>
				<i class="mi chevron_right right-arrow" v-if="result.background.type === 'gallery'"></i>
			</div>

			<div class="details">
				<div class="logo"></div>
				<div class="title"></div>
				<div class="fields">
					<div v-for="field in result.info_fields" class="field btn btn-xxs btn-plain">
						<span v-for="part in $root.getLabelParts( field.label, '(empty)' )"
							:class="'label-part-'+part.type" v-text="part.content"></span>
					</div>
					<div class="field btn btn-xxs btn-plain" v-if="!result.info_fields.length">(فیلد اطلاعاتی افزوده نشده)</div>
				</div>
			</div>

			<div class="sections">
				<div v-for="section in result.footer.sections" class="section btn btn-xxs btn-plain">
					{{ getFooterSectionTitle( section ) }}
				</div>
				<div class="section btn btn-xxs btn-plain" v-if="!result.footer.sections.length">
					(بخش فوتر افزوده نشده)
				</div>
			</div>
		</div>
	</div>
</div>