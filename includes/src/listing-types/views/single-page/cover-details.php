<?php
/**
 * Cover details and actions in the listing type editor.
 *
 * @since 2.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
}

$detail_limit = absint( apply_filters( 'mylisting/type-editor/cover-details/limit', 3 ) );
?>
<div class="tab-content full-width" v-if="currentSubTab == 'cover-details'">
	<div class="form-section">
		<h3>جزییات کاور و دکمه های تماس</h3>
		<p>اطلاعات و اقدامات مهم آگهی را در قسمت کاور آگهی نمایش دهید. بالای <?php echo $detail_limit ?> آیتم برای افزودن</p>
	</div>

	<div class="editor-column col-2-3 rows row-padding">
		<div class="form-section mb10">
			<h4 class="mb5">جزییات فعال</h4>
			<p>برای ویرایش روی جزئیات کلیک کنید برای مرتب کردن مجدد ، آن را بکشید و رها کنید.</p>
		</div>

		<draggable v-model="single.cover_details" :options="{group: 'cover-details-list', handle: '.row-head'}">
			<div v-for="detail, key in single.cover_details" class="row-item" :class="detail === state.single.active_detail ? 'open' : ''">
				<div class="row-head" @click="state.single.active_detail = ( detail !== state.single.active_detail ) ? detail : null">
					<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
					<div class="row-head-label">
						<h4>{{ detail.label }}</h4>
						<div class="details">
							<div class="detail">Field: {{ fieldLabelBySlug( detail.field ) || 'None' }}</div>
						</div>
					</div>
					<div class="row-head-actions">
						<span title="Remove" @click.stop="coverDetails().remove(detail)" class="action red"><i class="mi delete"></i></span>
					</div>
				</div>
				<div class="row-edit">
					<div class="form-group full-width">
						<label>برچسب</label>
						<input type="text" v-model="detail.label">
					</div>

					<div class="form-group full-width">
						<label>فیلد</label>
						<div class="select-wrapper">
							<select v-model="detail.field">
								<option v-for="field in textFields()" :value="field.slug">{{ field.label }}</option>
							</select>
						</div>
					</div>

					<div class="form-group full-width">
						<label>فرمت</label>
						<div class="select-wrapper">
							<select v-model="detail.format">
								<option value="plain">هیچ</option>
								<option value="number">عدد</option>
								<option value="date">تاریخ</option>
								<option value="datetime">تاریخ و ساعت</option>
								<option value="time">ساعت</option>
							</select>
						</div>
					</div>

					<div class="form-group full-width">
						<label>پیشوند</label>
						<input type="text" v-model="detail.prefix">
					</div>

					<div class="form-group full-width">
						<label>پسوند</label>
						<input type="text" v-model="detail.suffix">
					</div>

					<div class="text-right">
						<div class="btn" @click="state.single.active_detail = null">انجام شد</div>
					</div>
				</div>
			</div>
		</draggable>
		<div v-if="single.cover_details.length + single.cover_actions.length >= <?php echo $detail_limit ?>" class="btn btn-plain btn-block">
			<i class="mi error_outline"></i>
			شما به حداکثر جزئیات مجاز رسیده اید (<?php echo $detail_limit ?>).
		</div>
		<div v-else-if="!single.cover_details.length" class="btn btn-plain btn-block mt20">
			<i class="mi playlist_add"></i>
			جزییاتی انتخاب نشده.
		</div>
	</div><!--
	--><div class="editor-column col-1-3" :class="single.cover_details.length + single.cover_actions.length >= <?php echo $detail_limit ?> ? 'ml-overlay-disabled' : ''">
		<div class="form-section mb10">
			<h4 class="mb5">جزییات پیشوند</h4>
			<p>برای استفاده از آن روی جزئیات کلیک کنید.</p>

			<div class="btn btn-block mb10" @click.prevent="coverDetails().add( 'Event date', 'event_date', 'plain' )">تاریخ رویداد</div>
			<div class="btn btn-block mb10" @click.prevent="coverDetails().add( 'Date', 'job_date', 'date' )">تاریخ</div>
			<div class="btn btn-block mb10" @click.prevent="coverDetails().add( 'Price', 'price_range', 'plain' )">قیمت</div>
			<div class="btn btn-block mb10" @click.prevent="coverDetails().add( 'Contact email', 'job_email', 'plain' )">ایمیل</div>

			<div class="text-center mt20">
				<div class="btn btn-outline mb10" @click.prevent="coverDetails().add( 'New detail...' )">افزودن جزییات سفارشی</div>
			</div>
		</div>
	</div>
	<div class="mb40"></div>
	<div class="editor-column col-2-3 rows row-padding">
		<div class="form-section mb10">
			<h4 class="mb5">افزودن دکمه تماس</h4>
			<p>برای ویرایش روی عملیاتی کلیک کنید. برای مرتب کردن مجدد ، آن را بکشید و رها کنید.</p>
		</div>

		<draggable v-model="single.cover_actions" :options="{group: 'cover-actions-list', handle: '.row-head'}">
			<div v-for="action, key in single.cover_actions" class="row-item" :class="action === state.single.active_cover_action ? 'open' : ''">
				<div class="row-head" @click="state.single.active_cover_action = ( action !== state.single.active_cover_action ) ? action : null">
					<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
					<div class="row-head-label">
						<h4>{{ action.label }}</h4>
						<div class="details">
							<div class="detail">{{ action.action }}</div>
						</div>
					</div>
					<div class="row-head-actions">
						<span title="Remove" @click.stop="coverActions().remove(action)" class="action red"><i class="mi delete"></i></span>
					</div>
				</div>
				<div class="row-edit">
					<div class="form-group">
						<label>Icon</label>
						<iconpicker v-model="action.icon"></iconpicker>
					</div>

					<div class="form-group full-width">
						<label>برچسب</label>
						<atwho v-model="action.label" template="input"></atwho>
					</div>

					<div class="form-group full-width" v-if="typeof action.active_label !== 'undefined'">
						<label>برچسب فعال</label>
						<atwho v-model="action.active_label" template="input"></atwho>
					</div>

					<div class="form-group full-width" v-if="typeof action.link !== 'undefined'">
						<label>پیوند به</label>
						<atwho v-model="action.link" template="input" placeholder="e.g. `tel:[[phone]]`"></atwho>
					</div>

					<div class="form-group full-width" v-if="typeof action.open_new_tab !== 'undefined'">
						<label>
							<input type="checkbox" v-model="action.open_new_tab" class="form-checkbox">
							بازکردن پیوند در زبانه تازه
						</label>
					</div>

					<div class="text-right">
						<div class="btn" @click="state.single.active_cover_action = null">Done</div>
					</div>
				</div>
			</div>
		</draggable>
		<div v-if="single.cover_details.length + single.cover_actions.length >= <?php echo $detail_limit ?>" class="btn btn-plain btn-block">
			<i class="mi error_outline"></i>
			شما به حداکثر جزئیات مجاز رسیده اید (<?php echo $detail_limit ?>).
		</div>
		<div v-else-if="!single.cover_actions.length" class="btn btn-plain btn-block mt20">
			<i class="mi playlist_add"></i>
			جزییاتی انتخاب نشده
		</div>
	</div><!--
	--><div class="editor-column col-1-3" :class="single.cover_details.length + single.cover_actions.length >= <?php echo $detail_limit ?> ? 'ml-overlay-disabled' : ''">
		<div class="form-section mb10">
			<h4 class="mb5">عملیات های پیشوند</h4>
			<p>برای استفاده از آن ، روی عملیاتی کلیک کنید.</p>

			<div
				v-for="action in blueprints.quick_actions"
				class="btn btn-block mb10"
				@click.prevent="coverActions().add( action.action )"
				v-if="action.action !== 'custom'"
			>{{ action.label }}</div>

			<div class="text-center mt20">
				<div class="btn btn-outline mb10" @click.prevent="coverActions().add( 'custom' )">عملیات سفارشی را اضافه کنید</div>
			</div>
		</div>
	</div>
</div>
