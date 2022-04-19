<?php
/**
 * Similar listings settings template for the listing type editor.
 *
 * @since 2.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<div v-if="currentSubTab == 'similar-listings'" class="tab-content align-center">
	<div class="form-section mb40">
		<h3>فعال کردن آگهی های مشابه</h3>
		<p>
			به صورت اختیاری می توانید لیستی از آگهی های مشابه را در صفحه آگهی تکی نمایش دهید. این بخش در انتهای صفحه، زیر اطلاعات آگهی فعلی ظاهر می شود.
		</p>
		<div class="form-group">
			<label class="form-switch">
				<input type="checkbox" v-model="single.similar_listings.enabled">
				<span class="switch-slider"></span>
			</label>
		</div>
	</div>

	<div :class="!single.similar_listings.enabled?'ml-overlay-disabled':''">
		<div class="form-section mb40">
			<h4 class="mb10">تطبیق لیست های مشابه</h4>
			<p>براساس ویژگی های زیر مشخص کنید که چه چیزی باید به عنوان یک آگهی مشابه با آگهی فعلی طبقه بندی شود.</p>

			<div class="form-group mb10">
				<label>
					<input type="checkbox" v-model="single.similar_listings.match_by_type" class="form-checkbox">
					باید به همان نوع آگهی تعلق داشته باشد.
				</label>
			</div>

			<div class="form-group mb10">
				<label>
					<input type="checkbox" v-model="single.similar_listings.match_by_category" class="form-checkbox">
					حداقل باید یک دسته مشترک داشته باشد.
				</label>
			</div>

			<div class="form-group mb10">
				<label>
					<input type="checkbox" v-model="single.similar_listings.match_by_tags" class="form-checkbox">
					باید حداقل یک برچسب مشترک داشته باشد.
				</label>
			</div>

			<div class="form-group mb10">
				<label>
					<input type="checkbox" v-model="single.similar_listings.match_by_region" class="form-checkbox">
					باید به همان منطقه تعلق داشته باشد (طبقه بندی مناطق).
				</label>
			</div>
		</div>

		<div class="form-section mb40">
			<h4 class="mb10">نمایش آگهی های مشابه</h4>
			<div class="form-group">
				<label>ترتیب آگهی ها بر اساس</label>
				<div class="select-wrapper" style="display: inline-block; width: 160px;">
					<select v-model="single.similar_listings.orderby">
						<option value="priority">اولویت</option>
						<option value="rating">امتیازدهی</option>
						<option value="proximity">محدوده</option>
						<option value="random">رندوم</option>
					</select>
				</div>
			</div>

			<div class="form-group" v-show="single.similar_listings.orderby === 'proximity'">
				<br>
				<label>آگهی باید در شعاع (به کیلومتر) باشد</label>
				<input type="number" v-model="single.similar_listings.max_proximity" style="display: inline-block; width: 100px;">
			</div>

			<div class="form-group">
				<br>
				<label>تعداد آگهی ها برای نمایش</label>
				<input type="number" v-model="single.similar_listings.listing_count" style="display: inline-block; width: 100px;">
			</div>
		</div>
	</div>
</div>