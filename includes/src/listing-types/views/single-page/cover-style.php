<?php
/**
 * Cover style settings in the listing type editor.
 *
 * @since 2.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
}

$detail_limit = absint( apply_filters( 'mylisting/type-editor/cover-details/limit', 3 ) );
?>
<div class="tab-content full-width" v-if="currentSubTab == 'style'">
	<div class="form-section">
		<h3>بخش کاور را سفارشی سازی کنید</h3>
		<p>
			مطمئن نیستم این چیه؟ <a href="http://docs.mylistingtheme.com/article/single-page-tab-cover-style-cover-details-and-quick-actions/" target="_blank">مشاهده مستندات</a>.
		</p>
	</div>

	<div class="editor-column col-1-4">
		<div class="form-group cover-type">
			<h4 class="mb10">پس زمینه کاور</h4>
			<div class="mb20">
				<label class="mb10"><input type="radio" v-model="single.cover.type" value="image" class="form-radio">تصویر کاور</label>
				<label class="mb10"><input type="radio" v-model="single.cover.type" value="gallery" class="form-radio">گالری اسلایدر</label>
				<label><input type="radio" v-model="single.cover.type" value="none" class="form-radio">هیچ</label>
			</div>
		</div>
	</div><!--
	--><div class="editor-column col-3-4">
		<div class="cover-style" :class="'cover-style-'+single.cover.type">
			<div class="item item-1"></div>
			<div class="item item-2"></div>
			<div class="item item-3"></div>
			<div class="logo"></div>
			<div class="title"></div>
			<div class="desc"></div>
			<div class="detail detail-1"></div>
			<div class="detail detail-2"></div>
			<div class="detail detail-3"></div>
		</div>
	</div>
</div>
